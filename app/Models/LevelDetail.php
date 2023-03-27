<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelDetail extends Model
{
    protected $fillable = ['level_id','name','no_of_use','point','total_point','description'];
    protected $table = 'level_details';
}
