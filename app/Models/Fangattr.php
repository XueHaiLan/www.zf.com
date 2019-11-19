<?php

namespace App\Models;

use App\Observers\FangAttrObserver;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bth;
class Fangattr extends Model
{
    //
    use Bth;
    protected $guarded=[];
    protected $appends=['actionBtr'];

    public function getactionBtrAttribute()
    {
        return $this->editBth('admin.fangattr.edit').' '.$this->delBth('admin.fangattr.destroy');
    }
    protected static function boot()
    {
        parent::boot();
        self::observe(FangAttrObserver::class);
    }


}
