<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FangResourceCollection;
use App\Models\Fang;
use App\Models\Fangattr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangController extends Controller
{
    //房源推荐
    public function recommend(Request $request)
    {
        $data=Fang::where('is_recommend','1')->orderBy('updated_at','desc')->limit(5)->get(['id', 'fang_name', 'fang_pic']);
        return ['status' => 0, 'msg' => '获取成功', 'data' => $data];
    }
    //房源列表
    public function fanglist()
    {
        $data=Fang::orderBy('id','desc')->paginate(5);
        return ['status'=>0,'msg'=>'ok','data'=>new FangResourceCollection($data)];
    }
    //房源详细信息
    public function detail(Request $request)
    {
        $data=Fang::with('fangowner:id,name,phone')->where('id',$request->get('id'))->first();
        $data['fang_config']=explode(',',$data['fang_config']);
        $data['fang_config']=Fangattr::whereIn('id',$data['fang_config'])->pluck('name');
        $data['fang_direction']=Fangattr::where('id',$data['fang_direction'])->value('name');

        return ['starus'=>0,'msg'=>'ok','data'=>$data];
    }
    //es模糊查询
    public function search(Request $request)
    {
        $kw=$request->get('kw');
//        return $kw;
        if(empty($kw)){
            $data=Fang::orderBy('id','desc')->paginate(5);
            return ['status'=>0,'msg'=>'ok','data'=>new FangResourceCollection($data)];
        }
        $client = \Elasticsearch\ClientBuilder::create()->setHosts(config('es.host'))->build();
        $params = [
            'index' => 'fangs',
            'body' => [
                'query' => [
                    'match' => [
                        'desn'=>[
                            'query' => $kw
                        ]
                    ]
                ]
            ]
        ];
        $results = $client->search($params);
        $total=$results['hits']['total']['value'];
        if($total == 0 ){//没有查找到数据
            return ['status'=>6,'msg'=>'没有查找到相关数据','data'=>[]];
        }
        $data=array_column($results['hits']['hits'],'_id');
        $data=Fang::whereIn('id',$data)->orderBy('id','desc')->paginate(5);
        return ['status'=>0,'msg'=>'ok','data'=>new FangResourceCollection($data)];
    }
}
