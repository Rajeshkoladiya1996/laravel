<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','username','email','phone','password','gender','profile_pic','login_type','facebook_id','google_id','apple_id','line_id','social_pic','device_token','device_id','otp','is_verified','device_type','is_active','is_online','logindate','stream_id','county_code','phone_code','hide_location','hide_near_by_videos','total_diamond','total_gems','earned_gems','user_type','level_id','total_point','stream_token'

        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }  

    // normal users list using join
    public static function users()
    {
        return static::leftjoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
           ->where('model_has_roles.role_id','=',4);
    } 
    
    // subadmin users list using join
    public static function subadmin()
    {
        return static::leftjoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
           ->where('model_has_roles.role_id','=',2);
    }   

    // Role list 
    public function userrole()
    {
        return static::leftjoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->leftjoin('roles', 'model_has_roles.role_id', '=', 'roles.id');
    }
    // follower hasMany
    public function follower()
    {
        return $this->hasMany('App\Models\UserFollower','from_id','id');
    } 

    // followers hasMany
    public function followers()
    {
        return $this->hasMany('App\Models\UserFollower','from_id','id');
    } 

    // following hasMany
    public function following()
    {
        return $this->hasMany('App\Models\UserFollower','to_id','id');
    }
    // favourite hasMany
    public function favourite()
    {
        return $this->hasMany('App\Models\UserFavourite','from_id','id');
    }
    
    // liveStream hasMany
    public function liveStream()
    {
        return $this->hasMany('App\Models\LiveStreamUser','user_id','id');
    }

    // Level hasMany
    public function level()
    {
        return $this->hasOne('App\Models\Level','id','level_id')->with('level_detail');
    }

    // tag
    public function tag(){
        return $this->hasMany('App\Models\UserTag','user_id','id');
    }

    // usertag
    public function usertag(){
        return $this->hasMany('App\Models\UserTag','user_id','id');
    }
}
