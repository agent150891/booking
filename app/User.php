<?php

namespace Svityaz;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'role', 'password',
    ];
    protected $table = 'users';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    static function getCurrent()
    {
        if (session('user_id')){
            $user = \DB::table('users')->where('id','=',session('user_id'))->first();
            $user->phone =  \DB::table('phones')->where('user_id','=',session('user_id'))->value('phone');
        } else {
            $user = false;
        }
        return $user;
    }
}
