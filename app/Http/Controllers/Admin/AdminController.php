<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use mysql_xdevapi\Result;
use validator;
use Mail;
use Illuminate\Mail\Message;
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
        $roleData=Role::pluck('name','id');
        return view('admin.user.add',compact('roleData'));
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
            'truename'=>'required',
            'role_id'=>'required'
        ]);

        $model=Admin::create($data);
        if($model){
            return redirect(route('admin.user'))->with('success','添加用户成功');
        }
    }
    //修改页面展示
    public function edit(int  $id)
    {
//        dump($username);exit();
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
    //删除用户操作
    public function delete(int $id,Request $request)
    {
//        dd($id);
        $data=Admin::destroy($id);
//        dump($data);exit();
//        $data=1;
        if($data){
            return ['status'=>0,'msg'=>'删除成功'];
        }else{
            return ['status'=>1,'msg'=>'删除失败'];
        }
    }
    //批量删除
    public function dell(Request $request)
    {
        $ids=$request->get('ids');
//        return $ids;
        $data=Admin::destroy($ids);
        if($data){
            return ['status'=>0,'msg'=>'删除成功'];
        }else{
            return ['status'=>1,'msg'=>'删除失败'];
        }
    }
    //激活
    public function restore(Request $request)
    {
        $id=$request->get('id');
        $data=Admin::where('id',$id)->onlyTrashed()->restore();
//        return $data;
        if($data){
            return ['status'=>0,'msg'=>'修改成功'];
        }else{
            return ['status'=>1,'msg'=>'修改失败'];
        }
    }
}
