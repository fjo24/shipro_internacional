<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'document_number', 'document_type_id', 'telephone', 'sucursal_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function document_type()
    {
        return $this->belongsTo('App\Document_type');
    }

    public function productos()
    {
        return $this->hasMany('App\Producto');
    }

    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }
}
