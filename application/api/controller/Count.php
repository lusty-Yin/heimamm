<?php 
namespace app\api\controller;
// 数据统计
class Count extends Base
{
	// 面板数据统计
	public function title(){
		// 初始刷题处理及人均刷题数量
		$data = [
			'total_done_questions'=>0,
			'personal_questions'=>0
		];
		$user_model = model('User');
		// 用户总数
		$data['total_users'] = $user_model->count();
		// 今日增加用户数量
		$data['increment_users'] = model('User') ->whereTime('create_time', 'today')->count();
		$questions_model = model('Questions');
		// 新增试题数量
		$data['increment_questions'] = $questions_model ->whereTime('create_time', 'today')->count();
		// 试题总数据
		$data['total_questions'] = $questions_model->count();
		return ajax_return('ok',$data);
	}
	// 问题列表
	public function question(){
		$where = [];
		if(!empty($this->params['subject'])){
			// 查询学科id
			$subject = db('subject')->where('name',$this->params['subject'])->find();
			$where['a.subject'] = $subject['id'];
		}
		$data = db('questions')->alias('a')->field('COUNT(*) as value,b.name')->join('heima_enterprise b','a.enterprise=b.id')->group('a.enterprise')->where($where)->select();
		// echo db('questions')->getLastSql();exit;
		return ajax_return('ok',$data);
	}
	// 热门城市
	public function hotcitys(){

		$citys = db('city')->select();
		$data = [];
		foreach ($citys as $key => $value) {
			$city = $value['name'];
			$data[]=[
				'id'=>$value['id'],
				'name'=>$value['name'],
				'hotNumber'=>db('questions')->where('city','like',"$city%")->count()
			];
		}
		return ajax_return('ok',$data);
	}
}

?>