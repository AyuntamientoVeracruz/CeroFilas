<?php

namespace App\Helpers;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;

class Helper
{

    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user    = $user;
    }

    public static function getMenuData()
    {        
        $data['user'] = Auth::user();
        $data['rol']  = $data['user']->tipo_user;
        $data['name'] = $data['user']->nombre;
        $data['estatus'] = $data['user']->estatus;
        $data['disponibilidad'] = $data['user']->disponibleturno;
        $data['oficina'] = $data['user']->oficina_id;    
        $dependencia = DB::table("oficinas")->where("id_oficina",$data['user']->oficina_id)->first();    
        $data['dependencia']  = $dependencia;
        return $data;
    }

}
