<?php
error_reporting(0);
#produccion
//$mysqli = new mysqli('epresis.cyqfcghusny3.sa-east-1.rds.amazonaws.com', 'presis', 'SIStec2005', 'testapi');
#desarrollo
$mysqli = new mysqli('desarrollo.cyqfcghusny3.sa-east-1.rds.amazonaws.com', 'testapi', 'api10241024', 'testapi');
// ¡Oh, no! Existe un error 'connect_errno', fallando así el intento de conexión
if ($mysqli->connect_errno) {
  // La conexión falló. ¿Que vamos a hacer?
  // Se podría contactar con uno mismo (¿email?), registrar el error, mostrar una bonita página, etc.
  // No se debe revelar información delicada
 	$fecha = date('Y-m-d H:i:s');
    ///////////////////////////////RESPALDO TXT////////////////////////
    $file = fopen("./log/servicios"."_".$fecha.".txt","a");
    $txt = "No se establecio conexion con el RDS" ;
    fwrite($file, $txt);
    fclose($file);                                  	
  // Probemos esto:
  echo "Lo sentimos, este sitio web está experimentando problemas.";

  // Algo que no se debería de hacer en un sitio público, aunque este ejemplo lo mostrará
  // de todas formas, es imprimir información relacionada con errores de MySQL -- se podría registrar
  echo "Error: Fallo al conectarse a MySQL debido a: \n";
  echo "Errno: " . $mysqli->connect_errno . "\n";
  echo "Error: " . $mysqli->connect_error . "\n";

  // Podría ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
  exit;
}


$data = json_decode(file_get_contents('php://input'),true);
$cpo=$data['cp_origen'];
$cpd=$data['cp_destino'];
$sucu=$data['sucursal'];
$comprador=$data['comprador']; // 08/08/2018: Por AA

#cordon destino
$stmt=$mysqli->prepare("select cordon_id from cordon where cp='".$cpd."'");
	if ($stmt){
	  /* ejecutar la consulta */
	  $rc = $stmt->execute();
	  if(false===$rc){
            $fecha = date('Y-m-d H:i:s');
            ///////////////////////////////RESPALDO TXT////////////////////////
            $file = fopen("./log/servicios"."_".$fecha.".txt","a");
            $txt = "select cordon_id from cordon where cp='".$cpd."'"; 
            fwrite($file, $txt);
            fclose($file);                                  
            die('execute() failed: ' . htmlspecialchars($this->_db->error));
        }

	  /* ligar variables de resultado */
	  $stmt->bind_result($cordon_destino);
	  
	  /* obtener valor */
	  $stmt->fetch();
	 
	  $stmt->close();

	}else{

        $fecha = date('Y-m-d H:i:s');
        ///////////////////////////////RESPALDO TXT////////////////////////
        $file = fopen("/log/servicio"."_".$fecha.".txt","a");
        $txt = "select cordon_id from cordon where cp='".$cpd."'"; 
        fwrite($file, $txt);
        fclose($file);                                  
    }

	#cordon origen
    $stmt1=$mysqli->prepare("select cordon_id from cordon where cp='".$cpo."'");

	if ($stmt1){
	  /* ejecutar la consulta */
	   $rc1 = $stmt1->execute();
	  if(false===$rc1){
            $fecha = date('Y-m-d H:i:s');
            ///////////////////////////////RESPALDO TXT////////////////////////
            $file = fopen("./log/servicios"."_".$fecha.".txt","a");
            $txt = "select cordon_id from cordon where cp='".$cpo."'"; 
            fwrite($file, $txt);
            fclose($file);                                  
            die('execute() failed: ' . htmlspecialchars($this->_db->error));
        }

	  /* ligar variables de resultado */
	  $stmt1->bind_result($cordon_origen);
	  
	  /* obtener valor */
	  $stmt1->fetch();
	 
	  $stmt1->close();

	}else{
        $fecha = date('Y-m-d H:i:s');
        ///////////////////////////////RESPALDO TXT////////////////////////
        $file = fopen("/log/servicios"."_".$fecha.".txt","a");
        $txt = "select cordon_id from cordon where cp='".$cpo."'"; 
        fwrite($file, $txt);
        fclose($file);                                  
    }

	if($cordon_destino == 1000){
		//var_dump($data['productos'][0]['tipo']);
		$resu=array();
		if($data['productos'][0]['peso'] == 1){
			array_push($resu,array("id"=>"1000", "proveedor"=>"Correo Argentino", 
									"servicion"=>"Servicio de Entrega de 7 a 12 dias habiles",
									"precio"=> "183,00"));
			echo json_encode($resu);
			//var_dump($prod);
			exit;
		}elseif($data['productos'][0]['peso'] == 2){
			array_push($resu,array("id"=>"1000", "proveedor"=>"Correo Argentino", 
									"servicion"=>"Servicio de Entrega de 7 a 12 dias habiles",
									"precio"=> "208,00 "));
			echo json_encode($resu);
			exit;
		}elseif($data['productos'][0]['peso'] == 5){
			array_push($resu,array("id"=>"1000", "proveedor"=>"Correo Argentino", 
									"servicion"=>"Servicio de Entrega de 7 a 12 dias habiles",
									"precio"=> " 225,00"));
			echo json_encode($resu);
			exit;
		}
		elseif($data['productos'][0]['peso'] == 10){
			array_push($resu,array("id"=>"1000", "proveedor"=>"Correo Argentino", 
									"servicion"=>"Servicio de Entrega de 7 a 12 dias habiles",
									"precio"=> "290,00"));
			echo json_encode($resu);
			exit;
		}elseif($data['productos'][0]['peso'] == 15){
			array_push($resu,array("id"=>"1000", "proveedor"=>"Correo Argentino", 
									"servicion"=>"Servicio de Entrega de 7 a 12 dias habiles",
									"precio"=> "370,00"));
			echo json_encode($resu);
			exit;
		}elseif($data['productos'][0]['peso'] == 20){
			array_push($resu,array("id"=>"1000", "proveedor"=>"Correo Argentino", 
									"servicion"=>"Servicio de Entrega de 7 a 12 dias habiles",
									"precio"=> " 475,00 "));
			echo json_encode($resu);
			exit;
		}
	}

