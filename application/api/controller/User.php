<?php 
/*
 * @Description: 用户管理接口
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:33
 */
namespace app\api\controller;


class User extends Common
{
	public function edit(){
		// 数据验证
		$result = $this->validate($this->params,'User.edit');
		if($result !== TRUE){
			return ajax_return($result,[],201);
		}
		$model = model('User');
		// 登录
		$result = $model->edit($this->params);

		if($result === FALSE){
			return ajax_return($model->getError(),[],202);
		}
		return ajax_return('ok');
	}
	// 删除用户
	public function remove(){
		return parent::remove();
	}
	// 设置用户状态 启用或者禁用
	public function setStaus(){
		return parent::setStaus();
	}
	// 创建用户
	public function addUser(){
		// 数据验证
		$result = $this->validate($this->params,'User.add');
		if($result !== TRUE){
			return ajax_return($result,[],201);
		}
		$model = model('User');
		// 登录
		$result = $model->add($this->params);

		if($result === FALSE){
			return ajax_return($model->getError(),[],202);
		}
		return ajax_return('ok',$result);
	}
	// 获取用户列表
	public function loadlist(){
		return parent::loadlist();
	}
	// 退出登录
	public function logout(){
		// 销毁token
		cache($this->token,NULL);
		return ajax_return('ok');
	}
	// 根据token获取用户的信息
	public function getUserInfo(){
		$data = model('User')->getUserInfo($this->user_id);
		return ajax_return('ok',$data);
	}
}


?>