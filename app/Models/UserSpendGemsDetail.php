<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSpendGemsDetail extends Model
{
    protected $fillable = ['from_id','to_id','live_stream_id','total_gems'];
    protected $table = 'user_spend_gems_details';


    function user()
    {
    	return $this->belongsTo('App\Models\User','from_id')->select('id','first_name','last_name','username','email','phone','gender',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type','stream_token');
    }

    function boradcaster(){
    	return $this->belongsTo('App\Models\User','to_id')->select('id','first_name','last_name','username','email','phone','gender',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"),'county_code','stream_id','login_type','stream_token');
    }

    function gift_detail(){
    	return $this->hasOne('App\Models\SpendGiftDetail', 'spend_id','id')->with('gems_detail');
    }

    
}
