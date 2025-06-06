<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mantenimientos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'fecha_ingreso',
        'fecha_estimada_entrega',
        'estado',
        'monto_total',
        'descripcion',
        'monto_mantenimiento',
        'monto_adicional',
        'empleado_id',
        'pago_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_estimada_entrega' => 'date',
        'monto_total' => 'decimal:2',
        'monto_mantenimiento' => 'decimal:2',
        'monto_adicional' => 'decimal:2',
    ];

    /**
     * Get the user associated with the mantenimiento.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
    public function empleado()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the maintenance details associated with the mantenimiento.
     */
    public function detalles()
    {
        return $this->hasMany(DetalleMantenimiento::class);
    }
}