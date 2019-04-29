<?php
namespace App\Traits;
use Carbon\Carbon;
use App\Sucursal;
use App\User;
use MP;
trait Pago
{
    
    public function generatePaymentGateway($data)
	{

    $fecha_referencia = Carbon::now()->format('YmdHis');
    /* dd($data['servicio']['precio']); */
		/* dd($data); */
	 	/* $mp = new MP (env('MERCADOPAGO_CLIENTE_ID'), env('MERCADOPAGO_CLIENTE_SECRET')); */
    $mp = new MP ("3080451303981997", "UxvQkyKoXSzyzWxzY3iJQCBSPjUtIkUG");
    $mp->sandbox_mode(TRUE);
    $sucursal = Sucursal::Where('descripcion', $data['remitente']['sucursal'])->first();
    $current_user = User::Where('cliente_id', $sucursal->cliente->id)->first();
    $access_token = $mp->get_access_token();
    $status_orden = "approved";
       /*  $compra = Compra::where('user_id', $current_user->id)
                          ->where('estado', 'activo')
                          ->first(); */
        /* $pedido = Compra::find($compra->id)->presentaciones()->get(); */
		/* foreach ($pedido as $p){
			$preferenceData['items'][] = [
				'id'          => 1,
				'title'       => $p->producto->nombre,            
				'description' => 'Compra de artículos VanRossum mediante Mercadopago',
				'quantity'    => (int)$p->pivot->cantidad,
				'unit_price'  => (float)$p->precio,
				'currency_id' => 'ARS',
			];
		}; */

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
  				"success" => route('crearenvio', compact('data')),
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