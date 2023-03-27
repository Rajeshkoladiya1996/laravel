<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveStreamUser extends Model
{
    protected $fillable = ['user_id','stream_id','total_viewre','total_gems','total_chat'];
    protected $table = 'live_stream_users';

    function user(){
    	return $this->belongsTo('App\Models\User','user_id')->select('id','first_name','last_name','username','email','phone','gender',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type','stream_token');
    }
}
