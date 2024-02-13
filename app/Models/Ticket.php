<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tiquetes';
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'ruta_id',
        'vehiculo_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'tarifa',
        'numero_asiento'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'conductor_id');
    }
}
