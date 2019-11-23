<?php
Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
    //登录页路由
    Route::get('login','LoginController@index')->name('login');
    Route::post('login','LoginController@logins')->name('logins');
    //首页路由
    Route::group(['middleware'=>'checkadmin'],function(){
        //展示页面
        Route::get('index','IndexController@index')->name('index');
        //欢迎页
        Route::get('welcome','IndexController@welcome')->name('welcome');
        //退出按钮
        Route::get('logout','IndexController@logout')->name('logout');
        //用户管理页面
        Route::get('user','AdminController@index')->name('user');
        //添加用户页面
        Route::get('user/add','AdminController@add')->name('add');
        //添加用户操作
        Route::post('user/add','AdminController@create')->name('create');
        //修改页面展示
        Route::get('user/edit/{id}','AdminController@edit')->name('edit');
        //修改页面提交
        Route::put('user/update/{id}','AdminController@update')->name('update');
        //删除用户操作
        Route::delete('user/del/{id}','AdminController@delete')->name('del');
        //批量删除
        Route::delete('user/dell','AdminController@dell')->name('dell');
        //恢复用户
        Route::get('user/restore','AdminController@restore')->name('restore');
        //权限资源路由
        Route::resource('role','RoleController');
        Route::resource('node','NodeController');
        //文件上传路由
        Route::post('Base/upfile','ArticleController@upfile')->name('base.upfile');
        //文章管理资源路由
        Route::resource('article','ArticleController');
        //房源管理资源路由
        Route::resource('fangattr','FangAttrController');
        //房东管理资源路由
            //房东导出excel
        Route::get('fangowner/export','FangOwnerController@export')->name('fangowner.export');
        Route::resource('fangowner','FangOwnerController');
        //房源管理
        Route::get('fang/city','FangController@getCity')->name('fang.city');
        Route::resource('fang','FangController');
    });
});
