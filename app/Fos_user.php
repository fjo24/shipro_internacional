<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fos_user extends Model
{
    protected $table    = "fos_user";
    protected $fillable = [
        'vendedor_id', 'cliente_id', 'distribuidor_id', 'sucursal_id', 'username', 'username_canonical',
        'email', 'email.canonical', 'enable', 'password', 'last_login', 'loked', 'expired', 'confirmation_token', 
        'roles', 'credentials_expired', 'user_admin',
    ];

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

}