//	var_dump($cordon_origen.":::".$cordon_destino.":::".$sucu);
//	die();	
	//SERVICIOS DISPONIBLES
	////////////////////////////////////////////////////////////////
	$sql="select * from nodos where cordo='".$cordon_origen."' and cordd='".$cordon_destino."' and sucursal = '".$sucu."' and activo = 1";

	 
	//$sql="select * from nodos where cordo=24 and cordd=20";
	//$sql="select * from nodos where cordo=21 and cordd=20";
	$stmt=$mysqli->prepare($sql);
	//print_r($stmt);
	if ($stmt){

	  /* ejecutar la consulta */
	  $stmt->execute();

	  /* ligar variables de resultado */
	   $stmt->store_result();

	   /* Get the number of rows */
	   $num_of_rows = $stmt->num_rows;

	   /* Bind the result to variables */
	   $stmt->bind_result($id, $desc, $cordo, $cordd, $username, $password, $sucursal, $codserv, $url, $proveedor,$activo);
	   //print_r($stmt->fetch());

	   
	   $resu=array();
	  	while ($stmt->fetch()) { // Caso 1247 5 veces


	  		if($url == 'https://onlinetools.ups.com/rest/'){

				$json1 = '{
					"UPSSecurity": {
						"UsernameToken": {
							"Username": "'.$username.'",
							"Password": "'.$password.'"
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
								"Name": "REAL EXPRESS",
								"ShipperNumber": "5V655E",
								"Address": {
									"AddressLine": [
										"Gral. Urquiza 776"
									],
									"City": "Buenos Aires",
									"StateProvinceCode": "CABA",
									"PostalCode": "1221",
									"CountryCode": "AR"
								}
							},
							"ShipTo": {
								"Name": "'.$comprador[0][destinatario].'",
								"Address": {
									"AddressLine": [
										"'.$comprador[0][calle] . "\n" .$comprador[0][altura].'"
									],
									"City": "'.$comprador[0][provincia].'",
									"StateProvinceCode": "CABA",
									"PostalCode": "'.$cpd.'",
									"CountryCode": "AR"
								}
							},
							"ShipFrom": {
								"Name": "REAL EXPRESS",
								"Address": {
									"AddressLine": [
										"Gral. Urquiza 776"
									],
									"City": "Buenos Aires",
									"StateProvinceCode": "CABA",
									"PostalCode": "1221",
									"CountryCode": "AR"
								}
							},
							"Service": {
								"Code": "65",
								"Description": "saver"
							},
							"Package": {
								"PackagingType": {
									"Code": "02",
									"Description": "Rate"
								},
								"PackageWeight": {
									"UnitOfMeasurement": {
										"Code": "kgs",
										"Description": "KILOS"
									},
									"Weight": "'.trim($data['productos'][0]['peso']).'"
								}
							},
							"ShipmentRatingOptions": {
								"NegotiatedRatesIndicator": ""
							}
						}
					}
				}';
				$url2=$url."Rate";
				$ch = curl_init($url2);
			   	$data_string = (array) (array) json_decode($json);
			   	//var_dump($data_string);
			   	//die();
 		     	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		      	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		      	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		          'Content-Type: application/json',
		          'Content-Length: ' . strlen($json1))
		      	);
		      	curl_setopt($ch, CURLOPT_POSTFIELDS, $json1);
		      	$result2 = curl_exec($ch);

		      	$res2=json_decode($result2);

		      	
		      	$a = json_decode($result2, true);
		      	
		      	//var_dump($a);
		      	$precio = $a[RateResponse][RatedShipment][TotalCharges][MonetaryValue];
                        
		      	if($cordd == 20 || $cordd = 21){
		      	    $precio_ar= (float) $precio * (float) 15.04;
                            
                            //Descuento: 72 %
                            $precio= (float) $precio_ar * (float) 72;
                            
                            $precio = (float) $precio / (float) 100 ;
                            $precio = $precio_ar - $precio;
		      	}else{
                            $precio_ar= (float) $precio * (float) 15.04;
                            
                            //Descuento: 50%
                            $precio= (float) $precio_ar * (float) 50;
                            
                            $precio = (float) $precio / (float) 100 ;
                            $precio = $precio_ar - $precio;
                            //die($precio);
		      	}
		      	
		      	
		      	curl_close($ch);  
		      	 if  ($precio && $precio != '0.00' && $precio != '' && $precio != '404' && $precio != 'Codigo de servicio incorrecto o no habilitado' && $precio != 'null'){
			    	 array_push($resu,array("id"=>$id, "proveedor"=>$proveedor, "servicion"=>trim($desc), 
			    	"precio"=> trim($precio)));
			    }		
		    		
		  	}else if($url == 'http://envioya.herokuapp.com/'){

				$medida;
				if($data['productos'][0]['peso'] == 1){

					$medida='2';

				}elseif($data['productos'][0]['peso'] == 2){

					$medida='52';

				}elseif($data['productos'][0]['peso'] == 5){

					$medida='72';

				}elseif($data['productos'][0]['peso'] == 10){

					$medida='82';

				}elseif($data['productos'][0]['peso'] == 15){

					$medida='92';

				}elseif($data['productos'][0]['peso'] == 20){

					$medida='92';

				}

				$url2=$url."api/getPrecio";
				  		  	
				  		  	$prod=$data['productos'];
						    $ch = curl_init($url2);
						    
						    
						   	$datoss=array("_apikey"=>'abc123',"cliente_id"=>'52',"medida_id"=>$medida, "servicio_id_d"=>$codserv,"codigo_postal"=>$cpo,"codigo_postal_d"=>$cpd);
						   	$data_strings = json_encode($datoss);

						   	
						      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
						      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						          'Content-Type: application/json'
						      )
						      );
						      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_strings);
						      $result1 = curl_exec($ch);
						      
						      $a1 = json_decode($result1, true);

						      curl_close($ch);
						      
						   	 
						      $precio = $a1[precio];
						      
							   	  if ($precio && $precio != '0.00' && $precio != '' && $precio != '404' && $precio != 'Codigo de servicio incorrecto o no habilitado' && $precio != 'null'){
							   	  	
						    		array_push($resu,array("id"=>$id, "proveedor"=>$proveedor, "servicion"=>trim($desc), "precio"=> $precio));
					    		}
					    		//var_dump($resu);

			}else{
		  		
		  		  	$url2=$url."api/v1/precios.json";
		  		  	
		  		  	$prod=$data['productos'];
				    $ch = curl_init($url2);
				    
				    
				   	$datos=array("username"=>'shipro',"password"=>'sp123',"sucursal"=>$sucu, "cp"=>$cpd,"servicio"=>$codserv,"productos"=>$prod);
				   	$data_string = json_encode($datos);
				   	
				      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				          'Content-Type: application/json',
				          'Content-Length: ' . strlen($data_string))
				      );
				      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				      $result2 = curl_exec($ch);
				      //var_dump($proveedor.":".$result2);
				      //die();


				      $res2=json_decode($result2);
				      
				      $a = json_decode($result2, true);

				      curl_close($ch);
				   	 
				      $precio = $a[precio];
				      
					   	  if ($precio && $precio != '0.00' && $precio != '' && $precio != '404' && $precio != 'Codigo de servicio incorrecto o no habilitado' && $precio != 'null'){
				    			//var_dump($id . "/" . $proveedor."/". $desc."/". $value);
				    		array_push($resu,array("id"=>$id, "proveedor"=>$proveedor, "servicion"=>trim($desc), "precio"=> $precio));
			    		}
			    		//var_dump($resu);
		  	}
		  	
    	}
    	
  
	   
	  $stmt->close();

	}


	if(json_encode($resu) == '[]'){
		$fecha = date('Y-m-d H:i:s');
        ///////////////////////////////RESPALDO TXT////////////////////////
        $file = fopen("./log/servicios"."_".$fecha.".txt","a");
        $txt = "select * from nodos where cordo='".$cordon_origen."' and cordd='".$cordon_destino."' and sucursal = '".$sucu."'"; 
        fwrite($file, $txt);
        fclose($file);                                
		//echo "Error 404";
		echo 'El servicio solicitado no está disponible entre las ubicaciones seleccionadas';
	}else{
		$sliced_array = array();
		foreach ($resu as $key => $row) {
	    	$aux[$key] = $row['precio'];
	    	array_multisort($aux, SORT_ASC, $resu);
		}
	
		$salida = array_slice($resu, 0, 3);
		//resultado final
		echo json_encode($salida);
	
	
}



?>
