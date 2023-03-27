<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['image','user_id','status'];
    protected $table = 'user_profiles';
}
