<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;

class IndexController extends BaseController
{
    //后台首页展示
    public function index()
    {
        return view('admin.index.index');
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
