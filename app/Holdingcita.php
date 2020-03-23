<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Holdingcita extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [ 
        'oficina_id',
        'tramite_id',
        'fechahora',
        'folio',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

	protected $table = 'holdingcitas';
	protected $primaryKey = 'id_holdingcita';
	public $incrementing = true;

 
}
