<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_personas',
        'fecha_llegada',
        'cantidad_noche',
        'valor_reserva',
        'estado_reserva',
        'hotels_id',
        'clients_id'
    ];
}
