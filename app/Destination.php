<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table    = "destinations";
    protected $fillable = [
        'country', 'city', 'group', 'code', 'airport', 'maria_code', 'active',
    ];

    public function paises(){
    	return $this->hasMany(Destination::class);
    }
}
