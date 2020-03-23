<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Valoracione extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        		
        'turno_id',
        'folio',
        'estrellas',
        'respuesta1',
        'respuesta2',
        'observaciones',
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

	protected $table = 'valoraciones';
	protected $primaryKey = 'id_valoracion';
	public $incrementing = true;

 
}
