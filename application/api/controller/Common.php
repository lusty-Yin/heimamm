<?php 
/*
 * @Description: 登录后的公共控制器
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:33
 */
namespace app\api\controller;
class Common extends Base{
	public $user_id = NULL;//用户标识
	public $controller_name= NULL;//控制器名称
	public $token= NULL;//登录用户的token标识
	public function _initialize(){
		// 执行父类初始化方法 获取参数
		parent::_initialize();
		// 获取请求的控制器名称
		$this->controller_name = $this->request->controller();
		// $this->token = $this->params
		// 获取用户的标识
		$this->user_id = get_user_id();
		if($this->user_id == FALSE){
			json(['message'=>'token参数错误','data'=>[],'code'=>206])->send();
			exit();
		}
	}

	// 基础数据添加
	protected function add(){
		// 数据验证
		$result = $this->validate($this->params,$this->controller_name);
		if($result !== TRUE){
			return ajax_return($result,[],201);
		}
		$model = model($this->controller_name);

		$result = $model->add($this->params);

		if($result === FALSE){
			$error = $model->getError()?$model->getError():'网络错误';
			return ajax_return($error);
		}

		return ajax_return('ok',$result);
	}
	// 基础数据删除
	protected function remove(){
		if(!isset($this->params['id'])){
			return ajax_return('参数不符',[],201);
		}
		$model = model($this->controller_name);

		$result = $model->remove($this->params['id']);
		if($result === FALSE){
			return ajax_return($model->getError());
		}
		return ajax_return('ok');
	}
	// 基础设置状态
	protected function setStaus(){
		if(!isset($this->params['id'])){
			return ajax_return('参数不符',[],201);
		}
		model($this->controller_name)->setStaus($this->params['id']);
		return ajax_return('ok');
	}
	// 基础修改数据
	protected function edit(){
		// 数据验证
		$result = $this->validate($this->params,$this->controller_name.'.edit');
		if($result !== TRUE){
			return ajax_return($result,[],201);
		}
		$model = model($this->controller_name);

		$result = $model->edit($this->params);

		if($result === FALSE){
			$error = $model->getError()?$model->getError():'网络错误';
			return ajax_return($error);
		}
		return ajax_return('ok',$result);
	}
	// 基础获取数据
	protected function loadlist(){
		// 调用方法查询数据
		$data = model($this->controller_name)->loadlist($this->params);
		return ajax_return('ok',$data);
	}

}


?>