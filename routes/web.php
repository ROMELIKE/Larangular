<?php


Route::get('/', function () {
    return view('admin.user.list');
});


//Route::get('test',['as'=>'get.test','uses'=>'MemberController@testImage']);
Route::get('list',['as'=>'get.list','uses'=>'MemberController@getList']);
Route::get('add',['as'=>'get.add','uses'=>'MemberController@getAdd']);

Route::post('add',['as'=>'post.add','uses'=>'MemberController@postAdd']);
Route::get('delete/{id}',['as'=>'get.delete','uses'=>'MemberController@getDelete'])->where('id', '[0-9]+');
Route::get('edit/{id}',['as'=>'get.edit','uses'=>'MemberController@getEdit'])->where('id', '[0-9]+');
Route::post('edit/{id}',['as'=>'post.edit','uses'=>'MemberController@postEdit'])->where('id', '[0-9]+');
