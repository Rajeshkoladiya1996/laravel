<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWalletRequest extends Model
{
    protected $table = 'user_wallet_requests';
   	protected $fillable = ['user_id','type','amount','status'];
   	
   	function user()
    {
    	return $this->belongsTo('App\Models\User','user_id')->select('id','first_name','last_name','username','email','phone','gender',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type','stream_token');
    }
}
