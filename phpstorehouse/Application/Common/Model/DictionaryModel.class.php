<?php
/**
 * User: Administrator
 */
namespace Common\Model;
use Think\Model;
class DictionaryModel extends Model {

	protected $tableName = 'dictionary';
	public  $model='';


	public function __construct(){
		$this->model=M('dictionary');
		
	}
	
	public function getByIndexCode($indexCode){
		$list=$this->model->where("index_code='".$indexCode."'")->order("sort asc")->select();
		$arr=array();
		foreach($list as $k=>$v){
			$arr[$k]=array('key'=>$v['key'],'value'=>$v['value']);
		}
		return $arr;
	}

	
}