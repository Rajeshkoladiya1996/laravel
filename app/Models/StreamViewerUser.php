<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamViewerUser extends Model
{
    protected $fillable = ['live_stream_id','user_id','status'];
    protected $table = 'stream_viewer_users';


    function user()
    {
    	return $this->belongsTo('App\Models\User','user_id')->select('id','first_name','last_name','username','email','phone','gender','level_id',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type');
    }
}
