<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Feriado extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'fecha',        
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

	protected $table = 'feriados';
	protected $primaryKey = 'id_feriado';
	public $incrementing = true;
    protected $connection = 'mysql4';

 
}
