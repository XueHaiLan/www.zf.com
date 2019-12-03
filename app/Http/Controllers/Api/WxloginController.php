<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyvalidateException;
use App\Models\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class WxloginController extends Controller
{
    //小程序登录获取openid
    public function login()

    {
        $code=\request()->get('code');
        $appid=config('wx.appid');
        $secret=config('wx.secret');
        $url=sprintf(config('wx.wxloginUrl'),$appid,$secret,$code);
        //verify：不检查ssl证书
        $client=new Client(['timeout'=>5,'verify'=>false]);

        $response=$client->get($url);
        //getBody：得到请求的主体
        $json=(string)$response->getBody();
        $arr=json_decode($json,true);
        $openid=$arr['openid'] ?? 'none';
        if($openid !='none'){
            $info=Renting::where('openid',$openid)->value('openid');
            if(!$info){
                Renting::create(['openid'=>$openid]);
            }
        }
        return ['openid'=>$openid];
    }
    //小程序授权，将个人信息添加到数据库中
    public function userInfo(Request $request)
    {
        try{
            $data=$this->validate($request,[
                'openid'=>'required',
                'nickname'=>'required',
                'sex'=>'required',
                'avatar'=>'required'
            ]);
        }catch (\Exception $e){
            throw new MyvalidateException('验证不通过',3);
        }
        $model=Renting::where('openid',$data['openid'])->first();
        if(!$model){
            Renting::create($data);
        }else{
            $model->update($data);
        }
        return ['status'=>0,'msg'=>'成功'];
    }
    //图片上传
    public function upfile(Request $request)
    {
        $file=$request->file('cardimg');
        //在renting路径下创建card文件夹存储文件
        $info=$file->store('card','renting');
        return ['status'=>0,'path'=>'/uploads/renting'.'/'.$info];
    }
    //文件删除
    public function delfile(Request $request)
    {
        try{
            $data=$this->validate($request,[
                'url'=>'required'
            ]);
        }catch (\Exception $exception){
            throw new MyvalidateException('验证不通过',3);
        }
        Storage::delete($data);
        return ['status'=>0,'msg'=>'删除成功'];
    }
}

