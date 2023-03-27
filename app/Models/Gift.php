<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = ['name','slug','gift_category_id','type','image','gems','status'];
    protected $table = 'gifts';

    function giftspurchase()
    {
    	return $this->hasMany('App\Models\UserGemsDetail','gift_id','id');
    }

    function gift_category(){
    	return $this->belongsTo('App\Models\GiftCategory','gift_category_id');
    }
}
