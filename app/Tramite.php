<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tramite extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'nombre_tramite',
        'requisitos',
        'tiempo_minutos',
        'costo',
        'codigo',
        'dependencia_id',
        'warning_message',
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

	protected $table = 'tramites';
	protected $primaryKey = 'id_tramite';
	public $incrementing = true;

 
}
