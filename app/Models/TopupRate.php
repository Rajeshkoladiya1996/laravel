<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopupRate extends Model
{
    use HasFactory;
    protected $fillable = ['from_price','to_price','rate','is_active'];
    protected $table = 'topup_rates';
}
