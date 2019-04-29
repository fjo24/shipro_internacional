<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_documento extends Model
{
    protected $table    = "tipo_documentos";
    protected $fillable = [
        'nombre',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public $timestamps = false;
}
