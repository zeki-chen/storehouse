<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2017/2/6
 * Time: 10:28
 */

namespace Admin\Controller;

use Think\Controller;

class WarehouseController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->addBread('仓库管理');
        $this->addBread('仓库列表', U('Warehouse/index'));
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

        $orderby = 'wa_id desc';
        $this->getList('warehouse', $where, $orderby, $pageParam);
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
        $model['birth'] = time();
        $this->assign('model', $model);
        $this->display();
    }

    /**
     *学生信息修改页
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
        $where['wa_id'] = $student_id;
        $model = M('warehouse')->where($where)->find();
        if (!$model) {
            $this->error('没有找到记录');
        }
        //$model['pic']=unserialize($model['pic']);
        $this->assign('model', $model);
        $this->display();
    }

    /**
     *学生信息、成绩查看页
     */
    public function view()
    {
        $this->checkPower('StudentView');
        $this->addBread('查看商品信息');
        $this->assign('title', '查看商品信息');
        $this->assign('bread', $this->bread);

        $student_id = I('get.student_id', 0);
        if ($student_id <= 0) {
            $this->error('参数错误');
        }
        $where['student_id'] = $student_id;
        $model = M('student')->where($where)->find();
        if (!$model) {
            $this->error('没有找到记录');
        }
        $model['pic'] = unserialize($model['pic']);
        $model['pic'] = current($model['pic']);
        //获取学生成绩
        unset($where);
        $orderby = 'semester desc,addtime desc,score desc';
        $where['student_number'] = $model['student_number'];
        $scoreList = M('score')->field('semester,subject,score')->where($where)->order($orderby)->select();
        //处理学生成绩
        $score = array();
        $key = '';
        foreach ($scoreList as $k => $v) {
            if ($key != $v['semester']) {
                $key = $v['semester'];
            }
            $score[$key][] = $v;
        }
        $this->assign('model', $model);
        $this->assign('score', $score);
        $this->saveLog('查看商品信息：' . $model['wa_id'] . $model['wa_name'], 'view');
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
     *添加学生信息操作
     */
    public function doAdd()
    {
        $this->checkPower('StudentAdd');
        $data = requestPost();
        $this->saveLog('添加：' . $data['wa_id'] . $data['wa_name'], 'insert');
        $this->save('warehouse', $data, 1, 'insert', cookie('backurl'));
    }

    /**
     *修改仓库信息操作
     */
    public function doEdit()
    {
        $this->checkPower('StudentEdit');
        $data = requestPost();
        //var_dump($data);
        $this->saveLog('修改仓库信息：' . $data['wa_id'] . $data['wa_name'], 'update');
        $this->save('warehouse', $data, 1, 'update', cookie('backurl'));
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
        $where['wa_id'] = array('in', $ids);
        $this->delete("warehouse", $where);
    }
}