<?php

namespace App\Http\Controllers\Couriers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Destination;
use Illuminate\Support\Facades\DB;
use App\Fos_user;
use App\Comprador;
use App\Retiro;
use App\Cliente;
use MP;
use Mercadopago;
use Illuminate\Support\Collection;
use App\Cpcordon;
use App\Sender;
use App\Cordon;
use App\Datosprestador;
use App\Sucursal;
use SoapClient;
use App\Nodo;
use App\User;
use App\Servicio;
use Illuminate\Support\Facades\Auth;
use App\Pais;
use App\Http\Requests\OrderRequest;
use App\Tipo_documento;
use Carbon\Carbon;
use App\Provincia;

class ApisController extends Controller
{



  public function consultarpago($data)
  {
    $mp = new MP ("3080451303981997", "UxvQkyKoXSzyzWxzY3iJQCBSPjUtIkUG");
    $params = ["access_token" => $mp->get_access_token()];

        // Check mandatory parameters
    if (!isset($data['pago']['id']) || !ctype_digit($data['pago']['id'])) {
      http_response_code(400);
      return;
    }
    // Get the payment reported by the IPN. Glossary of attributes response in https://developers.mercadopago.com
    
    if($data['pago']['topic'] == 'payment'){
      $payment_info = $mp->get("/v1/payments/" . $data['pago']['id'], $params, false);
      $merchant_order_info = $mp->get("/merchant_orders/" . $payment_info["response"]["order"]["id"], $params, false);
    // Get the merchant_order reported by the IPN. Glossary of attributes response in https://developers.mercadopago.com  
      
    }else if($data['pago']['topic'] == 'merchant_order'){
      $merchant_order_info = $mp->get("/merchant_orders/" . $data['pago']['id'], $params, false);
    }
    $payment_info = $mp->get("/v1/payments/" . $data['pago']['id'], $params, false);
      $merchant_order_info = $mp->get("/merchant_orders/" . $payment_info["response"]["order"]["id"], $params, false);
    //If the payment's transaction amount is equal (or bigger) than the merchant order's amount you can release your items 
    if ($merchant_order_info["status"] == 200) {
      $transaction_amount_payments= 0;
      $transaction_amount_order = $merchant_order_info["response"]["total_amount"];
        $payments=$merchant_order_info["response"]["payments"];
        foreach ($payments as  $payment) {
          if($payment['status'] == 'approved'){
            $transaction_amount_payments += $payment['transaction_amount'];
          } 
        }
        if($transaction_amount_payments >= $transaction_amount_order){
          echo "release your items";
        }
        else{
        echo "dont release your items";
      }
    }
  }

