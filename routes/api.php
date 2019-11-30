<?php

use App\Exceptions\LoginException;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'v1','namespace'=>'Api'],function (){
    //小程序登录，获取openid
    Route::post('wxlogin','WxloginController@login');
    //小程序授权
    Route::post('userinfo','WxloginController@userInfo');
    //图片上传
    Route::post('upfile','WxloginController@upfile');
    //用户修改信息
    Route::put('editrenting','RentingController@editrenting');
    Route::get('renting','RentingController@show');
    //看房通知
    Route::get('notices','NoticeController@index');
    //querylist
    Route::get('querylist','NoticeController@querylist');
    //文章列表显示
    Route::get('articles','ArticleController@index');
        //详情
    Route::get('articles/{article}','ArticleController@show');
        //记录用户浏览次数
    Route::post('articles/history','ArticleController@history');
    //房源推荐接口
    Route::get('fang/recommend','FangController@recommend');
    //房源列表
    Route::get('fang/fanglist','FangController@fanglist');
    //房源列表的详情
    Route::get('fang/detail','FangController@detail');
    //收藏记录
    Route::get('fang/fav','FavController@fav');
    //判断是否收藏
    Route::get('fang/isfav','FavController@isfav');
    //收藏房源列表
    Route::get('fang/list','FavController@list');
    //房源属性
    Route::get('fang/attr','FavController@fangAttr');
});

Route::get('login',function (){
    // 获取请求的头信息数据
    $username = request()->header('username');
    $password = request()->header('password');
    $timstamp = request()->header('timstamp');
    $signate = request()->header('signate');
    $userData = ['username' => $username, 'password' => $password];
//    return $userData;
    //auth登录
    $bool = auth()->guard('api')->attempt($userData);
//    dump($bool);
    if(!$bool){
        //登录失败处理
        throw new LoginException('登录失败',1);
    }
    //进行签名比较
    $token=auth()->guard('api')->user()->token;
    $sign=$username.$token.$timstamp.$password;
    $sign=md5($sign);
//    return $sign;
    if($sign !==$signate){
        throw new LoginException('登录异常',2);
    }
    return ['status'=>0,'msg'=>'登录陈成功'];
});
