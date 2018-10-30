<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   
    public function userRoles()
    {
        return $this->hasMany('App\UserRole');
    }
   
    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('role_user_status', 'deleted', 'deleted_on', 'deleted_by', 'created_by')
            ->withTimestamps();
    }

   
    public function userLoginSessions()
    {
        return $this->hasMany('App\UserLoginSession');
    }
}
