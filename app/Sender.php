<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    protected $table    = "sender";
    protected $fillable = [
        'empresa', 'calle', 'altura', 'cp',
    ];
//test
    public function comprador()
    {
        return $this->belongsTo('App\Comprador');
    }
    public $timestamps = false;

}
