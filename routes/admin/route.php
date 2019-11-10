<?php
Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
    Route::get('login','LoginController@index')->name('login');
    Route::post('login','LoginController@logins')->name('logins');
});
