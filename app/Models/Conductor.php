<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    protected $table = 'conductores';
    use HasFactory;
    protected $fillable = [
        'numero_identificacion',
        'nombre',
        'apellido',
        'direccion',
        'telefono',
        'numero_licencia',
        'fecha_vencimiento_licencia',
        'salario',
        'empresa_afiliada_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
