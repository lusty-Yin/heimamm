<?php 
/*
 * @Description: 题库模型
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:32
 */
namespace app\api\model;
class Questions extends Common{
	
	public function loadlist($params=[]){
		// 获取页码与页尺寸
		$limit = isset($params['limit'])?$params['limit']:10;

		$page = isset($params['page'])?$params['page']:1;
		// 组装查询条件
		$where =['is_del'=>0];
		// 组装普通查询where条件
		$allow_where = ['subject','step','enterprise','tag','difficulty','type'];
		foreach ($params as $key => $value) {
			if(in_array($key,$allow_where) && !empty($value)){
				$where[$key] = $value;
			}
		}
		// dump($params);
		// 组装创建者条件
		if(!empty($params['username'])){
			$user = model('User')->get(['name'=>$params['username']]);
			if($user){
				$where['user_id'] = $user->getAttr('id');
			}else{
				return ['items'=>[],'pagination'=>['total'=>0,'page'=>$page]];
			}
		}
		// 标题模糊查询
		if(!empty($params['title'])){
			$where['title'] = ['like','%'.$params['title'].'%'];
		}
		// 时间
		if(!empty($params['create_date'])){
			$params['create_date'] = date('Y-m-d',strtotime('+1 day',strtotime(substr($params['create_date'],0,10))));
			$start = strtotime($params['create_date']);
			$end = strtotime($params['create_date'].' 23:59:59');
			$where['create_time'] = ['between',[$start,$end]];
		}
		// 状态
		if(isset($params['status']) && ($params['status'] =='0' || $params['status'] ==1)){
			$where['status'] = $params['status'];
		}
		// 查询数据条数
		$total = $this->where($where)->count();
		// 查询数据
		$items = $this->where($where)->page($page,$limit)->order('id desc')->select();
		// 暂时这么处理 
		foreach ($items as $key => $value) {
			$items[$key]['username'] = model('User')->getName($value['user_id'],'username');
		
			$items[$key]['subject_name'] = model('Subject')->getShortName($value['subject']);
			$items[$key]['enterprise_name'] = model('Enterprise')->getShortName($value['enterprise']);

			$items[$key]['select_options'] = model('Options')->getOptions($value['id']);
		}
		return ['items'=>$items,'pagination'=>['total'=>$total,'page'=>$page]];
	}
	// 获取单体题库
	public function getOne($id){
		// 获取当前的题目信息
		$question = $this->find($id);
		if(!$question){
			$this->error = '数据不存在';
			return FALSE;
		}
		$question = $question->toArray();

		// 获取学科名称
		$question['subject'] = model('Subject')->getName($question['subject']);
		// 获取企业名称
		$question['enterprise'] = model('Enterprise')->getName($question['enterprise']);

		if($question['type'] !=3){
			// 查询选项
			$question['options'] = model('Options')->getOptions($id);
		}
		return $question;
	}
	public function addQuestion($params){
		$params['user_id'] = get_user_id();
		// 提取城市信息
		$params['city'] = implode(',',$params['city']);
		// 省市区
		switch ($params['type']) {
			case '1':
				unset($params['multiple_select_answer']);
				unset($params['short_answer']);
				break;
			case '2':
				unset($params['single_select_answer']);
				unset($params['short_answer']);
				$params['multiple_select_answer'] = implode(',',$params['multiple_select_answer']);
				break;
			case '3':
				unset($params['multiple_select_answer']);
				unset($params['single_select_answer']);
				break;
		}
		// 试题基本数据入库
		$this->allowField(TRUE)->isUpdate(FALSE)->save($params);
		
		$question_id= $this->getLastInsID();

		if($params['type'] !="简答"){
			model('Options')->addOptions($question_id,$params['select_options']);
		}
		return $question_id;
	}
	public function editQuestion($params){
		if($params['user_id']){
			unset($params['user_id']);
		}
		if($params['create_time']){
			unset($params['create_time']);
		}
		if($params['update_time']){
			unset($params['update_time']);
		}
		// 试题基本数据入库
		$this->allowField(TRUE)->isUpdate(TRUE)->save($params);
		model('Options')->editOptions($params);
		return TRUE;
	}
}