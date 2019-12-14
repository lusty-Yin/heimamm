<?php 
/*
 * @Description: 题库接口
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:33
 */
namespace app\api\controller;
use think\Request;

class Questions extends Common{

	// 删除
	public function remove(){
		return parent::remove();
	}
	// 设置状态
	public function setStaus(){
		return parent::setStaus();
	}
	// 获取列表
	public function loadlist(){
		return parent::loadlist();
	}
	// 获取单条题目数据
	public function getOne(){
		if(!isset($this->params['id'])){
			return ajax_return('参数错误');
		}
		$model = model('Questions');
		$data = $model->getOne($this->params['id']);
		if($data === FALSE){
			return ajax_return($model);
		}
		return ajax_return('ok',$data);
	}
	// 添加题目
	public function add(){
		// 数据验证
		$result = $this->validate($this->params,'Questions');
		if($result !== TRUE){
			return ajax_return($result,[],201);
		}
		$model = model('Questions');
		// 添加题目
		$result = $model->addQuestion($this->params);
		if($result === FALSE){
			
			$error = $model->getError()?$model->getError():'网络错误';

			return ajax_return($error,[],201);
		}
		return ajax_return('ok',['question_id'=>$result]);
	}
	// 编辑题目
	public function edit(){
		if(!isset($this->params['id']) || !isset($this->params['type'])){
			return ajax_return('参数不符');
		}
		
		$model = model('Questions');
		
		$result = $model->editQuestion($this->params);
		if($result === FALSE){
			
			$error = $model->getError()?$model->getError():'网络错误';

			return ajax_return($error);
		}
		return ajax_return('ok',['question_id'=>$result]);
	}
}