<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datosprestador extends Model
{
    protected $table    = "datosprestador";
    protected $fillable = [
        'cp', 'partido', 'localidad', 'provincia', 'cordon',
    ];

    public function retiro()
    {
        return $this->hasMany('App\Retiro');
    }

    public $timestamps = false;
}
