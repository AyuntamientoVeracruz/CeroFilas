<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tramitesxuser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'tramite_id',
        'user_id',
        'lunes_inicio',
        'lunes_fin',
        'martes_inicio',
        'martes_fin',
        'miercoles_inicio',
        'miercoles_fin',
        'jueves_inicio',
        'jueves_fin',
        'viernes_inicio',
        'viernes_fin',
        'sabado_inicio',
        'sabado_fin',
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

	protected $table = 'tramitesxusers';
    protected $primaryKey = 'id_tramitesxusers';
 
}
