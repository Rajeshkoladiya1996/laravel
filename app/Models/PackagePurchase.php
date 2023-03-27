<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagePurchase extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','package_id','transaction_id','purchase_date','device_type' ,'purchase_details','purchase_status'];
    protected $table = 'package_purchases';

    public function package(){
        return $this->belongsTo('App\Models\Package','package_id','id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
