<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clientes';
    use HasFactory;
    protected $fillable = [
        'numero_identificacion',
        'nombre',
        'apellido',
        'direccion',
        'telefono',
        'fecha_nacimiento',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
