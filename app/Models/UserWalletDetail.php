<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWalletDetail extends Model
{
    protected $fillable = ['user_id','amount','diamond_amount','create_by','update_by'];
    protected $table = 'user_wallet_details';

    function user()
    {
    	return $this->hasOne('App\Models\User','id','user_id')->select('id','first_name','last_name','username','email','phone','gender',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type','stream_token');
    }
}
