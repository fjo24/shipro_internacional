<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table    = "sucursal";
    protected $fillable = [
        'cliente_id', 'cp', 'codigo_sucursal', 'descripcion', 'calle',
        'altura', 'altura', 'piso', 'dpto', 'other_info', 'localidad', 
        'provincia', 'cuit', 'mail', 'contacto', 'razonSocial',
        'kms', 'celular', 'end', 'pais_id', 'provincia_id',
    ];

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function usuarios()
    {
        return $this->hasMany('App\Fos_user');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function Pais(){

    	return $this->belongsTo(Pais::class);
    }

    public function Provincia(){

    	return $this->belongsTo(Provincia::class);
    }

    public function compradores()
    {
        return $this->hasMany('App\Comprador');
    }
    

}
