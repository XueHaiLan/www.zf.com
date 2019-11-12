<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use validator;
class AdminController extends BaseController
{
    //用户页面展示
    public function index(Request $request)
    {
        $data=(new Admin())->getList($request,$this->pagesize);
        return view('admin.user.user',compact('data'));
    }
    //添加页面展示
    public function add()
    {
        return view('admin.user.add');
    }
    //添加页面添加
    public function create(Request $request)
    {
//        echo 111;exit();
        $data=$this->validate($request,[
            'username'=>'required|unique:admins,username',
            'password'=>'required|confirmed',
            'sex'=>"in:先生,女士",
            'phone'=>'nullable|min:6',
            'email'=>'nullable',
            'truename'=>'required'
        ]);

        $model=Admin::create($data);
        if($model){
            return redirect(route('admin.user'))->with('success','添加用户成功');
        }
    }
    //修改页面展示
    public function edit(int $id)
    {
        $data=Admin::find($id);
        return view('admin.user.edit',compact('data'));
    }
    //修改页面修改
    public function update(Request $request,int $id)
    {
//        dump($id);exit();
        $data=$this->validate($request,[
            'username'=>'required|unique:admins,username,'.$id,
            'password'=>'confirmed',
            'sex'=>"in:先生,女士",
            'phone'=>'nullable|min:6',
            'email'=>'nullable',
            'truename'=>'required'
        ]);
        if(empty($data['password'])){
            unset($data['password']);
        }
        $model=Admin::where('id',$id)->update($data);
        if(!$model){
            return redirect(route('admin.index'));
        }
        return redirect(route('admin.index'));

//        dump($model);
    }
}
