<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchUser extends Model
{
    protected $fillable = ['from_id','to_id'];
    protected $table = 'search_users';

    function user(){
    	return $this->belongsTo('App\Models\User','to_id')->select('id','first_name','last_name','username','email','phone','gender',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type','stream_token');
    }
}
