<?php

namespace Admin\Controller;

use Think\Controller;

class AdminController extends AdminBaseController {
	public function __construct(){
		parent::__construct();
		$this->addBread("系统管理员");
		$this->addBread("管理员管理",U('Admin/index'));
		$this->getRoleOptions();
		$this->assign("yesno",$this->dicM->getByIndexCode("yesno"));
	}

	public function index(){
		$this->checkPower("AdminView");
		$this->addBread("管理员列表");
		$this->assign("bread",$this->bread);
		$this->assign("title","管理员列表");
		cookie("backurl",get_url());
		
		$where=array();
		$pageParam=array();

		$admin=session('admin');
		$ar_id=$admin['ar_id'];
		//不是开发者，不显示开发者账号
		if($ar_id!='13'){
			$where['ar_id']=array('neq',13);
		}

		$keyword=urldecode(request('keyword'));
		if($keyword!=""||$keyword!=null){
			$where[]="aname like '%$keyword%' or realname like '%$keyword%'";
			$this->assign('keyword',$keyword);
			$pageParam['keyword']=urlencode($keyword);
		}
		$orderby="addtime desc";
		$this->getList("AdminView",$where,$orderby,$pageParam);
		$this->saveLog("查看管理员列表","view");
		$this->display();
	}

	public function add(){
		$this->checkPower("AdminAdd");
		$this->addBread('添加管理员');
		$this->assign("bread",$this->bread);
		$this->assign("title",'添加管理员');
		$this->display();
	}

	public function edit(){
		$this->checkPower("AdminEdit");
		$this->addBread('修改管理员信息');
		$this->assign("bread",$this->bread);
		$this->assign("title",'修改管理员信息');
		$aid=I('get.aid',0);
		if ($aid<=0){
			$this->error("参数错误");
		}
		$where['aid']=$aid;
		$model = M('admin')->where($where)->find();
		if(!$model){
			$this->error("没有找到记录");
		}
		$this->assign("model",$model);
		$this->display();
	}
	
	public function psw(){
		$this->checkPower("AdminPsw");
		$this->addBread('重置密码');
		$this->assign("bread",$this->bread);
		$this->assign('title','重置密码');
		$aid=I('get.aid',0);
		if($aid<=0){
			$this->error("参数错误");
		}
		$where['aid']=$aid;
		$model = M('admin')->where($where)->find();
		if(!$model){
			$this->error("没有找到记录");
		}
		$this->assign("model",$model);
		$this->display();
	}

	/**
	 *检查用户名是否重复
	 */
	public function checkName(){
		$this->checkPower("AdminAdd");
		$aname=I('post.aname');
		$where['aname']=$aname;
		$res=M('admin')->where($where)->find();
		if(!$res){
			 $this->ajaxReturn(array("info"=>"success","status"=>1));
		}else{
			 $this->ajaxReturn(array("info"=>"error","status"=>0));
		}
	}

	




	/**
	 * 添加管理员
	 */
	public function doAdd(){
		$this->checkPower("AdminAdd");
		$data=requestPost();
		$data["pwd"]=md5($data["pwd"]);
		$this->saveLog("添加管理员：".$data['aname'],"insert");
		$this->save("admin",$data,1,"insert",cookie("backurl"));
	}

	/**
	 *编辑
	 */
	public function doEdit(){
		$this->checkPower("AdminEdit");
		$data=requestPost();
		$this->saveLog("修改管理员信息：".$data['aname'],"update");
		$this->save("admin",$data,1,"update",cookie("backurl"));
	}

	/**
	 *重置密码
	 */
	public function doPsw(){
		$this->checkPower("AdminPsw");
		$data=requestPost();
		$data["pwd"] =md5($data["pwd"]);
		$this->saveLog("修改管理员密码：".$data['aname'],"update");
		$this->save("admin",$data,1,"update",cookie("backurl"));
	}

	/**
	 *ajax删除
     */
	public function doDel(){
		$this->checkPower("AdminDel");
		$ids=request('ids');
		if(empty($ids)){
			$this->error("请先选择要删除的记录！");
		}
		$this->saveLog("删除管理员：".$ids,"del");
		$where['aid']=array('in',$ids);
		$this->delete("admin",$where);
	}

	/**
	 *获取有效的角色列表，按 排序升序、添加时间降序 进行排序
     */
	private function getRoleOptions(){
		$where['valid']=1;
		$orderby="sort asc,addtime desc";
		$roleList=M("admin_role")->where($where)->order($orderby)->select ();
		$options=array();
		foreach($roleList as $k=>$v){
			$options[$k]=array("key"=>$v['ar_name'],"value"=>$v['ar_id']);
		}
		$this->assign("roleList",$options);
	}
}