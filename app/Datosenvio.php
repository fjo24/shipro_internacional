<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datosenvio extends Model
{
    protected $table = "datosenvios";
    protected $fillable = [
        'peso', 'debe_retirarse', 'confirmada', 'facturado', 'cobrado', 'fecha',
    ];
    public $timestamps = false;
}
