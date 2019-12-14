<?php 
namespace app\api\controller;
/**
* 学科
*/
class Subject extends Common
{
	// 删除
	public function remove(){
		return parent::remove();
	}
	// 设置状态
	public function setStaus(){
		return parent::setStaus();
	}
	// 获取列表数据
	public function loadlist(){
		return parent::loadlist();
	}
	// 添加
	public function add(){
		return parent::add();
	}
	// 编辑
	public function edit()
	{
		return parent::edit();
	}
}

?>