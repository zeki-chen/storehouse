<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2017/2/6
 * Time: 10:28
 */

namespace Admin\Controller;

use Think\Controller;

class ManufacturerController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->addBread('经销商管理');
        $this->addBread('经销商列表', U('Manufacturer/index'));
    }

    /**
     *经销商列表页
     */
    public function index()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '经销商列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看经销商列表', 'view');

        $where = array();
        $pageParam = array();

        $keyword = urldecode(request('keyword'));
        if (!empty($keyword)) {
            $where['go_id'] = $keyword;
            $where['go_name'] = array('like', "%$keyword%");
            //$where['specialty']=array('like',"%$keyword%");
            $where['_logic'] = 'or';
            $pageParam['keyword'] = urlencode($keyword);
            $this->assign('keyword', $keyword);
        }

        $orderby = 'ma_id desc';
        $this->getList('manufacturer', $where, $orderby, $pageParam);
        $this->display();
    }

    /**
     *学生信息添加页
     */
    public function add()
    {
        $this->checkPower('StudentAdd');
        $this->addBread('添加经销商信息');
        $this->assign('title', '添加经销商信息');
        $this->assign('bread', $this->bread);
        $model['birth'] = time();
        $this->assign('model', $model);
        $this->display();
    }

    /**
     *经销商信息修改页
     */
    public function edit()
    {
        $this->checkPower('StudentEdit');
        $this->addBread('修改经销商信息');
        $this->assign('title', '修改经销商信息');
        $this->assign('bread', $this->bread);

        $student_id = I('get.student_id', 0);
        if ($student_id <= 0) {
            $this->error('参数错误');
        }
        $where['ma_id'] = $student_id;
        $model = M('manufacturer')->where($where)->find();
        if (!$model) {
            $this->error('没有找到记录');
        }
        $this->assign('model', $model);
        $this->display();
    }


    /**
     *添加经销商信息操作
     */
    public function doAdd()
    {
        $this->checkPower('StudentAdd');
        $data = requestPost();
        $this->saveLog('添加经销商：' . $data['ma_id'] . $data['ma_name'], 'insert');
        $this->save('manufacturer', $data, 1, 'insert', cookie('backurl'));
    }

    /**
     *修改经销商信息操作
     */
    public function doEdit()
    {
        $this->checkPower('StudentEdit');
        $data = requestPost();
        $this->saveLog('修改经销商信息：' . $data['ma_id'] . $data['ma_name'], 'update');
        $this->save('manufacturer', $data, 1, 'update', cookie('backurl'));
    }


    /**
     *删除经销商信息操作
     */
    public function doDel()
    {
        $this->checkPower("StudentDel");
        $ids = request('ids');
        if (empty($ids)) {
            $this->error("请先选择要删除的记录！");
        }
        $this->saveLog("删除商品：" . $ids, "del");
        $where['ma_id'] = array('in', $ids);
        $this->delete("manufacturer", $where);
    }
}