  public function GenerarPagoExterno($data)
  {
      
      $fecha_referencia = Carbon::now()->format('YmdHis');
      /* dd($data['servicio']['precio']); */
      /* dd($data); */
      /* $mp = new MP (env('MERCADOPAGO_CLIENTE_ID'), env('MERCADOPAGO_CLIENTE_SECRET')); */
      $mp = new MP ("3080451303981997", "UxvQkyKoXSzyzWxzY3iJQCBSPjUtIkUG");
      $mp->sandbox_mode(TRUE);
      $sucursal = Sucursal::Where('descripcion', $data['remitente']['sucursal'])->first();
      $current_user = User::Where('sucursal_id', $sucursal->id)->first();
      $access_token = $mp->get_access_token();
      $status_orden = "approved";
      
      $preference_data = array(
          'external_reference' => 'SHIPRO00'.$current_user->id.''.$fecha_referencia,      
          "items" => array(
              array(
                  "id" => $current_user->id.''.$fecha_referencia,
                  "title" => "Compra a traves de Shipro",
                  "currency_id" => "USD",
                  "description" => "Compra a traves de Shipro",
                  "quantity" => 1,
                  "unit_price" => (float)$data['servicio']['precio']
                  )
                ),
                "payment_methods" => array(
                    "excluded_payment_types" => array(
                        array("id" => "ticket"),
                        array("id" => "bank_transfer"),
                        array("id" => "atm"))
                    ),
                    "payer" => array(
                        "name" => $current_user->name,
                        "email" => $current_user->email, 
                        "date_created" => Carbon::now(),
                        "address" => array(
                            "street_name" => $data['remitente']['calle'],
                            "zip_code" => $data['remitente']['cp'],
                            )
                        ),
                        "back_urls" => array(
                            "success" => route('apiscreateshipment', compact('data')),
                            /* "pending" => url()->previous(), */
                            "failure" => url()->previous(),
                        ),
                    );
                    /* dd($preference_data); */
                    $preference = $mp->create_preference($preference_data);
                    
                    $mercadolibre = array(
                        "id" => $preference['response']['id'], 
                        "confirmacion_url" => $preference['response']['sandbox_init_point'], 
                        "id_mercadopago" => $preference['response']['items'][0]['id'],
                        "precio" => $preference['response']['items'][0]['unit_price'],
                        "moneda" => $preference['response']['items'][0]['currency_id'],  
                        "referencia_shipro" => $preference['response']['external_reference']);
                        
                        return $mercadolibre; 
                    }

}
                





