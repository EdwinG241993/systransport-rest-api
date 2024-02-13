<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    protected $table = 'turnos';
    use HasFactory;
    protected $fillable = [
        'conductor_id',
        'fecha',
        'hora_inicio',
        'hora_fin'
    ];

    public function conductor()
    {
        return $this->belongsTo(Conductor::class);
    }
}
