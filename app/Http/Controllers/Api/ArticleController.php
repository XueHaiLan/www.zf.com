<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyvalidateException;
use App\Models\Article;
use App\Models\ArticleCount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //获取文章列表
    public function index()
    {
//        return 1111;
        //获取的字段
        $fields=['id','title','desn','pic','created_at'];
        $data=Article::orderBy('id','asc')->select($fields)->paginate(5);
        return $data;
        return ['status'=>0,'data'=>$data,'msg'=>'成功'];
    }
    //获取文章内容
    public function show(Article $article)
    {
        return ['status'=>0,'data'=>$article,'msg'=>'ok'];
    }
    //记录用户浏览次数
    public function history(Request $request)
    {
        try{
            $data=$this->validate($request,[
               'openid'=>'required',
               'art_id'=>'required|numeric'
            ]);
        }catch (\Exception $exception){
            throw new MyvalidateException('验证异常',3);
        }

        //判断openid和art——id和当天时间是否存在，存在修改，不存在添加
        #当前时间
        $data['vdt']=date('Y-m-d');
        $model=ArticleCount::where($data)->first();
        if(!$model){//没数据，添加
            $data['click']=1;
            $model=ArticleCount::create($data);
        }else{
            //存在，增加1
            $model->increment('click');
        }
        return response()->json(['status'=>0,'msg'=>'记录成功','data'=>$model->click],201);
    }
}
