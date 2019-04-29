<?php
namespace App\Traits;
use App\Provincia;
use App\Servicio;
use SoapClient;
trait Crearenvio
{

    public function CreateShipmentFedex($data)
    {
        if(($data['paquete'][0]['largo']<=30)
        &&($data['paquete'][0]['ancho']<=5)
        &&($data['paquete'][0]['largo']<=22)
        &&($data['paquete'][0]['peso']<=2.5)){
            $paquete = 'FEDEX_PAK';
        }else{
            $paquete = 'FEDEX_PAK';
        }
        $volumetric_weight = ($data['paquete'][0]['largo'] * $data['paquete'][0]['ancho'] * $data['paquete'][0]['alto']) / 5000;
        $peso_final = $data['paquete'][0]['peso'];
        if ($volumetric_weight > $peso_final) {
            $peso_final = $volumetric_weight;
        }
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
                           
    function writeToshipLog($client){  
        if (!$logfile = fopen(__DIR__.'/logs/fedex/fedex_ship.log', "a"))
        {
            error_func("Cannot open " . __DIR__.'/logs/fedex/fedex_ship.log' . " file.\n", 0);
            exit(1);
        }
    
         fwrite($logfile, sprintf("\r%s:- %s",date("D M j G:i:s T Y"), $client->__getLastRequest(). "\r\n" . $client->__getLastResponse()."\r\n\r\n"));
     
    }
    
    //The WSDL is not included with the sample code.
    //Please include and reference in $path_to_wsdl variable.
    $path     = public_path();
    $path_to_wsdl = $path.'/fedex/ShipService_v23.wsdl';

    ini_set("soap.wsdl_cache_enabled", "0");
    
    $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

/* $datafedex['WebAuthenticationDetail'] = array(
	'ParentCredential' => array(
        'Key' => 'parentkey',
        'Password' => 'parentpassword'
    ),
    'UserCredential' => array(
        'Key' => 'NlC7G3h5qNzSsEkT', 
        'Password' => '7zdWkzITN9X9lYg6LHQZUkA1H'
    )
);

$datafedex['ClientDetail'] = array(
	'AccountNumber' => '961601975', 
      'MeterNumber' => '114520359'
); */
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
$datafedex['TransactionDetail'] = array('CustomerTransactionId' => '*** Express International Shipping Request using PHP ***');
$datafedex['Version'] = array(
	'ServiceId' => 'ship', 
	'Major' => '23', 
	'Intermediate' => '0', 
	'Minor' => '0'
);
$datafedex['RequestedShipment'] = array(
	'ShipTimestamp' => date('c'),
	'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
	'ServiceType' => $data['servicio']['id'], // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
	'PackagingType' => $paquete, // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
	'Shipper' => array(
        'Contact' => array(
            'PersonName' => $data['remitente']['sucursal'],
            'CompanyName' => $data['remitente']['sucursal'],
            'PhoneNumber' => $data['remitente']['telefono']
        ),
        'Address' => array(
            'StreetLines' => array($data['remitente']['calle'].' '.$data['remitente']['altura']),
            'City' => $ciudad,
            'StateOrProvinceCode' => $data['remitente']['codigo_provincia'],
            'PostalCode' => $data['remitente']['cp'],
            'CountryCode' => $data['remitente']['pais']
        )
        ),
	'Recipient' => array(
        'Contact' => array(
            'PersonName' => $data['destinatario']['destinatario'],
            'CompanyName' => $data['destinatario']['destinatario'],
            'PhoneNumber' => $data['destinatario']['telefono']
        ),
        'Address' => array(
            'StreetLines' => array($data['destinatario']['calle'].' '.$data['destinatario']['altura']),
            'City' => $ciudad2,
            'StateOrProvinceCode' => $data['destinatario']['codigo_provincia'],
            'PostalCode' => $data['destinatario']['cp'],
            'CountryCode' => $data['destinatario']['pais'],
            'Residential' => false
        )
    ),
	'ShippingChargesPayment' => array('PaymentType' => 'SENDER',
        'Payor' => array(
            'ResponsibleParty' => array(
                'AccountNumber' => '510087500',
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
                    'AccountNumber' => '510087500',
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
                'Description' => 'Books',
                'CountryOfManufacture' => 'US',
                'Weight' => array(
                    'Units' => 'KG', 
                    'Value' => 0.1
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
	'PackageCount' => 1,
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
	'CustomerReferences' => array(
		'0' => array(
			'CustomerReferenceType' => 'CUSTOMER_REFERENCE', 
			'Value' => 'TC007_07_PT1_ST01_PK01_SNDUS_RCPCA_POS'
		)
	)
);

/////
try{
/* 	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	} */
	$client->__setLocation("https://wsbeta.fedex.com:443/web-services/ship");
	$response = $client->processShipment($datafedex); // FedEx web service invocation
    $jasonfedex  = json_encode($response);
    $arrayfedex = json_decode($jasonfedex, true);
    
    if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){
       /*  printSuccess($client, $response); */
       // Create PNG or PDF label
        // Guardar etiqueta en pdf
        define('SHIP_LABEL', 'fedex/etiquetas/'. $arrayfedex['CompletedShipmentDetail']['MasterTrackingId']['TrackingNumber'] .'.pdf');  // PDF label file. Change to file-extension .pdf for creating a PDF label (e.g. shiplabel.pdf)
        $fp = fopen(SHIP_LABEL, 'wb');   
        fwrite($fp, ($response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image));
        fclose($fp);
        /* echo 'Label <a href="./'.SHIP_LABEL.'">'.SHIP_LABEL.'</a> was generated.';   */          
    }else{
        /* printError($client, $response); */
    }

	writeToshipLog($client);    // Write to log file
    } catch (SoapFault $exception) {
        printFault($exception, $client);
    }
    $url = '/fedex/etiquetas/'.$arrayfedex['CompletedShipmentDetail']['MasterTrackingId']['TrackingNumber'] .'.pdf';
    $servicio = Servicio::Where('descripcion', $arrayfedex['CompletedShipmentDetail']['ServiceDescription']['ServiceType'])->first();
    $id_servicio = $servicio->id;

    $respuesta = array(
        "id" => $id_servicio,
        "precio" => $arrayfedex['CompletedShipmentDetail']['ShipmentRating']['ShipmentRateDetails']['TotalNetCharge']['Amount'],
        "tracking" => $arrayfedex['CompletedShipmentDetail']['MasterTrackingId']['TrackingNumber'],
        "url" => $url
    );

    return $respuesta;

    }

    public function CreateShipmentUps($data)
    {
        
        $volumetric_weight = ($data['paquete'][0]['largo'] * $data['paquete'][0]['ancho'] * $data['paquete'][0]['alto']) / 5000;
        $peso_final = $data['paquete'][0]['peso'];
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
        if ($volumetric_weight > $peso_final) {
            $peso_final = $volumetric_weight;
        }
        $headers = array('Accept: application/json', 'Content-Type: application/json');

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
            "ShipmentRequest": {
              "Request": {
                "RequestOption": "validate",
                "TransactionReference": {
                  "CustomerContext": "OLG16404"
                }
              },
              "Shipment": {
                "Description": "Paqueteria",
                "Shipper": {
                  "Name": "Internacional",
                  "AttentionName": "Lucas",
                  "ShipperNumber": "5V655E",
                  "Address": {
                    "AddressLine": [
                        "'.$data['remitente']['calle']. " " .$data['remitente']['altura'].'"
                    ],
                    "City": "'.$ciudad.'",
                    "StateProvinceCode": "'.$data['remitente']['codigo_provincia'].'",
                    "PostalCode": "'.$data['remitente']['cp'].'",
                    "CountryCode": "'.$data['remitente']['pais'].'"
                  },
                  "Phone": {
                    "Number": "1550636120",
                    "Extension": "0"
                  }
                },
                "ShipTo": {
                  "Name": "'.$data['destinatario']['destinatario'].'",
                  "AttentionName": "'.$data['destinatario']['destinatario'].'",
                  "TaxIdentificationNumber": "",
                  "Address": {
                    "AddressLine": [
                        "'.$data['destinatario']['calle']. " " .$data['destinatario']['altura'].'"
                    ],
                    "City": "'.$ciudad2.'",
                    "StateProvinceCode": "'.$data['destinatario']['codigo_provincia'].'",
                    "PostalCode": "'.$data['destinatario']['cp'].'",
                    "CountryCode": "'.$data['destinatario']['pais'].'"
                  },
                  "Phone": {
                    "Number": "'.$data['destinatario']['telefono'].'"
                  }
                },
                "ShipFrom": {
                  "Name": "Internacional",
                  "AttentionName": "Lucas",
                  "Address": {
                    "AddressLine": "Catamarca 1835",
                    "City": "Buenos Aires",
                    "PostalCode": "1417",
                    "CountryCode": "AR"
                  },
                  "Phone": {
                    "Number": "1550636120"
                  }
                },
                "PaymentInformation": {
                  "ShipmentCharge": {
                    "Type": "01",
                    "BillShipper": {
                      "AccountNumber": "5V655E"
                    }
                  }
                },
                "ReferenceNumber": {
                  "Code": "TN",
                  "Value": "OLG16404/18877/NPLUS"
                },
                "Service": {
                  "Code": "65",
                  "Description": "UPS Saver"
                },
                "Package": [
                  {
                    "Description": "PAQUETERIA LIVIANA",
                    "Packaging": {
                      "Code": "02"
                    },
                    "PackageWeight": {
                      "UnitOfMeasurement": {
                        "Code": "KGS"
                      },
                      "Weight": "'.$peso_final.'"
                    }
                  }
                ]
              },
              "LabelSpecification": {
                "LabelImageFormat": {
                  "Code": "PNG",
                  "Description": "PNG"
                },
                "HTTPUserAgent": "Mozilla/4.5"
              }
            }
          }';
          /* dd($json); */
        //Generar Compra UPS
        $url="https://onlinetools.ups.com/rest/Ship";
        $ch = curl_init($url);
        $data_string = (array) (array) json_decode($json);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json))
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result2 = curl_exec($ch);

        $arrayups = json_decode($result2, true);
        $etiqueta = $arrayups['ShipmentResponse']['ShipmentResults']['PackageResults']['ShippingLabel']['GraphicImage'];
        $tracking = $arrayups['ShipmentResponse']['ShipmentResults']['ShipmentIdentificationNumber'];
        $decoded = base64_decode($etiqueta);
        $file = $tracking . '.png';
        $url = 'ups/etiquetas/'.$file;
        /* return response()->download($url); */
        file_put_contents($url, $decoded);
        $url = '/ups/etiquetas/'.$file;
        $servicio = Servicio::Where('codigo_servicio', 'UPS_01')->first();
        $id_servicio = $servicio->id;
        
        $respuesta = array(
            "id" => $id_servicio,
            "precio" => $arrayups['ShipmentResponse']['ShipmentResults']['ShipmentCharges']['TotalCharges']['MonetaryValue'],
            "tracking" => $tracking,
            "url" => $url
        );
        
      return $respuesta;
  }
  
}