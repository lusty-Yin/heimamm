<?php 
namespace app\api\validate;
use think\Validate;
/**
* 
*/
class Questions extends Validate
{
	protected $rule = [
		'title'=>'require',//标题
		'subject'=>'require|gt:0',//学科
		'enterprise'=>'require|gt:0',//企业
		'city'=>'require',//城市
		'type'=>'require|in:1,2,3|checkOptions',
		'difficulty'=>'require|in:1,2,3',
		'step'=>'require|in:1,2,3'
		// 'video'=>'require',
	];
	// 题目类型检查
	public function checkOptions($value,$rule,$data){
		if($value == "3"){
			return TRUE;
		}
		// 选择题 需要四个选项
		if(!isset($data['select_options']) || (count($data['select_options']) !=4) ){
			return FALSE;
		}
		return TRUE;
	}
}