<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'vehiculos';
    use HasFactory;
    protected $fillable = [
        'numero_interno',
        'placa',
        'capacidad',
        'marca',
        'modelo',
        'estado',
        'empresa_afiliada_id',
        'conductor_id'
    ];

    public function affiliatedCompany()
    {
        return $this->belongsTo(AffiliatedCompany::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
