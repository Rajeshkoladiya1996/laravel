<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    
	protected $fillable = ['name','slug','total_point','description','status'];
	protected $table = 'levels';

	function level_detail()
	{
		return $this->hasMany('App\Models\LevelDetail','level_id','id');
	}
}
