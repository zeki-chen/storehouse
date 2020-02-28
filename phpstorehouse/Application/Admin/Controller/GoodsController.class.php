<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2017/2/6
 * Time: 10:28
 */

namespace Admin\Controller;

use Think\Controller;

class GoodsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->addBread('商品管理');
        $this->addBread('商品列表', U('Goods/index'));
    }

    /**
     *学生列表页
     */
    public function index()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '商品列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看商品列表', 'view');

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

        $orderby = 'go_id desc';
        $this->getList('GoodsView', $where, $orderby, $pageParam);
        $list['go_picture'] = unserialize($list['go_picture']);
        $this->display();
    }

    public function index2()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '库存列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看商品列表', 'view');

        $where = array();
        $pageParam = array();

        $keyword = urldecode(request('keyword'));
        if (!empty($keyword)) {
            $where['go_id'] = $keyword;
            $where['go_name'] = array('like', "%$keyword%");
            $where['wa_name'] = array('like', "%$keyword%");
            $where['_logic'] = 'or';
            $pageParam['keyword'] = urlencode($keyword);
            $this->assign('keyword', $keyword);
        }

        $orderby = 'go_id desc';
        $this->getList('StockView', $where, $orderby, $pageParam);
        $this->display();
    }

    /**
     *学生信息添加页
     */
    public function add()
    {
        $this->checkPower('StudentAdd');
        $this->addBread('添加商品信息');
        $this->assign('title', '添加商品信息');
        $this->assign('bread', $this->bread);
        $this->assign('model', $model);
        $manufacturer = M('manufacturer')->select();
        $this->assign('manufacturer', $manufacturer);
        $this->display();
    }

    /**
     *商品信息修改页
     */
    public function edit()
    {
        $this->checkPower('StudentEdit');
        $this->addBread('修改商品信息');
        $this->assign('title', '修改商品信息');
        $this->assign('bread', $this->bread);

        $student_id = I('get.student_id', 0);
        if ($student_id <= 0) {
            $this->error('参数错误');
        }
        $where['go_id'] = $student_id;
        $model = M('goods')->where($where)->find();
        if (!$model) {
            $this->error('没有找到记录');
        }
        $model['go_picture'] = unserialize($model['go_picture']);
        $this->assign('model', $model);
        $manufacturer = M('manufacturer')->select();
        $this->assign('manufacturer', $manufacturer);
        $this->display();
    }


    /**
     *添加商品信息操作
     */
    public function doAdd()
    {
        $this->checkPower('StudentAdd');
        $data = requestPost();
        $pic = I('post.go_picture');
        if (!empty($pic)) {
            sort($pic);
            $data['go_picture'] = serialize($pic);
        }
        $this->saveLog('添加商品：' . $data['go_id'] . $data['go_name'], 'insert');
        $this->save('goods', $data, 1, 'insert', cookie('backurl'));
    }

    /**
     *修改商品信息操作
     */
    public function doEdit()
    {
        $this->checkPower('StudentEdit');
        $data = requestPost();
        $pic = I('post.go_picture');
        //var_dump($pic);
        if (!empty($pic)) {
            sort($pic);
            $data['go_picture'] = serialize($pic);
        }
        $this->saveLog('修改商品信息：' . $data['go_id'] . $data['go_name'], 'update');
        $this->save('goods', $data, 1, 'update', cookie('backurl'));
    }


    /**
     *删除商品信息操作
     */
    public function doDel()
    {
        $this->checkPower("StudentDel");
        $ids = request('ids');
        if (empty($ids)) {
            $this->error("请先选择要删除的记录！");
        }
        $this->saveLog("删除商品：" . $ids, "del");
        $where['go_id'] = array('in', $ids);
        $this->delete("Goods", $where);
    }
}