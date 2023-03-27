<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotTagSetting extends Model
{
    use HasFactory;
    protected $fillable = ['followers','salmon_coin'];
    protected $table = 'hot_tag_settings';
}
