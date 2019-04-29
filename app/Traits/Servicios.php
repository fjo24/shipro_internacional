<?php
namespace App\Traits;
use SoapClient;
use App\Nodo;
use App\Provincia;
trait Servicios
{

    public function ServiciosFedex($data)
    {

        if(($data['paquete'][0]['largo']<=30)
        &&($data['paquete'][0]['ancho']<=5)
        &&($data['paquete'][0]['largo']<=22)
        &&($data['paquete'][0]['peso']<=2.5)){
            $paquete = 'FEDEX_PAK';
        }else{
            $paquete = 'FEDEX_PAK';
        }
        if (($data['remitente']['pais'] == "CA")&&($data['remitente']['pais'] == "US")){
            $ciudad = Provincia::Where('codigo', $data['remitente']['codigo_provincia'])->first();
            $ciudad = $ciudad->descripcion_en;
        }else{
            $ciudad = $data['remitente']['provincia'];
        }
        if ($data['destinatario']['codigo_provincia']) {
            $ciudad2 = Provincia::Where('codigo', $data['destinatario']['codigo_provincia'])->first();
            $ciudad2 = $ciudad2->descripcion_en;
        }else{
            $ciudad2 = $data['destinatario']['provincia'];
        }
        $volumetric_weight = ($data['paquete'][0]['largo'] * $data['paquete'][0]['ancho'] * $data['paquete'][0]['alto']) / 5000;
        $peso_final = $data['paquete'][0]['peso'];
        if ($volumetric_weight > $peso_final) {
            $peso_final = $volumetric_weight;
        }
        //FEDEX--> INICIO
    function writeToLog($client){  
      if (!$logfile = fopen(__DIR__.'/logs/fedex/fedextransactions.log', "a"))
      {
          error_func("Cannot open " . __DIR__.'/logs/fedex/fedextransactions.log' . " file.\n", 0);
          exit(1);
      }
  
      fwrite($logfile, sprintf("\r%s:- %s",date("D M j G:i:s T Y"), $client->__getLastRequest(). "\r\n" . $client->__getLastResponse()."\r\n\r\n"));
   
  }
  
  function setEndpoint($var){
      if($var == 'changeEndpoint') Return true;
      if($var == 'endpoint') Return 'xxx';
  }

  $path     = public_path();
  $path_to_wsdl = $path.'/fedex/RateService_v24.wsdl';
  /* $path_to_wsdl = "http://internacional.shipro.pro/fedex/RateService_v24.wsdl"; */
/*   $path_to_wsdl = "fedex\RateService_v24.wsdl"; */
  
  ini_set("soap.wsdl_cache_enabled", "0");
   
  $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
  
  //credenciales de produccion
  $datafedex['WebAuthenticationDetail'] = array(
	'ParentCredential' => array(
        'Key' => 'parentkey',
        'Password' => 'parentpassword'
    ),
    'UserCredential' => array(
        'Key' => '2gRzDvjSLAr0EbPc', 
        'Password' => 'UskpnCPYpXbr5DFgtjHmG3gCM'
    )
);

$datafedex['ClientDetail'] = array(
	'AccountNumber' => '961601975', 
      'MeterNumber' => '114520800'
);
//credenciales de testing
/*   $datafedex['WebAuthenticationDetail'] = array(
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
  ); */
  
  $datafedex['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Available Services Request using PHP ***');
  $datafedex['Version'] = array(
      'ServiceId' => 'crs', 
      'Major' => '24', 
      'Intermediate' => '0', 
      'Minor' => '0'
  );
  $datafedex['ReturnTransitAndCommit'] = true;
  
  $datafedex['RequestedShipment'] = array(
      'DropoffType' => 'REGULAR_PICKUP',
      'PackagingType' => $paquete,
      'ShipTimestamp' => date('c'),
       'Shipper' => array(
          'Address'=> array(
                      'StreetLines' => array($data['remitente']['calle']. " " .$data['remitente']['altura']),
                      'City' => $ciudad,
                      'StateOrProvinceCode' => $data['remitente']['codigo_provincia'],
                      'PostalCode' => $data['remitente']['cp'],
                      'CountryCode' => $data['remitente']['pais']
          ),
      ),
      
      'Recipient' => array(
          'Address'=> array(
            'StreetLines' => array($data['destinatario']['calle']. " " .$data['destinatario']['altura']),
            'City' => $ciudad2,
            'StateOrProvinceCode' => $data['destinatario']['codigo_provincia'],
            'PostalCode' => $data['destinatario']['cp'],
            'CountryCode' => $data['destinatario']['pais']
                    /* 'StreetLines' => array('10 Fed Ex Pkwy'),
                    'City' => 'Memphis',
                    'StateOrProvinceCode' => 'IN',
                    'PostalCode' => $request->cp2,
                    'CountryCode' => $pais_destino->iata_pais */
          ),
      ),
      'ShippingChargesPayment' => array('PaymentType' => 'SENDER',
        'Payor' => array(
            'ResponsibleParty' => array(
                'AccountNumber' => '961601975',
                'Contact' => null,
                'Address' => array(
                    'CountryCode' => $data['remitente']['pais']
                )
            )
        )
    ),
      'CustomsClearanceDetail' => array(
        'DutiesPayment' => array(
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => '961601975',
                    'Contact' => null,
                    'Address' => array(
                        'CountryCode' => $data['remitente']['pais']
                    )
                )
            )
        ),
        'DocumentContent' => 'NON_DOCUMENTS',                                                                                            
        'CustomsValue' => array(
            'Currency' => 'USD', 
            'Amount' => $data['paquete'][0]['valor_fob']
        ),
        'Commodities' => array(
            '0' => array(
                'NumberOfPieces' => 1,
                'Description' => 'Pack',
                'CountryOfManufacture' => 'US',
                'Weight' => array(
                    'Units' => 'KG', 
                    'Value' => 1.0
                ),
                'Quantity' => 1,
                'QuantityUnits' => 'EA',
                'UnitPrice' => array(
                    'Currency' => 'USD', 
                    'Amount' => $data['paquete'][0]['valor_fob']
                ),
                'CustomsValue' => array(
                    'Currency' => 'USD', 
                    'Amount' => $data['paquete'][0]['valor_fob']
                )
            )
        ),
        'ExportDetail' => array(
            'B13AFilingOption' => 'NOT_REQUIRED'
        )
        ),                                                                                                       
	'LabelSpecification' => array(
        'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
        'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
        'LabelStockType' => 'PAPER_7X4.75'
    ),
      'CustomerSpecifiedDetail' => array(
		'MaskedData'=> 'SHIPPER_ACCOUNT_NUMBER'
	), 
  
