<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressPoints extends Model
{
    protected $fillable = ['name','slug','day','image','points','status'];
    protected $table = 'progress_points';
}
