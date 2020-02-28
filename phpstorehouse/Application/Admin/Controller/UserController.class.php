<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2017/2/6
 * Time: 10:28
 */

namespace Admin\Controller;

use Think\Controller;

class UserController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->addBread('操作员管理');
        $this->addBread('操作员列表', U('User/index'));
        //$this->assign('sex',$this->dicM->getByIndexCode('sex'));
    }

    /**
     *操作员列表页
     */
    public function index()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '操作员列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看操作员列表', 'view');

        $where = array();
        $pageParam = array();

        $keyword = urldecode(request('keyword'));
        if (!empty($keyword)) {
            $where['us_id'] = $keyword;
            $where['us_name'] = array('like', "%$keyword%");
            $where['us_phone'] = array('like', "%$keyword%");
            $where['_logic'] = 'or';
            $pageParam['keyword'] = urlencode($keyword);
            $this->assign('keyword', $keyword);
        }

        $orderby = 'us_id desc';
        $this->getList('user', $where, $orderby, $pageParam);
        $this->display();
    }

    /**
     *操作员信息添加页
     */
    public function add()
    {
        $this->checkPower('StudentAdd');
        $this->addBread('添加操作员信息');
        $this->assign('title', '添加操作员信息');
        $this->assign('bread', $this->bread);
        $this->assign('model', $model);
        $this->display();
    }

    /**
     *操作员信息修改页
     */
    public function edit()
    {
        $this->checkPower('StudentEdit');
        $this->addBread('修改操作员信息');
        $this->assign('title', '修改操作员信息');
        $this->assign('bread', $this->bread);

        $student_id = I('get.student_id', 0);
        if ($student_id <= 0) {
            $this->error('参数错误');
        }
        $where['us_id'] = $student_id;
        $model = M('user')->where($where)->find();
        if (!$model) {
            $this->error('没有找到记录');
        }
        $this->assign('model', $model);
        $this->display();
    }


    /**
     *重置密码页面
     */
    public function pwd()
    {
        $this->checkPower("StudentPwd");
        $this->addBread('重置密码');
        $this->assign("bread", $this->bread);
        $this->assign('title', '重置密码');
        $student_id = I('get.student_id', 0);
        if ($student_id <= 0) {
            $this->error("参数错误");
        }
        $where['us_id'] = $student_id;
        $model = M('User')->where($where)->find();
        if (!$model) {
            $this->error("没有找到记录");
        }
        $this->assign("model", $model);
        $this->display();
    }


    /**
     *添加操作员信息操作
     */
    public function doAdd()
    {
        $this->checkPower('StudentAdd');
        $data = requestPost();
        $this->saveLog('添加操作员：' . $data['us_id'] . $data['us_name'], 'insert');
        $this->save('user', $data, 1, 'insert', cookie('backurl'));
    }

    /**
     *修改学生信息操作
     */
    public function doEdit()
    {
        $this->checkPower('StudentEdit');
        $data = requestPost();
        $this->saveLog('修改操作员信息：' . $data['us_id'] . $data['us_name'], 'update');
        $this->save('user', $data, 1, 'update', cookie('backurl'));
    }

    /**
     *重置密码
     */
    public function doPwd()
    {
        $this->checkPower("StudentPwd");
        $data = requestPost();
        $data["us_password"] = $data["us_password"];
        $this->saveLog("修改操作员密码：" . $data['us_id'] . $data['us_name'], "update");
        $res = M('user')->data($data)->save();
        if ($res) {
            $this->success('修改成功', cookie('backurl'));
        } else {
            $this->error('修改失败，请稍后重试');
        }
    }

    /**
     *删除操作员信息操作
     */
    public function doDel()
    {
        $this->checkPower("StudentDel");
        $ids = request('ids');
        if (empty($ids)) {
            $this->error("请先选择要删除的记录！");
        }
        $this->saveLog("删除学生：" . $ids, "del");
        $where['us_id'] = array('in', $ids);
        $this->delete("user", $where);
    }
}