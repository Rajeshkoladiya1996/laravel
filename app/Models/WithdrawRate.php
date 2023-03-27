<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRate extends Model
{
    use HasFactory;
    protected $fillable = ['rate'];
    protected $table = 'withdraw_rates';
}
