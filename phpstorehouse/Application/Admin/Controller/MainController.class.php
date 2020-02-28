<?php

namespace Admin\Controller;

use Think\Controller;

class MainController extends AdminBaseController{
	public function  __construct(){
		parent::__construct();
		
	}
   
	//后台管理框架页
    public function index(){      
        $this->display();
    }

    /**
     * 后台管理左导航页
     */
    public function left(){
        // $where['valid']=1;
        // $orderby="sort asc,addtime desc";
        // $modelList=M('model')->where($where)->order($orderby)->select();
        // $this->assign('modelList',$modelList);
        $this->display();

    }

    public function top(){
        $this->display();
    }

    public function main(){
        $jiedian1=D('jiedian1')->select();
        $this->assign('jiedian',json_encode($jiedian1));
    	$this->addBread ( "工作台" );
    	$this->assign ( "bread", $this->bread );
        $this->display();
    }

    public function footer(){
        $this->display();
    }
    
    public function testForm(){
    	$this->display();
    }

    public function nopower(){
        $this->display();
    }
    
    public function err(){
    	$this->display("Public/error");
    }
    
}