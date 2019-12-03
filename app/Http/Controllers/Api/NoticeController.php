<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyvalidateException;
use App\Models\Article;
use App\Models\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use QL\QueryList;
use QL\Ext\CurlMulti;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        try{
            $data=$this->validate($request,[
               'openid'=>'required'
            ]);
        }catch (\Exception $e){
            throw new MyvalidateException('验证异常',3);
        }
        //根据openid来获取对应的租客ID
        $renting_id=Renting::where($data)->value('id');
//        return $renting_id;
        //根据租客ID返回对应的看房通知
        $data=\App\Models\notice::
            with('fangowner:id,name,phone')
            ->where('renting_id',$renting_id)
            ->orderBy('id','asc')
            ->paginate(2);
        return ['status'=>0,'msg'=>'ok','data'=>$data];
    }

    public function querylist()
    {
        $ql = QueryList::getInstance();
        $ql->use(CurlMulti::class);
        $ql->use(CurlMulti::class,'curlMulti');
        $ql->rules([
            'body'=>['.bd','html'],
        ])->curlMulti([
            'https://news.ke.com/bj/baike/0244006.html'
        ])
            ->success(function (QueryList $ql,CurlMulti $curl,$r){
//            echo "Current url:{$r['info']['url']} \r\n";
            $data = $ql->query()->getData();
//            dump($data[0]);
//                $body=$data[0]['body'];
                Article::where('cid','2')->update($data[0]);
        })->start([
                // 最大并发数，这个值可以运行中动态改变。
                'maxThread' => 10,
                // 触发curl错误或用户错误之前最大重试次数，超过次数$error指定的回调会被调用。
                'maxTry' => 3,
                // 全局CURLOPT_*
                'opt' => [
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_CONNECTTIMEOUT => 1,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ]
            ]);
    }
}
