<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable = ['user_id','title','message','data','type'];
    protected $table = 'notifications';
}
