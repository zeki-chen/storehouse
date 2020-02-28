<?php

namespace Admin\Controller;

use Think\Controller;

class AdminBaseController extends Controller {
    public $bread = array (); // 全局面包屑变量
    public $dicM; // 字典模型
    public function __construct() {
        parent::__construct ();
//        $this->license();
        $this->addBread ( "首页", U ( 'Main/main' ) );
        $sysInfo = M ( 'config' )->where ( "code='web'" )->find ();
        $sysInfo = unserialize ( $sysInfo ['content'] ); // 解码系统信息
        $this->assign ( 'sysInfo', $sysInfo );
        $this->dicM = new \Common\Model\DictionaryModel ();
        // 未登陆判断
        if (session ( '?admin' )) {
            //echo "logined";
            $admin = session ( "admin" );
            $this->assign ( "admin", $admin );
        } else {
            // 未登陆
            $adminD = D ( "AdminView" );
            $where["aname"]=cookie("name");
            $where["pwd"]=cookie("pwd");
            $where['valid'] = 1;
            $admin = $adminD->where ( $where )->find ();
            // dump($admin);exit;
            session ( "admin" ,$admin);
            $this->assign ( "admin", $admin );
            if (! $admin) {
                header ( "Content-type: text/html; charset=utf-8" );
                echo "<script language='javascript'>top.location.href='" . U ( "Index/index" ) . "';</script>";
                exit ();
            }
        }
        getCodes($admin['ar_id']);//获取用户权限集合
    }

    //添加面包屑
    public function addBread($name = '', $url = '') {
        $this->bread [count ( $this->bread )] = array (
            "name" => $name,
            "url" => $url
        );
    }

    //权限检测
    public function checkPower($value = "") {
        $admin = session ( "admin" );
        $where['ar_id']=$admin['ar_id'];
        $ap_codes=M('admin_role')->field('ap_codes')->where($where)->find();
        if(!stristr($ap_codes['ap_codes'],$value)){
            $this->error('对不起，您没有权限进行此操作');
        }
    }


    //获取列表并分页
    public function getList($table, $where, $orderby, $pageParam) {
        $M = D ( $table );
        $mapcount = $M->where ( $where )->count ();// 查询满足要求的总记录数
        $pageSize = C ( 'PAGE_SIZE' );//从配置里读取分页大小
        $Page = new \Think\Page ( $mapcount, $pageSize ); // 实例化分页类 传入总记录数和每页显示的记录数
        $Page->parameter = $pageParam;// 分页跳转的时候保证查询条件
        $show = $Page->show (); // 分页显示输出
        $list = $M->where ( $where )->order ( $orderby )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
        $list = $this->dealList ( $table, $list );
        // print_r($list);
        $this->assign ( 'list', $list ); // 赋值数据集
        $this->assign ( 'pages', $show ); // 赋值分页输出
    }

    // 插入日志
    public function saveLog($msg, $level) {
        $where ['code'] = "logLevel";
        $logSetting = M ( 'config' )->where ( $where )->find ();
        $logSetting ['content_str'] = $logSetting ['content'];
        //查找到日志设置并反序列化
        $logSetting ['content'] = unserialize ( $logSetting ['content_str'] );
//		 print_r($logSetting['content']['log_level']);
        //判断日志是否需要记录
        if (! in_array ( $level, $logSetting ['content'] ['log_level'] )) {
            return;
        }
        $data['aname'] = session('admin.aname');
        $data ['url'] = get_url ();
        $data ['content'] = $msg;
        $data ['level'] = $level;
        $data ['reference'] = $_SERVER ['HTTP_REFERER'];
        $data ['controller'] = CONTROLLER_NAME; // MODULE_NAME;
        $data ['action'] = ACTION_NAME;
        $data ['addtime'] = time ();
        M ( 'page_log' )->data ( $data )->add ();
    }

    /**
     * 保存数据
     *
     * @param string $act
     * @param unknown $table
     * @param unknown $data
     * @param number $showMsg
     * @param string $url
     * @return string
     */
    public function save($table, $data, $showMsg = 0, $act = 'insert', $url = '') {
        $res = 0;
        $info = "";
        $data ['updatetime'] = time ();
        if ($act == "insert") {
            $res = M ( $table )->data ( $data )->add ();
            $info = "添加成功！";
        }
        if ($act == "update") {
            $res = M ( $table )->data ( $data )->save ();
            $info = "编辑成功！";
        }
        if ($showMsg == 1) {
            if ($res > 0) {
                $this->success ( $info, $url );
            } else {
                $this->saveLog ( "数据写入失败" );
                $this->error ( "操作失败，请稍后再试！" );
            }
        }
        return res;
    }

    /**
     * 删除记录
     */
    public function delete($table, $where) {
        $dbname = M ( $table );
        $res = $dbname->where ( $where )->delete ();
        if ($res > 0) {
            $this->success ( "删除成功", cookie ( "backurl" ) );
        } else {
            $this->error ( "删除失败", cookie ( "backurl" ) );
        }
    }

    /**
     * 获取配置的content字段
     */
    public function getContent() {
        $Confmodel = D ( "Config" );
        $confDetail = $Confmodel->scope ( "latest" )->getField ( "content" );
        $confDetail = unserialize ( $confDetail );
        return $confDetail;
    }

    private function dealList($table, $list) {
        switch ($table) {
            case "wx_material" :
                $list = dealWxMaterialList ( $list );
                break;
            default :
                break;
        }
        return $list;
        
    }

    /**
     *快速编辑
     */
    public function quickEdit(){
        $table=I('get.table');
        $id_name=I('get.id_name');
        $id_value=I('get.id_value');
        $key=I('get.key');
        $content=I('get.content');
        $data[$id_name]=$id_value;
        $data[$key]=$content;
        $data['updatetime']=time();
        $res=M($table)->data($data)->save();
//		dump($data);exit;
        if(!$res){
            $this->ajaxReturn(array('status'=>0,'info'=>'修改失败'));
        }else{
            $this->ajaxReturn(array('status'=>1,'info'=>'修改成功'));
        }
    }

    /**
     *检测系统授权
     */
    private function license(){
        $flag=false;
        $doamin=$_SERVER['SERVER_NAME'];//获取当前域名
        //($_SERVER['HTTP_HOST']);//获取当前域名
        if(!file_exists('license')){
            echo '系统没有授权，请联系开发者获取授权';
            exit;
        }
        if(!$file=@fopen('license','r')){
            echo "授权文件已损坏，请联系开发者获取新的授权文件";
            exit;
        }
        $enstr=str_replace("\n",'',fgets($file));
        $key=md5(base64_encode(fgets($file)).'yckj2015');
        $endoamin=explode('-',$enstr);
        $doamin=md5(base64_encode($doamin).$key);
        foreach($endoamin as $k=>$v){
            if($v===$doamin){
                $flag=true;
                break;
            }
        }
        if(!$flag){
            echo '系统没有授权，请联系开发者获取授权';
            exit;
        }
    }
}