<?php

namespace App\Http\Middleware;

use App\Exceptions\LoginException;
use Closure;

class CheckApi
{
    /**
     * Handle an incoming request.
     *接口安全验证
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        return 111111111;
        // 获取请求的头信息数据
        $username = $request->header('username');
        $password = $request->header('password');
        $timstamp = $request->header('timstamp');
        $signate = $request->header('sign');
//        return $signate;
        $userData = ['username' => $username, 'password' => $password];
//        return $userData;
//    return $userData;
        //auth登录
        $bool = auth()->guard('api')->attempt($userData);
//    dump($bool);
        if(!$bool){
            //登录失败处理
            return response()->json(['status'=>100,'msg'=>'登录验证异常1111111111111111111111','data'=>[]],401);
        }
        //进行签名比较
        $token=auth()->guard('api')->user()->token;
        $sign=$username.$token.$timstamp.$password;
        $sign=md5($sign);
//    return $sign;
        if($sign !==$signate){
            //登录失败处理
            return response()->json(['status'=>100,'msg'=>'登录验证异常2222222222','data'=>[]],401);
        }
        return $next($request);
    }
}
