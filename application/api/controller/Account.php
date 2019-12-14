<?php 
/*
 * @Description: 用户账号接口
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:33
 */
namespace app\api\controller;
use think\Request;
use think\Response;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class Account extends Base{
	
	// 头像上传
	public function uploads(){
		$request = Request::instance();
		if(!$request->isPost()){
			return ajax_return('非法请求',[],203);
		}
		// 获取file对象
		$file = $request->file('image');
		if($file==FALSE){
			return ajax_return('没有上传的文件',[],204);
		}
		// 移动到框架应用根目录/public/uploads/ 目录下
		$upload_root = config('upload_root');

	    $info = $file->validate(['size'=>1024*1024*2,'ext'=>'jpg,jpeg,png,gif'])->move($upload_root);
	    if($info){
	    	// 获取文件上传地址
	    	$file_path = str_replace('\\', '/', $upload_root.$info->getSaveName());
	    	
	    	return ajax_return('ok',['file_path'=>$file_path]);
	    }
	    return ajax_return($file->getError(),[],'205');	
	}
	// 题库上传文件得到地址 由于题库上传没有token验证
	public function upload(){
		$request = Request::instance();
		if(!$request->isPost()){
			return ajax_return('非法请求',[],203);
		}
		// 获取file对象
		$file = $request->file('file');
		if($file ==FALSE){
			return ajax_return('没有上传的文件',[],204);
		}
		// 移动到框架应用根目录/public/uploads/ 目录下
		$upload_root = config('upload_root');

	    $info = $file->move($upload_root);
	    if($info){
	    	// 获取文件上传地址
	    	$url = str_replace('\\', '/', $upload_root.$info->getSaveName());
	    	
	    	return ajax_return('ok',['url'=>$url]);
	    }
	    return ajax_return($file->getError(),[],'205');	
	}
	// 生成验证码
	public function captcha(){
		$this->params['type'] = isset($this->params['type'])?$this->params['type']:'login';
		$config = [
			'codeSet'  => '123456789', 
			// 验证码字体大小(px)
			'fontSize' => 25, 
			'useNoise' => false,
			// 验证码图片高度
			'imageH'   => 46,
			// 验证码图片宽度
			'imageW'   => 180, 
			// 验证码位数
			'length'   => 4,
		];
		$obj = new \think\captcha\Captcha($config);
		return $obj->entry($this->params['type']);
	}
	// 发送短信验证码
	public function sendSms(){		
		if(!is_phone($this->params['phone'])){
			return ajax_return('手机号码格式错误');
		}

		$obj = new \think\captcha\Captcha();
		if(!$obj->check($this->params['code'],'sendsms')){
			return ajax_return('验证码错误');
		}
		// 验证是否已经注册发送过短信
		if(db('user')->where(['phone'=>$this->params['phone']])->find()){
			return ajax_return('已经注册过该手机号');
		}
		// 验证码
		$captcha = rand(1000,9999);
		
		return ajax_return('ok',['captcha'=>$captcha]);
	}
	// 用户登录
	public function login(){
		// 数据验证
		$result = $this->validate($this->params,'User.login');
		if($result !== TRUE){
			return ajax_return($result,[],201);
		}
		// 检查验证码
		$obj = new \think\captcha\Captcha();
		if(!$obj->check($this->params['code'],'login')){
			return ajax_return('验证码错误',[],202);
		}
		$model = model('User');
		// 登录
		$result = $model->login($this->params['phone'],$this->params['password']);

		if($result === FALSE){
			return ajax_return($model->getError(),[],202);
		}
		// 组装响应头设置cookie
		$header=[
			'Set-Cookie'=>'token='.$result['token']
		];

		$res_data = [
			'code'=>200,
			'msg'=>'ok',
			'data'=>$result
		]; 
		return Response::create($res_data,'json',200,$header);
	}
	// 用户注册
	public function register(){
		// 数据验证
		$result = $this->validate($this->params,'User');

		if($result !== TRUE){
			return ajax_return($result,[],201);
		}
		// 注册入库
		$model = model('User');

		$result = $model->regist($this->params);

		if($result === FALSE){
			return ajax_return('服务端异常');
		}
		return ajax_return('ok',$result);
	}
}
?>
