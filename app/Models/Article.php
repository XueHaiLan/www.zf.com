<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bth;

class Article extends Model
{
    //
    use Bth;
    protected $guarded=[];
    protected $appends=['actionBth'];
    //修改和删除按钮
    public function getActionBthAttribute()
    {
        return $this->editBth('admin.article.edit').' '.$this->delBth('admin.article.destroy');
    }
    //分类
    public function cate()
    {
        return $this->belongsTo(Cate::class,'cid');

    }
}
