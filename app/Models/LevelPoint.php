<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelPoint extends Model
{
    protected $fillable = ['name','description','category','points','per_day','status'];
    protected $table = 'level_points';
}
