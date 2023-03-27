<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvtarType extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','avtar_type','image','slug'];
    protected $table = 'avtar_types';
}
