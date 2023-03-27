<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpendGiftDetail extends Model
{
    protected $fillable = ['spend_id','gift_id','gems'];
    protected $table = 'spend_gift_details';

    function userspendgemsdetail(){
    	return $this->hasOne('App\Models\UserSpendGemsDetail','id','spend_id');
    }

    function gift_details(){
    	return $this->belongsTo('App\Models\Gift','gift_id')->with('gift_category');
    }
}
