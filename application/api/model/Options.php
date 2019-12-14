<?php 
namespace app\api\model;
/**
* 
*/
class Options extends Common
{
	protected $resultSetType = '\think\Collection';
	// 根据题目获取选项
	public function getOptions($question_id){
		$list = $this->where(['question_id'=>$question_id])->select()->toArray();
		return $list;
	}
	// 选择题选项入库
	public function addOptions($question_id,$options)
	{
		foreach ($options as $key => $value) {
			$options[$key]['question_id'] = $question_id;
		}
		return $this->allowField(TRUE)->isUpdate(FALSE)->saveAll($options);
	}
	public function editOptions($params)
	{
		$this->where('question_id',$params['id'])->delete();
		if($params['type'] !="简答"){
			$options = [];
			foreach ($params['select_options'] as $key => $value) {
				$options[] = [
					'question_id'=>$params['id'],
					'label'=>$value['label'],
					'text'=>$value['text'],
					'image'=>$value['image']
				];
			}
			$this->insertAll($options);
		}
	}
}

?>