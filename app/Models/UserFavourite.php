<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavourite extends Model
{
    protected $fillable = ['from_id','to_id','status'];
    protected $table = 'user_favourites';

    function favouriteuser()
    {
    	return $this->belongsTo('App\Models\User','to_id')->select('id','first_name','last_name','username','email','phone','gender',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type');
    }
}
