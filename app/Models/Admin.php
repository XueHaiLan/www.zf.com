<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
class Admin extends Authenticatable
{
    //软删除
    use SoftDeletes;
    protected $dates=['deleted_at'];
    //黑名单
    protected $guarded=[];

    //过滤器
    public function setPasswordAttribute($value)
    {
        $this->attributes['password']=bcrypt($value);
    }
    public function getList(Request $request, int $pagesize=10)
    {
        $st=$request->get('st');
        $et=$request->get('et');
        $kw=$request->get('kw');
//        dump($kw);
        return Admin::when($st,function($query)use($st,$et){
            $st=date('Y-m-i 00:00:00',strtotime($st));
            $et=date('Y-m-i 00:00:00',strtotime($et));
            $query->whereBetween('created_at',[$st,$et]);
        })->when($kw,function($query)use($kw){
            $query->where("username",'like',"%{$kw}%");
        })
            ->orderBy('id','desc')
            ->withTrashed()
            ->paginate($pagesize);
    }
}
