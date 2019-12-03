<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\LoginException;
use App\Exceptions\MyvalidateException;
use App\Models\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RentingController extends Controller
{
    public function editrenting(Request $request)
    {
        try{
            $this->validate($request,[
               'openid'=>'required'
            ]);
        }catch (\Exception $e){
            throw new MyvalidateException('验证异常',3);
        }
        //获取数据
        $data=$request->all();
//        return $data['card_img'];
        $model=Renting::where('openid',$data['openid'])->first();
        if(!$model) throw new LoginException('没有查询到此信息',4);
        $model->update($data);
        return ['status'=>0,'msg'=>'更新用户信息成功'];
    }
    //获取用户信息
    public function show(Request $request)
    {
        try{
            $data=$this->validate($request,[
               'openid'=>'required'
            ]);
        }catch (\Exception $e){
            throw new MyvalidateException('验证异常',4);
        }
        //根据openid查询数据
//        return $data;
        $model=Renting::where('openid',$data['openid'])->first();
//        return $model;
        if(!$model) throw new LoginException('没有查询到此信息',4);
        return ['status'=>0,'msg'=>'成功','data'=>$model];
    }
}
