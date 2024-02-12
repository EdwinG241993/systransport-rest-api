<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'rutas';
    use HasFactory;
    protected $fillable = [
        'codigo',
        'origen',
        'destino',
        'distancia',
        'frecuencia'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
