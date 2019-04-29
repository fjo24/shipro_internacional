<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nodo extends Model
{
    protected $table    = "nodos";
    protected $fillable = [
        'desc', 'cordo', 'cordd', 'username', 'password', 'sucursal', 'codserv', 'url', 'proveedor', 'activo', 'tipo',
    ];

    public $timestamps = false;
}
