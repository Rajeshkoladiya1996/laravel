<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardEvent extends Model
{
    use HasFactory;
    protected $fillable = ['event_id','description','thai_description','days','points'];
    protected $table = 'reward_event';
}
