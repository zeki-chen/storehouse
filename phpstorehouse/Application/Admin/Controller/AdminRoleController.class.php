<?php

namespace Admin\Controller;

use Think\Controller;

class AdminRoleController extends AdminBaseController {
	public function __construct() {
		parent::__construct ();
		$this->addBread("系统管理员");
		$this->addBread("角色管理",U('AdminRole/index'));
		$this->assign ( "yesno", $this->dicM->getByIndexCode ( "yesno" ) );

	}

	public function index() {
		$this->checkPower("AdminRoleView");
		$this->addBread("角色列表");
		$this->assign("bread",$this->bread);
		$this->assign("title","角色列表");
		cookie("backurl",get_url());

		$where = array();
		$pageParam = array();

		$admin=session('admin');
		$ar_id=$admin['ar_id'];
		//不是开发者，不显示开发者角色
		if($ar_id!='13'){
			$where['ar_id']=array('neq',13);
		}

		$keyword=urldecode(request('keyword'));
		if($keyword!=""||$keyword!=null){
			$where['ar_name']=array('like',"%$keyword%");
			$pageParam['keyword']=urlencode($keyword);
			$this->assign('keyword',$keyword);
		}

		$orderby="addtime desc";
		$this->getList("admin_role",$where,$orderby,$pageParam);
        $this->saveLog("查看角色列表","view");
		$this->display();
	}

	public function add(){
		$this->checkPower("AdminRoleAdd");
		$this->addBread('添加角色');
		$this->assign("bread",$this->bread);
		$this->assign("title","添加角色");
		$this->getPowerList();
		$this->display();
	}

	public function edit(){
		$this->checkPower("AdminRoleEdit");
		$this->addBread('修改角色');
		$this->assign("bread",$this->bread);
		$this->assign("title","修改角色");
		$rid=requestGet("rid",0);
		if ($rid<=0){
			$this->error("参数错误");
		}
        $where['ar_id']=$rid;
		$model = M('admin_role')->where($where)->find();
		if(!$model){
			$this->error("没有找到记录");
		}
		$this->assign("model",$model);
        $this->getPowerList();
		$this->display();
	}

    /**
     * 添加角色
     */
	public function doAdd() {
		$this->checkPower("AdminRoleAdd");
		$data=$_POST;
        //将数组转换为字符串，如AdminRoleAdd,AdminRoleEdit...
		$codes=conbineArr2Str($data['ap_codes']);
		$data["ap_codes"]=$codes;
		$data['addtime']=time();
		$data['updatetime']=time();
		$row=M('admin_role')->data($data)->add();
		if ($row){
			$this->saveLog("添加角色：".$data['ar_name'],"insert");
			$this->success("添加成功!",cookie("backurl"));
		}else{
			$this->error("添加失败");
		}
	}

    /**
     * 修改角色
     */
	public function doEdit(){
		$this->checkPower("AdminRoleEdit");
		$data=$_POST;
		$codes=conbineArr2Str($data['ap_codes']);
		$data["ap_codes"]=$codes;
		$data['updatetime']=time();
		$row=M('admin_role')->data($data)->save();
		if ($row){
			$this->saveLog("修改角色：".$data['ar_name'],"update");
			$this->success("修改成功",cookie("backurl"));
		}else{
			$this->error("修改失败");
		}
	}

    /**
     * 删除角色
     */
	public function doDel(){
		$this->checkPower("AdminRoleDel");
		$ids=request('ids');
		if(empty($ids)){
			$this->error("请先选择要删除的记录！");
		}
		$this->saveLog("删除角色：".$ids,"del");
		$where['ar_id']=array('in',$ids);
		$this->delete("admin_role",$where);
	}

	/**
	 * 获取权限列表
	 */
	function getPowerList() {
        //获取所有有效的权限
		$orglist=M("admin_power")->where("valid=1")->order("ap_model asc,ap_group asc,addtime asc" )->select();
		$list=array();
		$key="";
		$index=0;
		$fkey="";
		$findex=0;
		$sindex=0;
		foreach($orglist as $k=>$v){
			if ($fkey!=$v["ap_model"]){
				$findex++;
				$fkey=$v["ap_model"];
				$list[$findex]["name"]=$fkey;
				$sindex=-1;
			}

			if($key!=$v["ap_group"]){
				$sindex++;
				$key=$v["ap_group"];
				$index=0;
				$list[$findex]['list'][$sindex]["name"]=$key;

			}
			$list[$findex]['list'][$sindex]["list"][$index]=$v;
			$index++;
		}
        $this->assign("codes",$list);
	}
}