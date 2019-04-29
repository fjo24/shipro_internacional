<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table    = "cliente";
    protected $fillable = [
        'vendedor_id', 'rubro_id', 'forma_pago_id', 'tipo_iva_id', /* 'username', 'username_canonical',
        'email', 'email.canonical', 'enable', 'password', 'last_login', 'loked', 'expired', 
        'confirmation_token', 'roles', 'credentials_expired', 'user_admin', */
    ];

    public function vendedor()
    {
        return $this->belongsTo('App\Vendedor');
    }

    public function compradores()
    {
        return $this->hasMany('App\Comprador');
    }

    public function sucursales()
    {
        return $this->hasMany('App\Sucursal');
    }

}
