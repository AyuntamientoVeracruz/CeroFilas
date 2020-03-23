<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Fichadetalle extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'id_fichadetalle',
        'ficha_id',        
        'cantidad',
        'tipo', 
        'nombre',   
        'largo',
        'ancho',
        'notas',
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

	protected $table = 'fichadetalles';
	protected $primaryKey = 'id_fichadetalle';
	public $incrementing = true;

 
}