/* 



public function ValidarCpFedex()
{
    define('Newline',"<br />");

echo 'PHP_Common initialized ';
function printSuccess($client, $response) {
printReply($client, $response);
}

function printReply($client, $response){
$highestSeverity=$response->HighestSeverity;
if($highestSeverity=="SUCCESS"){echo '<h2>The transaction was successful.</h2>';}
if($highestSeverity=="WARNING"){echo '<h2>The transaction returned a warning.</h2>';}
if($highestSeverity=="ERROR"){echo '<h2>The transaction returned an Error.</h2>';}
if($highestSeverity=="FAILURE"){echo '<h2>The transaction returned a Failure.</h2>';}
echo "\n";
printNotifications($response -> Notifications);
printRequestResponse($client, $response);
}

function printRequestResponse($client){
echo '<h2>Request</h2>' . "\n";
echo '<pre>' . htmlspecialchars($client->__getLastRequest()). '</pre>';  
echo "\n";

echo '<h2>Response</h2>'. "\n";
echo '<pre>' . htmlspecialchars($client->__getLastResponse()). '</pre>';
echo "\n";
}


function printFault($exception, $client) {
echo '<h2>Fault</h2>' . "<br>\n";                        
echo "<b>Code:</b>{$exception->faultcode}<br>\n";
echo "<b>String:</b>{$exception->faultstring}<br>\n";
writeToLog($client);
writeToLog($exception);

echo '<h2>Request</h2>' . "\n";
echo '<pre>' . htmlspecialchars($client->__getLastRequest()). '</pre>';  
echo "\n";
}
                                  
function writeToLog($client){  

if (!$logfile = fopen(__DIR__.'/fedextransactions.log', "a"))
{
       error_func("Cannot open " . __DIR__.'/fedextransactions.log' . " file.\n", 0);
       exit(1);
}

 fwrite($logfile, sprintf("\r%s:- %s",date("D M j G:i:s T Y"), $client->__getLastRequest(). "\r\n" . $client->__getLastResponse()."\r\n\r\n"));

}


function getProperty($var){

if($var == 'key') Return 'xxxxxxxx'; 
if($var == 'password') Return 'xxxxxxxxxxx'; 
if($var == 'parentkey') Return 'xxxxxxxxxxx'; 
if($var == 'parentpassword') Return 'xxxxxxxxxx'; 
if($var == 'shipaccount') Return 'xxxxx';
if($var == 'billaccount') Return 'xxxxx';
if($var == 'dutyaccount') Return 'xxxxxx'; 
if($var == 'freightaccount') Return 'xxxxxxxxx';  
if($var == 'trackaccount') Return 'xxxxxx'; 
if($var == 'dutiesaccount') Return 'xxxxxxx';
if($var == 'importeraccount') Return 'xxxxxx';
if($var == 'brokeraccount') Return 'xxxxxxx';
if($var == 'distributionaccount') Return 'xxxxxxxxx';
if($var == 'locationid') Return 'PLBA';
if($var == 'printlabels') Return true;
if($var == 'printdocuments') Return true;
if($var == 'packagecount') Return '4';
if($var == 'validateaccount') Return 'XXX';
if($var == 'meter') Return 'xxxxxxxx';
    
if($var == 'shiptimestamp') Return mktime(10, 0, 0, date("m"), date("d")+1, date("Y"));

if($var == 'spodshipdate') Return '2018-05-08';
if($var == 'serviceshipdate') Return '2018-05-07';
if($var == 'shipdate') Return '2018-05-08';

if($var == 'readydate') Return '2014-12-15T08:44:07';

if($var == 'closedate') Return '2016-04-18';
if($var == 'pickupdate') Return date("Y-m-d", mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));
if($var == 'pickuptimestamp') Return mktime(8, 0, 0, date("m")  , date("d")+1, date("Y"));
if($var == 'pickuplocationid') Return 'SQLA';
if($var == 'pickupconfirmationnumber') Return '1';

if($var == 'dispatchdate') Return date("Y-m-d", mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));
if($var == 'dispatchlocationid') Return 'NQAA';
if($var == 'dispatchconfirmationnumber') Return '4';		

if($var == 'tag_readytimestamp') Return mktime(10, 0, 0, date("m"), date("d")+1, date("Y"));
if($var == 'tag_latesttimestamp') Return mktime(20, 0, 0, date("m"), date("d")+1, date("Y"));	

if($var == 'expirationdate') Return date("Y-m-d", mktime(8, 0, 0, date("m"), date("d")+15, date("Y")));
if($var == 'begindate') Return '2014-10-16';
if($var == 'enddate') Return '2014-10-16';	

if($var == 'trackingnumber') Return 'XXX';

if($var == 'hubid') Return '5531';

if($var == 'jobid') Return 'XXX';

if($var == 'searchlocationphonenumber') Return '5555555555';
if($var == 'customerreference') Return '39589';

if($var == 'shipper') Return array(
    'Contact' => array(
        'PersonName' => 'Sender Name',
        'CompanyName' => 'Sender Company Name',
        'PhoneNumber' => '1234567890'
    ),
    'Address' => array(
        'StreetLines' => array('Addres \r  s Line 1'),
        'City' => 'Collierville',
        'StateOrProvinceCode' => 'TN',
        'PostalCode' => '38017',
        'CountryCode' => 'US',
        'Residential' => 1
    )
);
if($var == 'recipient') Return array(
    'Contact' => array(
        'PersonName' => 'Recipient Name',
        'CompanyName' => 'Recipient Company Name',
        'PhoneNumber' => '1234567890'
    ),
    'Address' => array(
        'StreetLines' => array('Address Line 1'),
        'City' => 'Herndon',
        'StateOrProvinceCode' => 'VA',
        'PostalCode' => '20171',
        'CountryCode' => 'US',
        'Residential' => 1
    )
);	

if($var == 'address1') Return array(
    'StreetLines' => array('10 Fed Ex Pkwy'),
    'City' => 'Memphis',
    'StateOrProvinceCode' => 'TN',
    'PostalCode' => '38115',
    'CountryCode' => 'US'
);
if($var == 'address2') Return array(
    'StreetLines' => array('13450 Farmcrest Ct'),
    'City' => 'Herndon',
    'StateOrProvinceCode' => 'VA',
    'PostalCode' => '20171',
    'CountryCode' => 'US'
);					  
if($var == 'searchlocationsaddress') Return array(
    'StreetLines'=> array('240 Central Park S'),
    'City'=>'Austin',
    'StateOrProvinceCode'=>'TX',
    'PostalCode'=>'78701',
    'CountryCode'=>'US'
);
                                  
if($var == 'shippingchargespayment') Return array(
    'PaymentType' => 'SENDER',
    'Payor' => array(
        'ResponsibleParty' => array(
            'AccountNumber' => getProperty('billaccount'),
            'Contact' => null,
            'Address' => array('CountryCode' => 'US')
        )
    )
);	
if($var == 'freightbilling') Return array(
    'Contact'=>array(
        'ContactId' => 'freight1',
        'PersonName' => 'Big Shipper',
        'Title' => 'Manager',
        'CompanyName' => 'Freight Shipper Co',
        'PhoneNumber' => '1234567890'
    ),
    'Address'=>array(
        'StreetLines'=>array(
            '1202 Chalet Ln', 
            'Do Not Delete - Test Account'
        ),
        'City' =>'Harrison',
        'StateOrProvinceCode' => 'AR',
        'PostalCode' => '72601-6353',
        'CountryCode' => 'US'
        )
);
}

function setEndpoint($var){
if($var == 'changeEndpoint') Return true;
if($var == 'endpoint') Return 'xxx';
}

function printNotifications($notes){
foreach($notes as $noteKey => $note){
    if(is_string($note)){    
        echo $noteKey . ': ' . $note . Newline;
    }
    else{
        printNotifications($note);
    }
}
echo Newline;
}

function printError($client, $response){
printReply($client, $response);
}

function trackDetails($details, $spacer){
foreach($details as $key => $value){
    if(is_array($value) || is_object($value)){
        $newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<tr><td>'. $spacer . $key.'</td><td>&nbsp;</td></tr>';
        trackDetails($value, $newSpacer);
    }elseif(empty($value)){
        echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
    }else{
        echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
    }
}
}
$newline = "<br />";


$path     = public_path();
$path_to_wsdl = $path.'/fedex/CountryService_v8.wsdl';

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array(
'ParentCredential' => array(
    'Key' => 'parentkey',
    'Password' => 'parentpassword'
),
'UserCredential' => array(
    'Key' => 'Nl0m3Q0hZnJEExKF', 
    'Password' => 'SjiweltUrMUvypZb1v9C3j0xU'
)
); 

$request['ClientDetail'] = array(
'AccountNumber' => '510087500', 
'MeterNumber' => '119116801'
);
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Validate Postal Code Request using PHP ***');
$request['Version'] = array(
'ServiceId' => 'cnty', 
'Major' => '8', 
'Intermediate' => '0', 
'Minor' => '0'
);

$request['Address'] = array(
'PostalCode' => 10001,
'CountryCode' => 'US'
);

$request['CarrierCode'] = 'FDXE';


try {

$client->__setLocation("https://wsbeta.fedex.com:443/web-services/cnty");

$response = $client -> validatePostal($request);
$jasonfedex  = json_encode($response);
$arrayfedex = json_decode($jasonfedex, true);
dd($arrayfedex);
    
if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){  	
    printSuccess($client, $response);


    echo "<table>\n";
    printPostalDetails($response -> PostalDetail, "");
    echo "</table>\n";

}else{
    printError($client, $response);
} 

writeToLog($client);   
} catch (SoapFault $exception) {
printFault($exception, $client);        
}

function printString($spacer, $key, $value){
if(is_bool($value)){
    if($value)$value='true';
    else $value='false';
}
echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
}

function printPostalDetails($details, $spacer){
foreach($details as $key => $value){
    if(is_array($value) || is_object($value)){
        $newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<tr><td>'. $spacer . $key.'</td><td>&nbsp;</td></tr>';
        printPostalDetails($value, $newSpacer);
    }elseif(empty($value)){
        printString($spacer, $key, $value);
    }else{
        printString($spacer, $key, $value);
    }
}
}

} */