      'PackageCount' => '1',
          'RequestedPackageLineItems' => array(
          '0' => array(
              'SequenceNumber' => 1,
              'GroupPackageCount' => 1,
              'Weight' => array(
                  'Value' => $peso_final,
                  'Units' => 'KG'
              ),
              'Dimensions' => array(
                  'Length' => $data['paquete'][0]['largo'],
                  'Width' => $data['paquete'][0]['ancho'],
                  'Height' => $data['paquete'][0]['alto'],
                  'Units' => 'CM'
              )
          )
      ),
  
  );
/* dd($datafedex);  */
  try {
      /* if(setEndpoint('changeEndpoint')){
          $newLocation = $client->__setLocation(setEndpoint('endpoint'));
      } */
      //end point testing
      /* $client->__setLocation("https://wsbeta.fedex.com:443/web-services/rate"); */
      
      //end point testing
      $client->__setLocation("https://ws.fedex.com:443/web-services/rate");
      $response = $client ->getRates($datafedex);
      $jasonfedex  = json_encode($response);
      $arrayfedex = json_decode($jasonfedex, true);

      if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){

      }
      writeToLog($client);    // Write to log file   
  } catch (SoapFault $exception) {
     printFault($exception, $client);        
    }
    /* dd($arrayfedex); */
    return $arrayfedex;
          //FEDEX--> FIN
    }

