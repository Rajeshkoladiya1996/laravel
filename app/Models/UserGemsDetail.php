<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGemsDetail extends Model
{
    protected $fillable = ['user_id','gift_id','gems','qty','spend_qty','status'];
    protected $table = 'user_gems_details';

    function gems_detail()
    {
    	return $this->hasOne('App\Models\Gift', 'id','gift_id')->select('id','name','slug',\DB::raw("IF(gifts.image LIKE '%https://%' , gifts.image , ". "CONCAT('".url('/storage/app/public/uploads/gift/')."/', gifts.image)) AS image"));
    }
    
}
