<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Multa extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'articulo',
        'descripcion',
        'gravedad',
        'umas',
        'agravante',
        'clave',
        'estatus',
        'clasificacion',        
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

	protected $table = 'multas';
	protected $primaryKey = 'id_multa';
	public $incrementing = true;
    protected $connection = 'mysql4';

 
}
