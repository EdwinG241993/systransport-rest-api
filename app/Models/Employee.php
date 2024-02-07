<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'funcionario';
    use HasFactory;
    protected $fillable = [
        'numero_identificacion',
        'nombre',
        'apellido',
        'direccion',
        'telefono',
        'cargo',
        'fecha_ingreso',
        'salario',
        'user_id',
        'empresa_afiliada_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
