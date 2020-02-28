<?php
namespace Admin\Controller;

use Think\Controller;

class AdminPowerController extends AdminBaseController{
	public function  __construct(){
		parent::__construct();
		$this->addBread("系统管理员");
		$this->addBread("权限管理",U('AdminPower/index'));
		$this->assign ( "yesno", $this->dicM->getByIndexCode ( "yesno" ) );
	}

	public function index(){
		$this->checkPower("AdminPowerView");
		$this->addBread("权限列表");
		$this->assign("bread",$this->bread);
		$this->assign("title","权限列表");
		cookie("backurl",get_url());

		$where = array ();
		$pageParam = array ();//分页参数

		$keyword=urldecode(request("keyword"));
		if($keyword!=""||$keyword!=null){
			$where['ap_name']=array('LIKE',"%".$keyword."%");
			$where['ap_code']=array('LIKE',"%".$keyword."%");
			$where['ap_group']=array('LIKE',"%".$keyword."%");
			$where['_logic'] = 'OR';
			$pageParam['keyword']=urlencode($keyword);
			$this->assign("keyword",$keyword);
		}

		$orderby = "ap_group desc,addtime asc";
		$this->getList("admin_power", $where, $orderby, $pageParam);
		$this->saveLog("查看权限列表","view");
		$this->display();
	}

	public function add(){
		$this->checkPower("AdminPowerAdd");
		$this->addBread('添加权限');
		$this->assign("bread",$this->bread);
		$this->assign("title",'添加权限');
		$this->display();
	}

	public function edit(){
		$this->checkPower("AdminPowerEdit");
		$this->addBread('修改权限');
		$this->assign("title",'修改权限');
		$this->assign("bread",$this->bread);
		$ap_id=I('get.ap_id');
		if(empty($ap_id)){
			$this->error("参数错误");
		}
		$where['ap_id']=$ap_id;
		$model=M('admin_power')->where($where)->find();
		if(!$model){
			$this->error("没有找到记录");
		}
		$this->assign("model",$model);
		$this->display();
	}


	/**
	 *添加权限
     */
	public function doAdd(){
		$this->checkPower("AdminPowerAdd");
		$data=requestPost();
		$this->saveLog("添加权限代码：".$data['ap_code'],"insert");
		$this->save("admin_power", $data,1,"insert",cookie("backurl"));
	}

	/**
	 *修改权限
	 */
	public function doEdit(){
		$this->checkPower("AdminPowerEdit");
		$data=requestPost();
		$this->saveLog("修改权限代码设置：".$data['ap_code'],"update");
		$this->save("admin_power", $data,1,"update",cookie("backurl"));
	}

	/**
	 * 删除权限代码
	 */
	public function doDel(){
		$this->checkPower("AdminPowerDel");
		$ids=request('ids');
		if(empty($ids)){
			$this->error("请先选择要删除的记录！");
		}
		$this->saveLog("删除权限代码：".$ids,"del");
		$where['ap_id']=array('in',$ids);
		$this->delete("admin_power", $where);
	}
}