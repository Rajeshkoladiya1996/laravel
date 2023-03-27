<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = ['name','description','image','slug','type','type_value','status'];
    protected $table = 'rewards';

    public function gift(){
        return $this->hasOne('App\Models\Gift', 'id','type_value')->select('*','image',\DB::raw("CONCAT('".url('/storage/app/public/uploads/gift/')."/', image) AS image"));
    }
}
