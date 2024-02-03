<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliatedCompany extends Model
{
    protected $table = 'empresa_afiliada';
    use HasFactory;
    protected $fillable = [
        'codigo',
        'nombre',
        'nit',
        'direccion',
        'telefono',
        'fecha_afiliacion',
        'estado'
    ];
}
