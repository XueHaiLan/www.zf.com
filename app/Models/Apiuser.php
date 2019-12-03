<?php

namespace App\Models;

use App\Models\Traits\Bth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Apiuser extends Authenticatable
{
    //
    protected $guarded=[];
    protected $dates=['delete_at'];
    use Bth;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password']=bcrypt($value);
        $this->attributes['plainpass']=$value;
    }


}
