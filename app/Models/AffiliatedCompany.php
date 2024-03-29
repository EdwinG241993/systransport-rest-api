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

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['employees'];

    /**
     * Get the employees records associated with the affiliated company.
     */
    public function employees()
    {
        return $this->hasMany('App\Models\Employee', 'empresa_afiliada_id');
    }

    /**
     * Get the conductors records associated with the affiliated company.
     */
    public function conductors()
    {
        return $this->hasMany('App\Models\Conductor', 'empresa_afiliada_id');
    }

    /**
     * Get the cars records associated with the affiliated company.
     */
    public function cars()
    {
        return $this->hasMany('App\Models\Employee');
    }


    //Cascade delete users associated with employees of an affiliated company when that affiliated company is deleted.
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($affiliatedCompany) {
            foreach ($affiliatedCompany->conductors as $conductor) {
                $conductor->user()->delete();
            }
        });

        static::deleting(function ($affiliatedCompany) {
            foreach ($affiliatedCompany->employees as $employee) {
                $employee->user()->delete();
            }
        });
    }
}
