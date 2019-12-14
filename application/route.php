<?php
use think\Route;

Route::any('data/title','api/count/title');
Route::any('data/statistics','api/count/question');
Route::any('data/hot_cities','api/count/hotcitys');

// 用户注册头像上传
Route::post('uploads','api/account/uploads');
// 用户注册
Route::post('register','api/account/register');
// 发送短信验证码
Route::post('sendsms','api/account/sendsms');
// 发送短信验证码
Route::post('login','api/account/login');
// 创建验证码
Route::get('captcha','api/account/captcha');

// 获取用户数据
Route::get('info','api/user/getuserinfo');
// 退出登录
Route::get('logout','api/user/logout');
// 用户列表
Route::get('user/list','api/user/loadlist');
// 用户添加
Route::post('user/add','api/user/addUser');
// 设置用户状态
Route::post('user/status','api/user/setstaus');
// 删除用户
Route::post('user/remove','api/user/remove');
// 修改用户
Route::post('user/edit','api/user/edit');

// 企业添加
Route::post('enterprise/add','api/enterprise/add');
// 企业列表
Route::get('enterprise/list','api/enterprise/loadlist');
// 设置状态
Route::any('enterprise/status','api/enterprise/setstaus');
// 删除
Route::any('enterprise/remove','api/enterprise/remove');
// 编辑企业
Route::any('enterprise/edit','api/enterprise/edit');

// 学科添加
Route::post('subject/add','api/subject/add');
// 学科列表
Route::get('subject/list','api/subject/loadlist');
// 学科状态
Route::any('subject/status','api/subject/setstaus');
// 学科
Route::any('subject/remove','api/subject/remove');
// 学科企业
Route::any('subject/edit','api/subject/edit');



Route::post('question/upload','api/account/upload');
// 题库添加
Route::post('question/add','api/questions/add');
// 题库列表
Route::get('question/list','api/questions/loadlist');
// 题库状态
Route::any('question/status','api/questions/setstaus');
// 题库删除
Route::any('question/remove','api/questions/remove');
// 题目编辑
Route::any('question/edit','api/questions/edit');
// 获取单条题目信息
Route::any('question/one','api/questions/getOne');