//**********************UPS************************/
//**********************UPS************************/
//**********************UPS************************/
//**********************UPS************************/
//**********************UPS************************/
//**********************UPS************************/

    public function ServiciosUps($data){
        $nodo = Nodo::Where('sucursal', 'internacional')->first();
        if ($data['remitente']['codigo_provincia']) {
            $ciudad = Provincia::Where('codigo', $data['remitente']['codigo_provincia'])->first();
            $ciudad = $ciudad->descripcion_en;
        }else{
            $ciudad = $data['remitente']['provincia'];
        }
        if ($data['destinatario']['codigo_provincia']) {
            $ciudad2 = Provincia::Where('codigo', $data['destinatario']['codigo_provincia'])->first();
            $ciudad2 = $ciudad2->descripcion_en;
        }else{
            $ciudad2 = $data['destinatario']['provincia'];
        }
        
        $volumetric_weight = ($data['paquete'][0]['largo'] * $data['paquete'][0]['ancho'] * $data['paquete'][0]['alto']) / 5000;
        $peso_final = $data['paquete'][0]['peso'];
        if ($volumetric_weight > $peso_final) {
            $peso_final = $volumetric_weight;
        }
        $headers = array('Accept: application/json', 'Content-Type: application/json');

        $json1 = '{
            "UPSSecurity": {
                "UsernameToken": {
                    "Username": "'.$nodo->username.'",
                    "Password": "'.$nodo->password.'"
                },
                "ServiceAccessToken": {
                    "AccessLicenseNumber": "0D489CC02929F01C"
                }
            },
            "RateRequest": {
                "Request": {
                    "RequestOption": "Rate",
                    "TransactionReference": {
                        "CustomerContext": "Consultar Precio"
                    }
                },
                "Shipment": {
                    "Shipper": {
                        "Name": "'.$data['remitente']['sucursal'].'",
                        "ShipperNumber": "5V655E",
                        "Address": {
                            "AddressLine": [
                                "'.$data['remitente']['calle'].' '.$data['remitente']['altura'].'"
                            ],
                            "City": "'.$ciudad.'",
                            "StateProvinceCode": "'.$data['remitente']['codigo_provincia'].'",
                            "PostalCode": "'.$data['remitente']['cp'].'",
                            "CountryCode": "'.$data['remitente']['pais'].'"
                        }
                    },
                    "ShipTo": {
                        "Name": "'.$data['destinatario']['destinatario'].'",
                        "Address": {
                            "AddressLine": [
                                "'.$data['destinatario']['calle'].' '.$data['destinatario']['altura'].'"
                            ],
                            "City": "'.$ciudad2.'",
                            "PostalCode": "'.$data['destinatario']['cp'].'",
                            "StateProvinceCode": "'.$data['destinatario']['codigo_provincia'].'",
                            "CountryCode": "'.$data['destinatario']['pais'].'"
                        }
                    },
                    "ShipFrom": {
                        "Name": "'.$data['remitente']['sucursal'].'",
                        "Address": {
                            "AddressLine": [
                                "'.$data['remitente']['calle'].' '.$data['remitente']['altura'].'"
                            ],
                            "City": "'.$ciudad.'",
                            "StateProvinceCode": "'.$data['remitente']['codigo_provincia'].'",
                            "PostalCode": "'.$data['remitente']['cp'].'",
                            "CountryCode": "'.$data['remitente']['pais'].'"
                        }
                    },
                    "Service": {
                        "Code": "65",
                        "Description": "saver"
                    },
                    "Package": {
                        "PackagingType": {
                            "Code": "'.$data['paquete'][0]['tipo_paquete'].'",
                            "Description": "Rate"
                        },
                        "PackageWeight": {
                            "UnitOfMeasurement": {
                                "Code": "kgs",
                                "Description": "KILOS"
                            },
                            "Weight": "'.$peso_final.'"
                        }
                    },
                    "ShipmentRatingOptions": {
                        "NegotiatedRatesIndicator": ""
                    }
                }
            }
            }';
            /* dd($json1); */

                $url2=$nodo->url."Rate";
                $ch = curl_init($url2);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json',
                  'Content-Length: ' . strlen($json1))
                );
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json1);
                $result2 = curl_exec($ch);
               
                $array_servicios=json_decode($result2);
                /* dd($array_servicios); */
                    $precio = $array_servicios->RateResponse->RatedShipment->TransportationCharges->MonetaryValue;
                    /*   $array_ups = array(); */
                    $array_ups = array("id"=>$nodo->id, "proveedor"=>$nodo->proveedor, "servicion"=>$nodo->desc, 
                    "precio"=> $precio);
                
        return $array_ups;
    }
  
}