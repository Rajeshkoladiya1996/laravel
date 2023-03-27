<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['event_name','image','description','points','slug','status','start_date','end_date','terms_condition','thai_terms_condition','stream_type','reward_type','gift_category_id','primary_color','secondry_color','isGradient','start_gradient','end_gradient'];
    protected $table = 'events';

    public function rewardEvent(){
        return $this->hasMany('App\Models\RewardEvent','event_id','id');
    }

    function gift_category(){
    	return $this->belongsTo('App\Models\GiftCategory','gift_category_id','id')->with('gift');
	}
	
    public function reward_event(){
        return $this->hasMany('App\Models\RewardEvent','event_id','id');
    }
}
