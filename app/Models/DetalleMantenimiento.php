<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMantenimiento extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalles_mantenimiento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mantenimiento_id',
        'producto_id',
        'cantidad',
        'neto',
        'precio_producto'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'cantidad' => 'integer',
        'neto' => 'decimal:2',
    ];

    /**
     * Get the mantenimiento associated with the detalle.
     */
    public function mantenimiento()
    {
        return $this->belongsTo(Mantenimiento::class);
    }

    /**
     * Get the producto associated with the detalle.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}