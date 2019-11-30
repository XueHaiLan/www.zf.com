<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->check()){
            return redirect(route('admin.login'))->withErrors(['error'=>'请先登录']);
        }
        //获取用户数据
        $userModel=auth()->user();
//        dump($userModel);
        //获取角色
        $roleModel=$userModel->role;
        //获取权限role
        $nodeModel=$roleModel->nodes()->pluck('route_name','id')->toArray();
        $nodeModel=array_filter($nodeModel);
        $allowList=[
            'admin.index',
            'admin.logout',
            'admin.welcome'
        ];
        //合并两个路由
        $nodeModel=array_merge($nodeModel,$allowList);
        //把用户的权限写到request对象中
        $request->auths=$nodeModel;
        //获取现在页面的路由
        $routeName=$request->route()->getName();
        //获取当前用户名
        $username=auth()->user()->username;
        //保存当前用户名
        $request->username=$username;
        //判断是否具有权限
        if(!in_array($routeName,$nodeModel) && $username != 'admin'){
            exit('抱歉你没有这个权限');
        }
//        dump($nodeModel);
        return $next($request);
    }
}
