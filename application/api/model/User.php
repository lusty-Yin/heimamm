<?php 
/*
 * @Description: 用户模型
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:32
 */
namespace app\api\model;
use think\Model;

class User extends Common
{
	public function edit($post_data){
		// 取出当前用户的盐
		$user = $this->get($post_data['id'])->toArray();
		// 密码修改
		if(isset($post_data['password'])){
			// 计算密码
			$post_data['password'] = md6($post_data['password'],$user->getAttr('salt'));
		}
		// 数据入库
		$this->allowField(TRUE)->isUpdate(TRUE)->save($post_data);

		return [];
			
	}
	// 后台添加用户
	public function add($post_data){
		$post_data['password'] = isset($post_data['password'])?$post_data['password']:'88888888';	
		// 计算密码
		$post_data['salt'] = rand(1000,9999);
		$post_data['password'] = md6($post_data['password'],$post_data['salt']);
		// 注册用户默认角色为学生
		$post_data['role_id'] = isset($post_data['role_id'])?$post_data['role_id']:STUDENT_ROLE;
		// 数据入库
		$this->allowField(TRUE)->isUpdate(FALSE)->save($post_data);

		//获取用户主键
		$user_id = User::getLastInsId();
		return ['user_id'=>$user_id];	
	}
	// 用户列表
	public function loadlist($params=[]){
		// 获取页码与页尺寸
		$limit = isset($params['limit'])?$params['limit']:10;
		$page = isset($params['page'])?$params['page']:1;
		// 组装查询条件
		$where =['is_del'=>0];
		if(!empty($params['username'])){
			$where['username'] =['like', '%'.$params['name'].'%'];
		}
		if(!empty($params['email'])){
			$where['email'] = $params['email'];
		}
		if(!empty($params['role_id'])){
			$where['role_id'] = $params['role_id'];
		}
		// 计算数据总数
		$total = $this->where($where)->count();
		// 查询数据
		$list = $this->where($where)->field('password,is_del,salt',true)->page($page,$limit)->order('id desc')->select();
		$items = [];
		// 提取角色名称
		$role_info = config('role_info');
		foreach($list as $value){
			$value['role'] = $role_info[$value['role_id']];
			$items[] = $value;
		}
		return ['items'=>$items,'pagination'=>['total'=>$total,'page'=>$page]];
	}
	// 添加用户
	public function regist($post_data = []){
		try {		
			// 计算密码
			$post_data['salt'] = rand(1000,9999);
			$post_data['password'] = md6($post_data['password'],$post_data['salt']);
			// 注册用户默认角色为学生
			$post_data['role'] = STUDENT_ROLE;
			// 数据入库
			$this->allowField(TRUE)->isUpdate(FALSE)->save($post_data);
			//获取用户主键
			$user_id = User::getLastInsId();
			return ['user_id'=>$user_id];
		} catch (\Exception $e) {
			return FALSE;
		}	
	}
	// 登录
	public function login($phone,$password){
		// 判断登录名称
		$user_info = $this->get(['phone'=>$phone]);
		if(empty($user_info)){
			$this->error = '登录名不匹配';
			return FALSE;
		}
		// 检查密码
		$user_info = $user_info->toArray();
		if($user_info['password'] != md6($password,$user_info['salt'])){
			$this->error = '登录密码不匹配';
			return FALSE;
		}
		// 生成token标识
		$token = $this->createToken($user_info['id']);
		return ['token'=>$token,'expires'=>3600*4];
	}

	// 生成token令牌
	public function createToken($user_id){
		$token = uniqid();
		cache($token,$user_id,3600*4);
		return $token;
	}
	//根据用户标识获取用户数据
	public function getUserInfo($user_id){
		// 根据用户ID查询用户数据
		$user_info = $this->field('password,is_del,salt',true)->find($user_id)->toArray();
		// 查询角色
		$role_info = model('Role')->find($user_info['role_id']);
		$user_info['role'] = $role_info['role_name'];
		if(!$user_info['avatar']){
			$user_info['avatar'] = 'face.jpg';
		}
		return $user_info;
	}
}

?>