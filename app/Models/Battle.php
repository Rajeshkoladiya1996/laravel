<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    protected $fillable = ['id','from_id','to_id','stream_id','from_user_token'];
    protected $table = 'battles';

    function from_user()
    {
        return $this->belongsTo('App\Models\User','from_id')->select('id','first_name','last_name','username','email','phone','gender','stream_token',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type','stream_token');
    }

    function to_user()
    {
        return $this->belongsTo('App\Models\User','to_id')->select('id','first_name','last_name','username','email','phone','gender','stream_token',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type','stream_token');
    }

}
