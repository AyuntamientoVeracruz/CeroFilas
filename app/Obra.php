<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Obra extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'tipo_contenido',        
		'nombre',
        'lat',
        'lng',
        'descripcion',
        'entorno',
        'monto_contrato',
        'etapa',
        'tipo',
        'comuna',
        'jurisdiccion',
        'mano_obra',
        'porcentaje_avance',
        'etapa_detalle',
        'area_responsable',
        'barrio',
        'calle_1',
        'seccion',
        'manzana',
        'parcela',
        'direccion',
        'fecha_inicio',
        'fecha_fin_inicial',
        'plazo_meses',
        'imagen_1',
        'imagen_2',
        'imagen_3',
        'imagen_4',
        'licitacion_oferta_empresa',
        'licitacion_anio',
        'benficiarios',
        'compromiso',
        'link_interno',
        'pliego_descarga',
        'contratacion_tipo',
        'nro_contratacion',
        'financiamiento',
        'folio',
        'email',
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

	protected $table = 'obras';
	protected $primaryKey = 'id';
	public $incrementing = true;
    protected $connection = 'mysql3';

 
}
