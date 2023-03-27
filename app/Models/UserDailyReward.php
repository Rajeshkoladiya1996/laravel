<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDailyReward extends Model
{
    protected $fillable = ['reward_id','user_id','date'];
    protected $table = 'user_daily_rewards';
}
