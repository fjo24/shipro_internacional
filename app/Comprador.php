<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    protected $table    = "comprador";
    protected $fillable = [
        'empresa', 'cuit', 'localidad', 'provincia',
        'calle', 'provincia', 'apellido_nombre', 'altura',
        'other_info', 'cp', 'codigo', 'horario', 'numero_documento',
        'piso', 'dpto', 'email', 'celular', 'sucursal_id', 'pais_id', 'cliente_id',
        'documento', 'externo',
        'obs4', 'comZona', 'obsEstado ', 'kms','updated_at', 'created_at',
    ];

    public function retiro()
    {
        return $this->hasMany('App\Retiro');
    }

    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function pais()
    {
        return $this->belongsTo('App\Pais');
    }
    
}
