<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    
    protected $table    = "estado";
    protected $fillable = [
        'nombre',
    ]; 

    public function retiro()
    {
        return $this->hasMany('App\Retiro');
    }

    public $timestamps = false;
}
