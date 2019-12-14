<?php 
namespace app\api\validate;
use think\Validate;
/**
* 
*/
class Enterprise extends Validate
{
	
	protected $rule = [
		'name'=>'require',
		'eid'=>'require|unique:enterprise',
	];
	protected $scene = [
		'edit'=>[
			'name',
			'eid',
			'id'=>'require'
		]
	];
}

?>