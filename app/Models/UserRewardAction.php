<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRewardAction extends Model
{
    protected $fillable = ['user_daily_rewards_id','action_id','type'];
    protected $table = 'user_reward_actions';
}
