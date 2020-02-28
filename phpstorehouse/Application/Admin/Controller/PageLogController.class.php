<?php

namespace Admin\Controller;

use Think\Controller;

class PageLogController extends AdminBaseController {
	public function __construct(){
		parent::__construct();
		$this->addBread("安全管理");
		$this->addBread("后台日志",U('PageLog/index'));
	}
	
	public function index(){	
		$this->checkPower("PageLogView");	
		$this->assign("bread",$this->bread);
		$this->assign("title","查看后台日志");
		cookie("backurl",get_url());	

		$where=array();
		$pageParam=array(); // 分页参数
				
		$level=urldecode(request("level"));
		if(!empty($level)){
			$where['level']=$level;
			$pageParam['level']=urlencode($level);
			$this->assign("level",$level);
		}
		
		$keyword=urldecode(request("keyword"));
		if($keyword!=""||$keyword!=null){
			$where['aname']=array('LIKE',"%$keyword%");
			$pageParam['keyword']=urlencode($keyword);
			$this->assign("keyword",$keyword);
		}
		$orderby="addtime desc";
		$this->getList("page_log",$where,$orderby,$pageParam);
		$this->saveLog("查看后台日志","view");
		$this->assign("admin_log_type",$this->dicM->getByIndexCode("admin_log_type"));
		$this->display();
	}
	
	/**
	 * 删除
	 */
	public function doDel(){
		$this->checkPower("PageLogDel");		
		$ids=request('ids');
		if(empty($ids)){
			$this->error("请先选择要删除的记录！");
		}
		$where['log_id']=array('in',$ids);
		$this->saveLog("删除日志：".$ids,"del");
		$this->delete("page_log",$where);
	}
	
}