<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipantDetail extends Model
{
    use HasFactory;
    protected $fillable = ['event_participant_id','gift_id','live_stream_id','points','is_active'];
    protected $table = 'event_participant_details';
}
