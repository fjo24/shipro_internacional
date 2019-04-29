<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table    = "producto";
    protected $fillable = [
        'retiro_id', 'peso', 'alto', 'largo', 'ancho', 'peso_volumetrico', 'forma_carga', 'categoria_id',
    ];

    public function retiro()
    {
        return $this->belongsTo('App\Retiro');
    }

    public $timestamps = false;
}
