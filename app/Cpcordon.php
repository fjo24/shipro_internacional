<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cpcordon extends Model
{
    protected $table    = "cpcordon";
    protected $fillable = [
        'cordon_id', 'cp', 'localidad', 'provincia',
    ];

    public function cordon()
    {
        return $this->belongsTo('App\Cordon');
    }
}
