<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    // Nombre real de la tabla en la base de datos
    protected $table = 'Renta';

    // Tus tablas no tienen created_at / updated_at
    public $timestamps = false;

    // Campos que se pueden asignar masivamente (Create/Update)
    protected $fillable = [
        'Fecha_prestamo',
        'fecha_devolucion',
        'id_cliente',
        'id_pelicula',
    ];

    // Relación N:1 -> una renta pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación N:1 -> una renta pertenece a una pelicula
    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'id_pelicula');
    }
}