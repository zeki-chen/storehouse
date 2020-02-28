<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $sysInfo = M('config')->where("code='web'")->find();
        $sysInfo = unserialize($sysInfo['content']);//解码系统信息
        $this->assign('sysInfo', $sysInfo);
    }

    public function index()
    {
        //判断是否已经登录
        if (session('?admin')) {
            //echo "logined";
            $adminD = D("AdminView");
            $where["aname"] = cookie("name");
            $where["pwd"] = cookie("pwd");
            $admin = $adminD->where($where)->find();
            if ($admin) {
                $this->redirect("Main/index");
            }
        }
        $this->display();
    }

    /**
     * 验证码生成
     */
    public function verify()
    {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 16;
        $Verify->length = 4;
        $Verify->useNoise = false;
        $Verify->useCurve = false;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        $Verify->imageW = 114;
        $Verify->imageH = 46;
        $Verify->entry();
    }

    /**
     * 验证码检查
     */
    public function check_verify($code, $id = "")
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /**
     * 提交登录信息
     */
    public function doLogin()
    {
        $verify = I('post.verify');
        if (!$this->check_verify($verify)) {
            $this->error("亲，验证码输错了哦！");
        }
        $name = I('post.name');
        $pwd = md5(I('post.pwd'));
        $dbname = M("admin");

        $where['aname'] = $name;
        $where['pwd'] = $pwd;
        $where['valid'] = 1;
        $list = $dbname->where($where)->find();

        if ($list) {
            $timelong = 3600 * 24 * 30;//保存时间长度
            cookie("name", $name, $timelong);
            cookie("pwd", $pwd, $timelong);
            $this->success("登录成功", U("Main/index"));
        } else {
            $this->error("登录失败：用户名或密码不正确！");
        }
    }

    /**
     * 退出后台
     */
    public function quit()
    {
        session(null);
        cookie("aname", null);
        cookie("pwd", null);
        $this->redirect("Index/index", 3);
    }
}