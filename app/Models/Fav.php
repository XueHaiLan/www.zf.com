<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    protected $guarded=[];



    //房源
    public function fang()
    {
        return $this->belongsTo(Fang::class,'fang_id');
    }
}
