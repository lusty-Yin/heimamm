<?php 
/*
 * @Description: 用户数据验证器
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:33
 */
namespace app\api\validate;
use think\Validate;

class User extends Validate
{
	
	protected $rule = [
		'username|用户名'=>'require|unique:user',
		'phone|手机号'=>'require|checkFormat|unique:user',
		'email|邮箱'=>'require|email|unique:user',
		'avatar|头像'=>'require|checkAvatar',
		'password|密码'=>'require',
	];
	protected $message=[
		'phone.checkFormat'=>'手机号码格式错误',
		'phone.unique'=>'手机号重复',
		'avatar.checkAvatar'=>'头像地址错误'
	];
	// 定义场景
	protected $scene =[
		'login'=>[
			'phone'=>'require|checkFormat',
			'password'=>'require'
		],
		'edit'=>['username','phone','email'],
		'add'=>['username','phone','email']
	];
	// 检查头像
	public function checkAvatar($value,$rule,$data){
		if(!file_exists($value)){
			return FALSE;
		}
		return TRUE;
	}
	// 检查手机号格式
	public function checkFormat($value,$rule,$data){
		// 检查格式是否正确
		if(!is_phone($value)){
			return FALSE;
		}
		return TRUE;
	}
}

?>