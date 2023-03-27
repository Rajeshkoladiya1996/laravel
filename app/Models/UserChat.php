<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    use HasFactory;
    use Prunable;

    protected $fillable = ['from_id','to_id','live_stream_id','battle_id','message','message_detail','status'];
    protected $table = 'user_chats';

    public function prunable()
    {
        return static::where('created_at', '<=',now()->subDays(3));
    }
}
