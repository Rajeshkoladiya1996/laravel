<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvtarComponent extends Model
{
    use HasFactory;
    protected $fillable = ['id','avtartype_id','avtar_cat_id','image','component_id','iscolor','amount'];   
    protected $table = 'avtar_components';

    function avtartype()
    {
        return $this->belongsTo('App\Models\AvtarType','avtartype_id');
    } 
    function avtarcategory()
    {
        return $this->belongsTo('App\Models\AvtarCategory','avtar_cat_id');
    } 
}
