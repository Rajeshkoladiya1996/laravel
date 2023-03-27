<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCategory extends Model
{
    protected $fillable = ['name','slug','image','status'];
    protected $table = 'gift_categories';

    function gift(){
    	return $this->hasMany('App\Models\Gift','gift_category_id','id');
    }
}
