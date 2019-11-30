<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bth;

class Article extends Model
{
    //
    use Bth;
    protected $guarded=[];
    protected $appends=['actionBth','dt'];
//    修改和删除按钮
    public function getActionBthAttribute()
    {
        return $this->editBth('admin.article.edit').' '.$this->delBth('admin.article.destroy');
    }
    //修改图片路径
    public function getPicAttribute()
    {
        if(stristr($this->attributes['pic'],'http')){
            return $this->attributes['pic'];
        }
    }
    //修改添加事件
    public function getDtAttribute()
    {
        return date('Y-m-d',strtotime($this->attributes['created_at']));
    }
    //分类
    public function cate()
    {
        return $this->belongsTo(Cate::class,'cid');

    }
}
