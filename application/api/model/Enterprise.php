<?php 
namespace app\api\model;

/**
* 学科模型
*/
class Enterprise extends Common
{
	protected $resultSetType = '\think\Collection';
	// 获取列表数据
	public function loadlist($params=[]){	

		// 获取页码与页尺寸
		$limit = isset($params['limit'])?$params['limit']:10;
		$page = isset($params['page'])?$params['page']:1;
		// 组装查询条件
		$where =['a.is_del'=>0];
		if(!empty($params['eid'])){
			$where['a.eid'] = ['like','%'.$params['eid'].'%'];
		}
		if(!empty($params['name'])){
			$where['a.name'] =  ['like','%'.$params['name'].'%'];
		}
		if(!empty($params['username'])){
			$user = model('User')->get(['username'=>$params['username']]);
			if($user){
				$where['a.user_id'] = $user->getAttr('id');
			}else{
				return ['items'=>[],'pagination'=>['total'=>0,'page'=>$page]];
			}
		}
		if(isset($params['status']) && ($params['status'] =='0' || $params['status'] ==1)){
			$where['a.status'] = $params['status'];
		}
		// dump($where);exit();
		$total = $this->alias('a')->where($where)->count();
		// 查询数据
		$items = $this->where($where)->alias('a')->order('id desc')->field('a.*,b.username')->page($page,$limit)->join('heima_user b','a.user_id=b.id','left')->select();
		// echo $items;exit;
		return ['items'=>$items,'pagination'=>['total'=>$total,'page'=>$page]];
	}
	// 学科企业
	public function add($post_data=[]){
		$post_data['user_id'] = get_user_id();
		$this->allowField(TRUE)->isUpdate(FALSE)->save($post_data);
		$id = $this->getLastInsId();
		return ['id'=>$id];
	}
}

?>