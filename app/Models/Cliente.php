<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // Nombre real de la tabla en la base de datos
    protected $table = 'Clientes';

    // Tus tablas no tienen created_at / updated_at
    public $timestamps = false;

    // Campos que se pueden asignar masivamente (Create/Update)
    protected $fillable = [
        'Nombre',
        'Apellidos',
        'Edad',
        'Telefono',
    ];

    // Relación 1:N -> un cliente puede tener muchas rentas
    public function rentas()
    {
        return $this->hasMany(Renta::class, 'id_cliente');
    }
}