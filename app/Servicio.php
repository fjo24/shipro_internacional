<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table    = "servicio";
    protected $fillable = [
        'codigo_servicio', 'activo', 'descripcion', 'detalle_servicio',
    ];
    //test
    public function retiros()
    {
        return $this->hasMany('App\Retiro');
    }
    public $timestamps = false;
}
