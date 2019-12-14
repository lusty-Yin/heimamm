<?php 
namespace app\api\validate;
use think\Validate;
/**
* 
*/
class Subject extends Validate
{
	
	protected $rule = [
		'name'=>'require',
		'rid'=>'require|unique:subject',
	];
	protected $scene = [
		'edit'=>['name','rid','id'=>'require']
	];
}

?>