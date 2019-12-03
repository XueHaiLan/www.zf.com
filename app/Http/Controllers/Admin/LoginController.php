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
//        echo bcrypt('123456');exit;
        return view('admin/login/login');
    }
    public function logins(Request $request){
        $data=$this->validate($request,[
            'username'=>'required',
            'password'=>'required',
            'captcha'=>'required|captcha'
        ]);
        unset($data['captcha']);
//        dump($data);
        $bool=auth()->attempt($data);
//        dd($bool);
//        dump(auth()->user()->id);exit();
        if(!$bool){
            return redirect(route('admin.login'))->withErrors(['error'=>"登录失败,账户或密码错误"]);
        }
        //添加邮件内容
        Mail::send('admin/public/email',[],function(Message $message){
            //邮件标题
            $message->subject('添加用户通知');
            //收件人
            $message->to('1320875485@qq.com','雪海蓝');
        });
        return redirect(route('admin.index'));
    }
}
