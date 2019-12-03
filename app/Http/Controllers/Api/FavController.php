<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyvalidateException;
use App\Http\Resources\FavResourceController;
use App\Models\Fangattr;
use App\Models\Fav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavController extends Controller
{
    //收藏或取消收藏房源
    public function fav(Request $request)
    {
        try{
            $data=$this->validate($request,[
               'openid'=>'required',
               'fang_id'=>'required|numeric',
               //添加还是收藏的标识
               'add'=>'required|numeric'
            ]);
        }catch (\Exception $exception){
            throw new MyvalidateException('验证异常',3);
        }
        $add=$data['add'];
        unset($data['add']);

        $model=Fav::where($data)->first();
        if($add > 0){//添加
            if( !$model ){
                //数据不存在添加，存在不执行
                Fav::create($data);
            }
            $msg='添加成功';
        }else{
            //数据存在则删除
            if($model){
                $model->forceDelete();
            }
            $msg='取消收藏成功';
        }
        return ['status'=>0,'msg'=>$msg];
    }
    //判断房源是否是收藏房源
    public function isfav(Request $request)
    {
        try{
            $data=$this->validate($request,[
               'openid'=>'required',
               'fang_id'=>'required|numeric'
            ]);
        }catch (\Exception $exception){
            throw new MyvalidateException('验证异常',3);
        }
        //查看数据是否收藏
        $model=Fav::where($data)->first();
        if($model){
            return ['status'=>0,'msg'=>'取消收藏','data'=>1];
        }
        return ['status'=>0,'msg'=>'添加收藏','data'=>0];
    }

    //收藏列表
    public function list(Request $request)
    {
        try{
            $data=$this->validate($request,[
               'openid'=>'required'
            ]);
        }catch (\Exception $exception){
            throw new MyvalidateException('验证异常',3);
        }
        $data=Fav::where($data)->orderBy('updated_at','asc')->paginate(10);

        return ['status'=>0,'msg'=>'ok','data'=>new FavResourceController($data)];
    }
    //房源属性选项
    public function fangAttr(Request $request)
    {
        $attrData=Fangattr::all()->toArray();
        $attrData=subTree2($attrData);

        return ['status'=>0,'msg'=>'ok','data'=>$attrData];
    }

}
