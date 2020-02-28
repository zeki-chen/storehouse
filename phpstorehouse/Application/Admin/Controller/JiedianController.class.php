<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2017/2/6
 * Time: 10:28
 */

namespace Admin\Controller;

use Think\Controller;

class JiedianController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->addBread('节点1管理');
        $this->addBread('节点1列表', U('Jiedian/index'));
    }

    /**
     *节点1列表页
     */
    public function index1()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '节点1列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看节点1列表', 'view');

        $where = array();
        $pageParam = array();

        $keyword = urldecode(request('keyword'));
        if (!empty($keyword)) {
            $where['jd_id'] = $keyword;
            $where['time'] = array('like', "%$keyword%");
            //$where['specialty']=array('like',"%$keyword%");
            $where['_logic'] = 'or';
            $pageParam['keyword'] = urlencode($keyword);
            $this->assign('keyword', $keyword);
        }

        $orderby = 'jd_id desc';
        $this->getList('jiedian1', $where, $orderby, $pageParam);
        $this->display();
    }

    /**
     *节点2列表页
     */
    public function index2()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '节点2列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看节点2列表', 'view');

        $where = array();
        $pageParam = array();

        $keyword = urldecode(request('keyword'));
        if (!empty($keyword)) {
            $where['jd_id'] = $keyword;
            $where['time'] = array('like', "%$keyword%");
            //$where['specialty']=array('like',"%$keyword%");
            $where['_logic'] = 'or';
            $pageParam['keyword'] = urlencode($keyword);
            $this->assign('keyword', $keyword);
        }

        $orderby = 'jd_id desc';
        $this->getList('jiedian2', $where, $orderby, $pageParam);
        $this->display();
    }

    /**
     *节点3列表页
     */
    public function index3()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '节点3列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看节点3列表', 'view');

        $where = array();
        $pageParam = array();

        $keyword = urldecode(request('keyword'));
        if (!empty($keyword)) {
            $where['jd_id'] = $keyword;
            $where['time'] = array('like', "%$keyword%");
            //$where['specialty']=array('like',"%$keyword%");
            $where['_logic'] = 'or';
            $pageParam['keyword'] = urlencode($keyword);
            $this->assign('keyword', $keyword);
        }

        $orderby = 'jd_id desc';
        $this->getList('jiedian3', $where, $orderby, $pageParam);
        $this->display();
    }


    /**
     *导入学生数据页面
     */
    public function import()
    {
        $this->checkPower('StudentAdd');
        $this->assign('title', '导入商品数据');
        $this->addBread('导入商品数据');
        $this->assign('bread', $this->bread);
        $this->display();
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
        $where['jd_id'] = array('in', $ids);
        $this->delete("jiedian", $where);
    }
}