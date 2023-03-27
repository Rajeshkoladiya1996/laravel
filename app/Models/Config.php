<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
 	protected $fillable = ['cash_amount','cash_diamond_rate','gems_diamond_rate','diamond_gems_rate','create_by','update_by'];
    protected $table = 'configs';
}
