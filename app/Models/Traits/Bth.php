<?php

namespace App\Models\Traits;



trait Bth{

    private function checkAuth(string $routeName)
    {
        //获取组建中存贮的当前用户权限
        $usernode=request()->auths;
        if(!in_array($routeName,$usernode) && request()->username !='admin'){
            return false;
        }
        return true;
    }

    //修改
    public function editBth(string $routeName)
    {
        //页数
        $arr['start']=request()->get('start') ?? 0;
        //字段在表格的suoyin
        $arr['field']=request()->get('order')[0]['column'];
        //排序类型
        $arr['order']=request()->get('order')[0]['dir'];
        $params=http_build_query($arr);
        //生成url地址
        $url=route($routeName,$this);
        //判断￥url中有没有？
        if(stristr($url,'?')){
            $url_=$url.'&'.$params;
        }else{
            $url=$url.'?'.$params;
        }
        if($this->checkAuth($routeName)){
            return '<a href="'.$url.'" class="label label-primary radius">修改</a>';
        }
        return '';
    }
    //删除
    public function delBth(string $routeName)
    {
        if($this->checkAuth($routeName) && request()->uername!='admin'){
            return '<a id="del" href="'.route($routeName,$this).'" class="label label-danger radius">删除</a>';
        }
        return '';
    }
    //查看
    public function showBth(string $routeName)
    {
        if($this->checkAuth($routeName) && request()->uername!='admin'){
            return '<a href="'.route($routeName,$this).'" class="label label-success radius showBth">查看</a>';
        }
        return '';
    }
}
