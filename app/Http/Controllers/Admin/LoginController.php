<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Mail\Message;
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
        Mail::send('admin/public/email',compact(''),function(Message $message){
            //添加用户通知
            $message->subject('添加用户通知');
            //收件人
            $message->to('1320875485@qq.com','雪海蓝');
        });
        return redirect(route('admin.index'));
    }
}
