<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Fichasubsistema extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'id_subsistema',
        'subsistema',
        'elemento',
        'ubs',
        'capacidad_diseno_ubs',
        'radio_cobertura',
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

	protected $table = 'fichasubsistemas';
	protected $primaryKey = 'id_subsistema';
	public $incrementing = true;

 
}
