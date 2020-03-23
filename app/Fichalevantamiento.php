<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Fichalevantamiento extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [        
		'id_ficha',
        'folio',
        'fecha_elaboracion',
        'direccion_elabora',
        'nombre_registra_datos',
        'cargo',
        'tel_contacto',
        'clave_catastral',
        'subsistema_id',
        'elemento_id',
        'nombre',
        'clave_escolar',
        'inicio_actividad',
        'fin_actividad',
        'foto_fachada_principal',
        'ubicacion_croquis_lat_lon',
        'entidad_federal_opera',
        'entidad_federal_mantenimiento',
        'tipo_calle',
        'nombre_calle',
        'numero_oficial',
        'referencia_calle1',
        'referencia_calle2',
        'colonia_id',
        'codigo_postal',
        'telefono',
        'celular',
        'correo_electronico',
        'unidad_basica_servicio',
        'numero_ubs',
        'numero_usuarios_totales',
        'numero_usuarios_ubs',
        'radio_cobertura',
        'conectividad_accesibilidad',
        'recubrimiento_vialidad',
        'estado_conservacion_vialidad',
        'acceso_transporte_publico',
        'nombre_ruta_transporte',
        'tiempo_promedio_espera',
        'otra_ruta_menos_200',
        'tiempo_promedio_espera_200',
        'otra_ruta_menos_500',
        'tiempo_promedio_espera_500',
        'facil_tomar_taxi',
        'tiempo_promedio_tomar_taxi',        
        'servicio_agua_potable',
        'servicio_continuo_agua',
        'calida_servicio_agua',
        'servico_continuo_agua_no',
        'consumo_promedio_mensual_agua',
        'forma_abastesimiento_agua',        
        'drenaje_sanitario',
        'calidad_servicio_drenaje',
        'especifique_sistema_drenaje',        
        'energia_electica',        
        'iluminacion_suficiente',
        'calidad_iluminacion',
        'energia_electica_no',
        'manzana_cuenta_alumbrado_publico',
        'cuenta_alumbrado_punto_cercano_tranporte_publico',
        'condiciones_alumbrado_publico',
        'cuenta_servicio_telefonia',
        'cuenta_servicio_internet_area_administrativa',
        'cuenta_servicio_internet_gratuito',
        'cuenta_servicio_recoleccion_basura',
        'cuenta_servicio_vigilancia_diurna',
        'cuenta_servicio_vigilancia_nocturna',
        'cuenta_personal_mantenimiento',
        'caracteristicas_muros',
        'caracteristicas_muros_nota',
        'caracteristicas_pisos',
        'caracteristicas_pisos_nota',
        'caracteristicas_techo',
        'caracteristicas_techo_nota',
        'servicios_sanitarios_usuarios',
        'sanitario_separado_genero',
        'numero_servicios_wc_mujeres',
        'numero_servicios_wc_hombres',
        'numero_servicos_wc_mixtos',
        'cuenta_servicio_sanitario_administrativo',
        'cuenta_servicio_sanitario_usuario_inmueble',
        'cuantos_wc_administrativo_mujeres',
        'cuantos_wc_administrativo_hombres',
        'cuantos_wc_administrativo_mixtos',
        'metros_cuadrados_predio',
        'numero_cajones_estacionamiento_usuarios',
        'numero_cajones_estacionamiento_empleados',
        'cuenta_areas_deportivas',   
        'cuenta_areas_verdes',
        'estado_areas_verdes',
        'arboles_dentro_predio',
        'cuantos_arboles',
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

	protected $table = 'fichalevantamientos';
	protected $primaryKey = 'id_ficha';
	public $incrementing = true;

 
}
