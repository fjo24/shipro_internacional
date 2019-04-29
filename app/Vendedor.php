<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table    = "vendedor";
    protected $fillable = [
        'nombre', 'telefono', 'direccion', 'cp', /* 'username', 'username_canonical',
        'email', 'email.canonical', 'enable', 'password', 'last_login', 'loked', 'expired', 
        'confirmation_token', 'roles', 'credentials_expired', 'user_admin', */
    ];

    public function cliente()
    {
        return $this->hasMany('App\Cliente');
    }
}
