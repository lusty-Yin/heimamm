<?php 
/*
 * @Description: 基础控制器
 * @Autor: phper_leo
 * @Date: 2019-11-10 12:11:33
 */
namespace app\api\controller;
use think\Request;
use think\Controller;
use think\Log;
class Base extends Controller{
	// 请求体信息
	public $params;
	public $request;
	public function _initialize(){
		$this->request = Request::instance();
		// 获取请求体参数信息
		$this->params = is_json($this->request->getContent());
		if(!$this->params){
			$this->params = input();
		}
		// 记录日志
		$this->writeLog('请求地址:'.$this->request->url(true).':请求参数:'.json_encode($this->params,JSON_UNESCAPED_UNICODE));
	}
	// 追加写入接口调用日志
	public function writeLog($content){
		// 追加写入时间
		session_start();
		$content = date('Y-m-d h:i:s', time()) . ":客户端标识" .session_id().':'. $content."\r\n";
		$file = "../runtime/dispatch_log/".date('Ymd').'.log';
		file_put_contents($file, $content, FILE_APPEND);
	}
}