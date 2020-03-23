<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Turno extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'cita_id',
        'oficina_id',
        'user_id',
        'tramite_id',
        'fechahora_inicio',
        'fechahora_fin',
        'observaciones',
        'nombre_ciudadano',
        'curp',
        'email',
        'estatus',
        'folio',
        'tiempoaproxmin ',
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

	protected $table = 'turnos';
	protected $primaryKey = 'id_turno';
	public $incrementing = true;

 
}
