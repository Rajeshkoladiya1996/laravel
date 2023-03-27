<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveBattleCoin extends Model
{
    protected $fillable = ['user_id','gift_id','battle_id','coins'];
    protected $table = 'live_battle_coins';
}
