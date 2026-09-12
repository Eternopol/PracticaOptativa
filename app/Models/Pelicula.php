<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    // Nombre real de la tabla en la base de datos
    protected $table = 'Peliculas';

    // Tus tablas no tienen created_at / updated_at
    public $timestamps = false;

    // Campos que se pueden asignar masivamente (Create/Update)
    protected $fillable = [
        'Titulo',
        'Categoria',
        'Precio',
        'Duracion',
    ];

    // Relación 1:N -> una pelicula puede estar en muchas rentas
    public function rentas()
    {
        return $this->hasMany(Renta::class, 'id_pelicula');
    }
}