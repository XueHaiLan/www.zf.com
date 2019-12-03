<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bth;

class Renting extends Model
{
    private static $host='http://www.zf.com/';
    use Bth;
    protected $dates=['deleted_id'];
    protected $guarded=[];

    //获取器------将图片地址转化为真是地址
    public function getCardImgAttribute()
    {
        if(empty($this->attributes['card_img'])){
            return '';
        }
        //将图片地址拼接的字符串转换为数组
        $arr=explode('#',$this->attributes['card_img']);
        //去出第一个元素
//        array_shift($arr);
//        return $arr;
        return array_map(function ($item){
            return self::$host . '/' . ltrim($item,'/');
        },$arr);
    }

}
