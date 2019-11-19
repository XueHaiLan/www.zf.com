<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;

class IndexController extends BaseController
{
    //后台首页展示
    public function index()
    {
        //获取用户模型
        $userModel=auth()->user();
        //获取用户对应的角色
        $roleModel=$userModel->role;
//        dd($roleModel);
        //判断是不是超管
        if(auth()->user()->username!='admin'){
            $nodeModel=$roleModel->nodes()->where('is_menu','1')->get(['id','pid','name','route_name'])->toArray();
        }else{
            $nodeModel=Node::where('is_menu','1')->get(['id','pid','name','route_name'])->toArray();
        }
        $data=subTree($nodeModel);
//        dd($data);
        return view('admin.index.index',compact('data'));
    }
    //欢迎页
    public function welcome()
    {
        return view('admin.index.welcome');
    }
    //退出按钮
    public function logout()
    {
        auth()->logout();
        return redirect(route('admin.login'))->with('success','退出成功');
    }
}
