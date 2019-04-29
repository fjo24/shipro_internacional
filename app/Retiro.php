<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retiro extends Model
{
    protected $table = "retiro";
    protected $fillable = [
        'comprador_id', 'user_id', 'prestador_id', 'sender_id', 'sucursal_id', 'cliente_id', 'estado_id',
        'cordon_entrega_id', 'datosenvios_id', 'fecha_hora', 'peso', 'precio', 'is_fragil',
        'en_presis', 'impreso', 'rendido', 'trackingProveedor', 'servicioShipro', 'ProveedorShipro', 'valor_declarado',
        'seguimiento', 'estado', 'internacional', 'provinciadestino_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Servicio');
    }

    public function comprador()
    {
        return $this->belongsTo('App\Comprador');
    }

    public function estadoshipro()
    {
        return $this->belongsTo('App\Estado', 'estado_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Sender');
    }

    public function prestador()
    {
        return $this->belongsTo('App\Datosprestador');
    }

    public function provinciadestino()
    {
        return $this->belongsTo('App\Provincia', 'provinciadestino_id');
    }

    public function productos()
    {
        return $this->hasMany('App\Producto');
    }

    public function getfechaHoraAttribute($date)
    {
        return $date = \Carbon\Carbon::parse($date)->format('d-m-Y');
    }
    public function setfechaHoraAttribute($date)
    {
        $this->attributes['fecha_hora'] = \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    //Query Scope
    public function scopeCurrier($query, $currier)
    {
        if ($currier)
            return $query->where('ProveedorShipro', 'LIKE', "%$currier%");
    }

    public function scopeTracking($query, $tracking)
    {
        if ($tracking)
            return $query->where('trackingProveedor', 'LIKE', "%$tracking%");
    }

    public function scopeServicio($query, $servicio)
    {
        if ($servicio)
            return $query->where('servicioShipro', 'LIKE', "%$servicio%");
    }

    public function scopeEstado($query, $estado)
    {
        if ($estado)
            return $query->where('estado', 'LIKE', "%$estado%");
    }

    public function scopeFiltroestadoshipro($query, $estadoshipro)
    {
        if ($estadoshipro)
            return $query->where('estado_id', 'LIKE', "%$estadoshipro%");
    }

    public function scopeDestinatario($query, $destinatario)
    {
        if ($destinatario)
            return $query->whereHas('comprador', function ($query) use ($destinatario) {
            $query->where('apellido_nombre', 'like', "%{$destinatario}%");
        });
    }

    public function scopeFechamayor($query, $fechamayor)
    {
        if ($fechamayor)
            return $query->whereDate('fecha_hora', '<=', $fechamayor);
    }

    public function scopeFechamenor($query, $fechamenor)
    {
        if ($fechamenor)
            return $query->whereDate('fecha_hora', '>=', $fechamenor);
    }

    public $timestamps = false;
}
