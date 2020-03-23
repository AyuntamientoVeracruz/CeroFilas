<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [        
		'tipo_user',
        'estatus',
        'email',
        'password',
        'nombre',
        'oficina_id',
        'disponibleturno', 
        'ventanilla',
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
    protected $hidden = [
        'password',
    ];

	protected $table = 'users';
	protected $primaryKey = 'id_user';
	public $incrementing = true;

  public function verifyUser()
      {
          return $this->hasOne('App\VerifyUser');
      }
}
