<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleAddRequest;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
//        $data=Article::all();
        //判断是否是ajax请求
        if($request->ajax()){
//            dump($data);
            //获取总记录数
            $count=Article::count();
            //起始位置
            $offset=$request->get('start',0);
            //显示的记录条数
            $limit=$request->get('length',10);
            //排序
            $order=$request->get('order')[0];
            //排序字段数组
            $colums=$request->get('columns')[$order['column']];
            //排序规则
            $orderType=$order['dir'];
            //排序字段
            $field=$colums['data'];
            //搜索
            $kw=$request->get('kw');
            $bulid=Article::when($kw,function ($query)use($kw){
                $query->where('title','like',"%$kw%");
            });
            //服务器端分页
            $data=$bulid->with('cate')->orderBy($field,$orderType)->offset($offset)->limit($limit)->get();
            //返回指定格式的json数据
            return [
                //客户端调用服务器次数
                'draw'=>$request->get('draw'),
                //数据总条数
                'recordsTotal'=>$count,
                //数据过滤后的总条数
                'recordFiltered'=>$count,
                //shuju
                'data'=>$data
            ];
        }
        return view('admin.article.index');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cateData=Cate::all()->toArray();
        $cateData=treeLevel($cateData);
//        dump($cateData);
        return view('admin.article.add',compact('cateData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleAddRequest $request)
    {
        //
        $data=$request->except(['_token','file']);
//        dump($data);exit();
        Article::create($data);
        return redirect(route('admin.article.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Article $article)
    {
        //获取url参数
        $url_query=$request->all();
        $cateData=Cate::all()->toArray();
//        dump($cateData);exit();
        $cateData=treeLevel($cateData);
        return view('admin.article.edit',compact('article','cateData','url_query'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
        $url=$request->get('url');
        $data=$request->except(['_token','file','url','_method']);
//        dump($article);exit();
        $article->update($data);
        $url=route('admin.article.index').'?'.http_build_query($url);
        return redirect($url);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
