<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    // use Notifiable;


    protected $hidden = [
        'password', 'password_confirmation',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }
}
