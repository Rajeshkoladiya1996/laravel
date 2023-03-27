<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRewardProgess extends Model
{
    protected $fillable = ['progress_points_id','user_id','date'];
    protected $table = 'user_reward_progress';
}
