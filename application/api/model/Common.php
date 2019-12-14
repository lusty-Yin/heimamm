<?php 
namespace app\api\model;
use think\Model;
use think\Db;
/**
* 
*/
class Common extends Model
{
	protected $readonly = ['create_time'];
	// 用户标识
	public $user_id ;
	// 根据id获取名称
	public function getName($id,$name='name'){
		$data = $this->get($id);
		if(!$data){
			return '';
		}
		return $data->getAttr($name);
	}
	public function getShortName($id){
		$data = $this->get($id);
		if(!$data){
			return '';
		}
		return $data->getAttr('short_name');
	}

	// 初始化方法
	public function initialize(){
		
	}
	// 获取列表数据
	public function loadlist($params=[]){	
		// 获取页码与页尺寸
		$limit = isset($params['limit'])?$params['limit']:10;

		$page = isset($params['page'])?$params['page']:1;
		// 组装查询条件
		$where =['is_del'=>0];
		if(!empty($params['id'])){
			$where['id'] = $params['id'];
		}
		if(!empty($params['name'])){
			$where['name'] = $params['name'];
		}
		if(!empty($params['create_id'])){
			$where['create_id'] = $params['create_id'];
		}
		$total = $this->where($where)->count();
		// 查询数据
		$items = $this->where($where)->page($page,$limit)->select();
		return ['items'=>$items,'pagination'=>['total'=>$total,'page'=>$page]];
	}
	// 修改权限
	public function edit($post_data){
		if(isset($post_data['user_id'])){
			unset($post_data['user_id']);
		}
		if($post_data['create_time']){
			unset($post_data['create_time']);
		}
		if($post_data['update_time']){
			unset($post_data['update_time']);
		}
		return $this->isUpdate(TRUE)->allowField(TRUE)->save($post_data);
	}
	// 删除数据
	public function remove($id){
		return $this->isUpdate(TRUE)->save(['id'=>$id,'is_del'=>1]);
	}
	// 设置状态
	public function setStaus($id){
		$info = $this->get($id);
		$status = $info->getAttr('status')?0:1;
		return $this->isUpdate(TRUE)->save(['id'=>$id,'status'=>$status]);
	}
	// 基本添加数据
	public function add($post_data){
		$this->allowField(TRUE)->isUpdate(FALSE)->save($post_data);
		$id = $this->getLastInsId();
		return ['id'=>$id];
	}
	// 获取Db模型对象
	public function getModel($tableName=''){
		if(!$tableName){
			// 获取模型名称
			$model_name = $this->name;
			// 将模型名称转换为没有数据表的格式
			$tableName = strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $model_name));
		}
		return Db::name($tableName);
	}
}

?>