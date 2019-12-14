<?php 
/*
 * @Description: 企业管理接口
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:33
 */
namespace app\api\controller;

class Enterprise extends Common
{
	public function loadlist(){
		return parent::loadlist();
	}
	// 删除
	public function remove(){
		return parent::remove();
	}

	public function setStaus(){
		return parent::setStaus();
	}

	public function get(){
		return parent::get();
	}

	public function add(){
		return parent::add();
	}
	
	public function edit(){
		return parent::edit();
	}
}

?>