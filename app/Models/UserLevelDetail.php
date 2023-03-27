<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevelDetail extends Model
{
    protected $fillable = ['user_id','level_detail_id','point','per_day','date'];
    protected $table = 'user_level_details';

    public function level_point()
    {
    	return $this->hasOne('App\Models\LevelPoint','id','level_detail_id');
    }
}
