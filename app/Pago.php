<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [        
        'clave_catastral',
        'control_number',
        'codigo_autorizacion',
        'status',
        'monto',
        'nombre',
        'modo', 
        'error_mensaje',
        'created_at',
        'updated_at'
    ];
    

	protected $table = 'transacciones';
    protected $primaryKey = 'id_pago';
    protected $connection = 'mysql2';
}
