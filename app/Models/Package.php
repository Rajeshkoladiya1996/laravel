<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','salmon_coin','image','ios_product_id','android_product_id','price','thai_price','ios_is_active','android_is_active'];
    protected $table = 'packages';

}
