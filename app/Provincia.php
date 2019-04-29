<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table='provincias';
    /* protected $primaryKey='id'; */

    protected $fillable=['pais_id','codigo','descripcion', 'descripcion_en'];

     //relaciones mucho a muchos
    public function Pais(){

    	return $this->belongsTo(Pais::class);
    }

    public $timestamps = false;
}
