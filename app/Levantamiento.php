<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Levantamiento extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [   
        'folio'     
		/*'nombre_tramite',
        'requisitos',
        'tiempo_minutos',
        'costo',
        'codigo',
        'dependencia_id',
        'warning_message',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'*/
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

	protected $table = 'levantamientos';
	protected $primaryKey = 'id_levantamiento';
	public $incrementing = true;

 
}
