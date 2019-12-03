<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bth;

class notice extends Model
{
    //
    use Bth;
    protected $guarded=[];

    //关联
        //房主
    public function fangowner()
    {
        return $this->belongsTo(FangOwner::class,'fangowner_id');
    }
        //租客
    public function renting()
    {
        return $this->belongsTo(Renting::class,'renting_id');
    }
}
