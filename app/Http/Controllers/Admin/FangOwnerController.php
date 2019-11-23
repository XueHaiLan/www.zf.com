<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fang;
use App\Models\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FangownerExport;

class FangOwnerController extends BaseController
{
    public function export()
    {
        //导出并下载
//        return Excel::download(new FangownerExport(), 'fangowner.xlsx');
        //导出到指定的文件夹
        return Excel::store(new FangownerExport(), 'fangowner.xlsx','fangownerexcel');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $excelpath=public_path('/uploads/fangownerexcel/fangowner.xlsx');
        $is_show=file_exists($excelpath) ? true : false;
        $data=FangOwner::orderBy('id','desc')->paginate($this->pagesize);
//        return $data;
        return view('admin.fangowner.index',compact('data','is_show'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.fangowner.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except(['file','_token']);
        FangOwner::create($data);
        return redirect(route('admin.fangowner.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //得到要展示图片的url
        $pics=FangOwner::where('id',$id)->get()->toArray()[0]['pic'];
        $picList=explode('#',$pics);
        //判断有误图片
        if(count($picList)<0){
            return ['status'=>1,'msg'=>'没有图片','data'=>[]];
        }
        //去出图片第一个元素（#）
        array_shift($picList);
        return ['status'=>0,'msg'=>'成功','data'=>$picList];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dump($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
