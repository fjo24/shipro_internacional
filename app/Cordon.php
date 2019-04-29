<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cordon extends Model
{
    protected $table    = "cordon";
    protected $fillable = [
        'descripcion',
    ];

    public function cpcordon()
    {
        return $this->hasMany('App\Cpcordon');
    }
    
}
