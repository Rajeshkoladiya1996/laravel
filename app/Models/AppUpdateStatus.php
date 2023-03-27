<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUpdateStatus extends Model
{
    use HasFactory;
    protected $table = 'app_update_statuses';
    protected $fillable = ['device_type','device_version','update_force','is_production','message','contant_update_day','is_festival'];
}
