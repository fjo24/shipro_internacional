<?php
namespace App\Traits;
use App\Retiro;
use SoapClient;
trait Consultar
{

    public function TrackFedex($seguimiento)
    {
        $retiro = Retiro::Where('seguimiento', $seguimiento)->first();

        $path     = public_path();
        $path_to_wsdl = $path.'/fedex/TrackService_v16.wsdl';
        
        ini_set("soap.wsdl_cache_enabled", "0");
        
        $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
        
        $datafedex['WebAuthenticationDetail'] = array(
            'ParentCredential' => array(
                'Key' => 'parentkey',
                'Password' => 'parentpassword'
            ),
            'UserCredential' => array(
                'Key' => 'Nl0m3Q0hZnJEExKF', 
                'Password' => 'SjiweltUrMUvypZb1v9C3j0xU'
                )
            );

$datafedex['ClientDetail'] = array(
    'AccountNumber' => '510087500', 
    'MeterNumber' => '119116801'
);
$datafedex['TransactionDetail'] = array('CustomerTransactionId' => '*** Track request using PHP ***');
$datafedex['Version'] = array(
    'ServiceId' => 'trck', 
	'Major' => '16', 
	'Intermediate' => '0', 
	'Minor' => '0'
);
$datafedex['SelectionDetails'] = array(
    'PackageIdentifier' => array(
        'Type' => 'TRACKING_NUMBER_OR_DOORTAG',
		'Value' =>  $retiro->trackingProveedor// Replace 'XXX' with a valid tracking identifier
        )
    );
    
    try {
        
        $client->__setLocation("https://wsbeta.fedex.com:443/web-services/track");
        
        $response = $client->track($datafedex); // FedEx web service invocation
    $jasonfedex  = json_encode($response);
    /* dd($jasonfedex); */
    
    $arrayfedex = json_decode($jasonfedex, true);
    
    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
        
    } 
    
    // Write to log file   
} catch (SoapFault $exception) {
    printFault($exception, $client);
}

return $arrayfedex;
}

public function TrackUps($datos)
{
    $headers= array('Accept: application/json','Content-Type: application/json');
    $data_string = json_encode($datos);


    $json = '{
        "UPSSecurity": {
            "UsernameToken": {
                "Username": "shiproweb",
                "Password": "Ups2018"
            },
            "ServiceAccessToken": {
                "AccessLicenseNumber": "0D489CC02929F01C"
            }
        },
        "TrackRequest": { 
            "Request": { 
            "RequestOption": "1", 
            "TransactionReference": {
            "CustomerContext": "seguimiento de un tracking" 
            }
        },
        "InquiryNumber": "1Z5V655E0498549207"
        } 
    }';
/*     dd($json); */
    $url = "https://wwwcie.ups.com/rest/Track";  
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json))
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result2 = curl_exec($ch);
    $array_estado = json_decode($result2, true);
    /* $fecha = $array_estado['TrackResponse']['Shipment']['Package']['Activity']['Date'];
    $detalles = $array_estado['TrackResponse']['Shipment']['Package']['Activity']['ActivityLocation']['Address']['CountryCode']; */
    if (isset($array_estado['TrackResponse'])) {
        $estado = $array_estado['TrackResponse']['Shipment']['Package']['Activity']['Status']['Description'];
    }else{
        $estado=null;
    }
    $arrayups = array("estado"=> $estado);
    return $arrayups;

}
  
}