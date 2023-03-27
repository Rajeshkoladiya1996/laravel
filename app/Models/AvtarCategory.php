<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvtarCategory extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','status','image','class_name'];
    protected $table = 'avtar_categories';

    function avtarcomponent()
    {
        return $this->hasmany('App\Models\AvtarComponent','avtar_cat_id');
    }
}
