<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    protected $fillable = ['user_id','type','date','ip_address','device_type','device_id'];
    protected $table = 'user_login_logs';

    function user()
    {
    	return $this->hasOne('App\Models\User','id','user_id')->leftjoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')->select('users.id','users.first_name','users.last_name','users.username','users.email','users.phone','users.gender',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'users.county_code','users.stream_id','login_type','model_has_roles.*');
    }
}
