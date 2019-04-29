<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table    = "paises";
    protected $fillable = [
        'pais', 'iata_pais', 'iata_estado',
    ];
    public function Provincia(){
    	return $this->hasMany(Provincia::class);
    }

    public function compradores(){
    	return $this->hasMany(Comprador::class);
    }
    public $timestamps = false;
}
