<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //
    public function index(){
        //显示登陆页面
        return view('admin/login/login');
    }
    public function logins(Request $request){
        $data=$this->validate($request,[
            'username'=>'required',
            'password'=>'required'
        ]);
        $bool=auth()->attempt($data);
//        dump(auth()->user()->id);exit();
        if(!$bool){
            return redirect(route('admin.login'))->withErrors(['error'=>"登录失败,账户或密码错误"]);
        }
        return redirect(route('admin.index'));
    }
}
