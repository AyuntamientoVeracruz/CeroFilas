<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cita extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'tramite_id',
        'oficina_id',
        'fechahora',
        'nombre_ciudadano',
        'appaterno_ciudadano',
        'apmaterno_ciudadano',
        'email',
        'curp',
        'telefono',
        'folio',
        'ip',
        'statuscita',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

	protected $table = 'citas';
	protected $primaryKey = 'id_cita';
	public $incrementing = true;

 
}
