<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

	protected $table = 'VERIFY_USERS';

}
