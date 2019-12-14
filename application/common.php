<?php
use think\Config;
$role_info = Config::get('role_info');
// 默认管理员角色
define('MANAGE_ROLE', $role_info[2]);
// 老师角色
define('TEACHER_ROLE', $role_info[3]);
// 学生角色
define('STUDENT_ROLE', $role_info[4]);
if(!function_exists('check_token')){
	function check_token($string){
		$token = session('__token__');
		if(!$token){
			return FALSE;
		}
		if($token != $string){
			return  FALSE;
		}
		session('__token__',NULL);
	}
}
if(!function_exists('get_user_id')){
	function get_user_id(){
		$token = request()->header('token');
		if(!$token){
			return FALSE;
		}
		// 匹配token是否可用
		$user_id = cache($token);
		if(!$user_id){
			return FALSE;
		}	
		return $user_id;
	}
}
if(!function_exists('make_token')){
	/**
	* 生成token令牌
	* @return string  token字符串
	*/
	function make_token(){
		$token = call_user_func('md5', $_SERVER['REQUEST_TIME_FLOAT']);
        Session::set('__token__', $token);
        return $token;
	}
}
if(!function_exists('ajax_return')){
	/**
	* json返回结果
	* @param  string  $message  提示语
	* @param  array   $data  要返回的结果信息，格式为数组
	* @param  int     $status 状态　０：失败（默认），１：成功
	* @return string  json字符串
	*/
	function ajax_return($message = 'ok',$data= [], $status = 0){
		$status = ($message=='ok') ? 200 : $status;

		$return_data['message'] = $message;

		$return_data['code'] = $status;

		$return_data['data']   = $data;
		
		return json($return_data);
	}
}
if(!function_exists('get_tree')){
	/**
	* 数据进行格式化
	* @param $data array 被格式化的数据
	* @param $id int 指定寻找哪一个分类下的子分类
	* @param $lev int 层次
	*/
	function get_tree($data,$id = 0,$lev = 0){
		static $list = [];//保存最终结果
		foreach ($data as  $value) {
			if($value['parent_id'] == $id){
				$value['lev'] = $lev;
				$list[]=$value;
				get_tree($data,$value['id'],$lev+1,false);
			}
		}
		return $list;
	}
}

if(!function_exists('list_to_tree')){
	/**
	* 把返回的数据集转换成Tree
	* @param array $list 要转换的数据集
	* @param string $pid parent标记字段
	* @param string $level level标记字段
	* @return array
	*/
	function list_to_tree($list, $pk='id', $pid = 'parent_id', $child = '_child', $root = 0) {
	    // 创建Tree
	    $tree = array();
	    if(is_array($list)) {
	        // 创建基于主键的数组引用
	        $refer = array();
	        foreach ($list as $key => $data) {
	            $refer[$data[$pk]] =& $list[$key];
	        }
	        foreach ($list as $key => $data) {
	            // 判断是否存在parent
	            $parentId =  $data[$pid];
	            if ($root == $parentId) {
	                $tree[] =& $list[$key];
	            }else{
	                if (isset($refer[$parentId])) {
	                    $parent =& $refer[$parentId];
	                    $parent[$child][] =& $list[$key];
	                }
	            }
	        }
	    }
	    return $tree;
	}
}
if(!function_exists('send_email')){
	function send_email($to,$message,$subject){
		$config = config('email');
		include_once '../extend/email/class.phpmailer.php';
		$mail             = new \PHPMailer();
		/*服务器相关信息*/
		$mail->IsSMTP();   //启用smtp服务发送邮件                     
		$mail->SMTPAuth   = true;  //设置开启认证             
		$mail->Host       = $config['host'];//指定smtp邮件服务器地址  
		$mail->Username   = $config['user'];//指定用户名	
		$mail->Password   = $config['pwd'];	//邮箱的第三方客户端的授权密码
		/*内容信息*/
		$mail->IsHTML(true);
		$mail->CharSet    ="UTF-8";			
		$mail->From       = $config['from'];	 		
		$mail->FromName   ="黑马面面管理员";	//发件人昵称
		$mail->Subject    = $subject; //发件主题
		$mail->MsgHTML($message);	//邮件内容 支持HTML代码
		$mail->AddAddress($to);  //收件人邮箱地址
		return $mail->Send();			//发送邮箱
	}
}
if(!function_exists('md6')){
	/**
	 * 用户密码加密
	 * 
	 * @param  string  $str  密码
	 * @param  string  $salt 盐
	 * @return string  密文
	 */
	function md6($str,$salt='1234'){
		return md5(md5($str).$salt);
	}
}
if(!function_exists('send_sms')){
	/**
	 * 发送短信验证码
	 * 
	 * @param  string  $to  接受者
	 * @param  bool    $datas 验证码内容
	 * @return bool 成功返回true
	 */
	function send_sms($to,$datas,$tempId=1){
		$config = config('sms');
		$rest = new sms($config['server_ip'],$config['server_port'],$config['soft_version']);
		$rest->setAccount($config['account_sid'],$config['account_token']);
		$rest->setAppId($config['appid']);
		$result = $rest->sendTemplateSMS($to,$datas,$tempId);
		if($result == NULL ) {
			return FALSE;
		}
		if($result->statusCode!=0) {
			return FALSE;
		}
		return TRUE;
	}
}
if(!function_exists('is_json')){
	/**
	 * 判断字符串是否为 Json 格式
	 * 
	 * @param  string  $data  Json 字符串
	 * @param  bool    $assoc 是否返回关联数组。默认返回数组
	 * 
	 * @return array|bool|object 成功返回转换后的对象或数组，失败返回 false
	 */
	function is_json($data = '',$assoc = true){

		$data = json_decode($data,$assoc);
		
		if($data && ( is_array($data) || is_object($data)) ){
			return $data;
		}
		return FALSE;
	}
}
if(!function_exists('is_phone')){
	/**
	 * 验证是否手机号
	 * 
	 * @param  string  $value  手机号码
	 * @return bool 成功返回true
	 */
	function is_phone($value){
	    $rule = '/^0?(13|14|15|17|18|19)[0-9]{9}$/';
	    $result = preg_match($rule, $value);
	    if ($result) {
	        return true;
	    } else {
	        return false;
	    }
	}
}

