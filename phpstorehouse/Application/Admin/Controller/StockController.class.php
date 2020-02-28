<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2017/2/6
 * Time: 10:28
 */

namespace Admin\Controller;

use Think\Controller;

class StockController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->addBread('出入库管理');
        $this->addBread('商品列表', U('Goods/index'));
    }

    /**
     *入库列表页
     */
    public function index_in()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '入库列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看入库列表', 'view');

        $where = array();
        $pageParam = array();

        $keyword = urldecode(request('keyword'));
        if (!empty($keyword)) {
            $where['sti_id'] = $keyword;
            $where['sti_time'] = array('like', "%$keyword%");
            $where['sti_worth'] = array('like', "%$keyword%");
            $where['_logic'] = 'or';
            $pageParam['keyword'] = urlencode($keyword);
            $this->assign('keyword', $keyword);
        }

        $orderby = 'sti_id desc';
        $this->getList('Stock_inView', $where, $orderby, $pageParam);
        $this->display();
    }

    /**
     *出库列表页
     */
    public function index_out()
    {
        $this->checkPower('StudentView');
        $this->assign('title', '出库列表');
        $this->assign('bread', $this->bread);
        cookie('backurl', get_url());
        $this->saveLog('查看出库列表', 'view');

        $where = array();
        $pageParam = array();

        $keyword = urldecode(request('keyword'));
        if (!empty($keyword)) {
            $where['sto_id'] = $keyword;
            $where['sto_time'] = array('like', "%$keyword%");
            //$where['specialty']=array('like',"%$keyword%");
            $where['_logic'] = 'or';
            $pageParam['keyword'] = urlencode($keyword);
            $this->assign('keyword', $keyword);
        }

        $orderby = 'sto_id desc';
        $this->getList('stock_out', $where, $orderby, $pageParam);
        $this->display();
    }

    /**
     *入库订单信息添加页
     */
    public function add()
    {
        $this->checkPower('StudentAdd');
        $this->addBread('添加入库订单信息');
        $this->assign('title', '添加入库订单信息');
        $this->assign('bread', $this->bread);
        $this->assign('model', $model);
        $warehouse = M('warehouse')->select();
        $this->assign('warehouse', $warehouse);
        $user = M('user')->select();
        $this->assign('user', $user);
        $this->display();
    }

    /**
     *出库订单信息添加页
     */
    public function add_out()
    {
        $this->checkPower('StudentAdd');
        $this->addBread('添加出库订单信息');
        $this->assign('title', '添加出库订单信息');
        $this->assign('bread', $this->bread);
        $this->assign('model', $model);
        $warehouse = M('warehouse')->select();
        $this->assign('warehouse', $warehouse);
        $user = M('user')->select();
        $this->assign('user', $user);
        $this->display();
    }

    /**
     *出库订单信息修改页
     */
    public function edit()
    {
        $this->checkPower('StudentEdit');
        $this->addBread('修改入库订单信息');
        $this->assign('title', '修改入库订单信息');
        $this->assign('bread', $this->bread);
        $key = I('get.key');
        $student_id = I('get.student_id', 0);
        if ($student_id <= 0) {
            $this->error('参数错误');
        }
        $where['sti_id'] = $student_id;
        $model = M($key)->where($where)->find();
        if (!$model) {
            $this->error('没有找到记录');
        }
        //$model['pic']=unserialize($model['pic']);
        $this->assign('model', $model);
        $goods = D('Stock_in_detailView')->where($where)->select();
        $this->assign('goods', $goods);
        $warehouse = M('warehouse')->select();
        $this->assign('warehouse', $warehouse);
        $user = M('user')->select();
        $this->assign('user', $user);
        $this->display();
    }


    /**
     *出库订单信息修改页
     */
    public function edit_out()
    {
        $this->checkPower('StudentEdit');
        $this->addBread('修改出库订单信息');
        $this->assign('title', '修改出库订单信息');
        $this->assign('bread', $this->bread);
        $key = I('get.key');
        $student_id = I('get.student_id', 0);
        if ($student_id <= 0) {
            $this->error('参数错误');
        }
        $where['sti_id'] = $student_id;
        $model = M($key)->where($where)->find();
        if (!$model) {
            $this->error('没有找到记录');
        }
        //$model['pic']=unserialize($model['pic']);
        $this->assign('model', $model);
        $goods = D('Stock_in_detailView')->where($where)->select();
        $this->assign('goods', $goods);
        $warehouse = M('warehouse')->select();
        $this->assign('warehouse', $warehouse);
        $user = M('user')->select();
        $this->assign('user', $user);
        $this->display();
    }


    /**
     *添加入库订单信息操作
     */
    public function doAdd()
    {
        $i = 1;
        $a = 1;
        $num = 0;
        $this->checkPower('StudentAdd');
        $data = requestPost();
        while ($a <= $data['n']) {
            $go_id['go_id'] = $data['go_id' . $a];
            $res = M('goods')->where($go_id)->find();
            if (!$res) {
                $this->error("商品id不存在，请核实！");
            }

            $num = $num + $data['sti_num' . $a];
            $a++;
        }
        $where['wa_id'] = $data['wa_id'];
        $wa = M('warehouse')->where($where)->find();
        if ($num > $wa['wa_size'] - $wa['wa_sizeout']) {
            $this->error('仓库容量不足');
        } else {
            $wa_sizeout['wa_id'] = $data['wa_id'];
            $wa_sizeoutnum['wa_sizeout'] = $wa['wa_sizeout'] + $num;
            M('warehouse')->where($wa_sizeout)->data($wa_sizeoutnum)->save();
        }

        $res = M('stock_in')->data($data)->add();
        //var_dump($data['go_id'.$i]);
        $k = $res;
        if ($res) {
            while ($i <= $data['n']) {
                $data2['sti_id'] = $k;
                $data2['go_id'] = $data['go_id' . $i];
                $data2['sti_num'] = $data['sti_num' . $i];

                $res2 = M('stock_in_detail')->data($data2)->add();

                $stock['go_id'] = $data['go_id' . $i];
                $stock['wa_id'] = $data['wa_id'];
                $res3 = M('stock')->where($stock)->find();
                if ($res3) {
                    $go_num['go_num'] = $data['sti_num' . $i] + $res3['go_num'];
                    M('stock')->where($stock)->data($go_num)->save();
                } else {
                    $stock['go_num'] = $data['sti_num' . $i];
                    M('stock')->data($stock)->add();
                }
                $i++;
            }

            $this->saveLog('添加入库订单：' . $res['sti_id'], 'insert');
            $this->success('添加成功', cookie('backurl'));
        } else {
            $this->error('添加失败，请稍后重试');
        }
    }


    /**
     *添加出库订单信息操作
     */
    public function doAdd_out()
    {
        $i = 1;
        $a = 1;
        $num = 0;
        $this->checkPower('StudentAdd');
        $data = requestPost();
        $where['wa_id'] = $data['wa_id'];
        while ($a <= $data['n']) {
            $go_id['go_id'] = $data['go_id' . $a];
            $res = M('goods')->where($go_id)->find();
            if (!$res) {
                $this->error("商品id不存在，请核实！");
            }
            $num = $num + $data['sto_num' . $a];
            $where['go_id'] = $data['go_id' . $a];
            $wa = M('stock')->where($where)->find();
            if ($wa['go_num'] < $data['sto_num' . $a]) {
                $this->error('仓存不足');
            } else {
                $stock['go_num'] = $wa['go_num'] - $data['sto_num' . $a];
                M('stock')->where($where)->data($stock)->save();
            }
            $a++;
        }
        $wa_sizeout['wa_id'] = $data['wa_id'];
        $wa_sizeoutnum['wa_sizeout'] = $wa['wa_sizeout'] - $num;
        M('warehouse')->where($wa_sizeout)->data($wa_sizeoutnum)->save();


        $res = M('stock_out')->data($data)->add();
        //var_dump($data['go_id'.$i]);
        $k = $res;
        if ($res) {
            while ($i <= $data['n']) {
                $data2['sto_id'] = $k;
                $data2['go_id'] = $data['go_id' . $i];
                $data2['sto_num'] = $data['sto_num' . $i];
                $res2 = M('stock_out_detail')->data($data2)->add();
                $i++;
            }

            $this->saveLog('添加出库订单：' . $res['sto_id'], 'insert');
            $this->success('添加成功', cookie('backurl'));
        } else {
            $this->error('添加失败，请稍后重试');
        }
    }

    /**
     *修改入库信息操作
     */
    public function doEdit()
    {
        $this->checkPower('StudentAdd');
        $data = requestPost();
        $this->saveLog('修改入库订单：' . $data['sti_id'], 'update');
        $this->success('修改成功', cookie('backurl'));
    }


    /**
     *修改出库信息操作
     */
    public function doEdit_out()
    {
        $this->checkPower('StudentAdd');
        $data = requestPost();
        $this->saveLog('修改出库订单：' . $data['sto_id'], 'update');
        $this->success('修改成功', cookie('backurl'));
    }

    /**
     *删除入库订单信息操作
     */
    public function doDel()
    {
        $this->checkPower("StudentDel");
        $ids = request('ids');
        if (empty($ids)) {
            $this->error("请先选择要删除的记录！");
        }
        $this->saveLog("删除入库订单：" . $ids, "del");
        $where['sti_id'] = array('in', $ids);
        $wa_id['wa_id'] = M('stock_in')->where($where)->getField('wa_id');
        $stock['wa_id'] = $wa_id['wa_id'];
        $wa_id['wa_id'] = $wa_id['wa_id'];
        $delet = M('stock_in_detail')->where($where)->find();
        foreach ($delet as $key => $v) {
            $stock['go_id'] = $v['go_id'];
            $go_num = M('stock')->where($stock)->getField('go_num');
            $data['go_num'] = $go_num - $v['sti_num'];
            M('stock')->where($stock)->data($data)->save();
            $warehouse['wa_sizeout'] = M('warehouse')->where($wa_id)->getField('wa_sizeout');
            $warehouse['wa_sizeout'] = $warehouse['wa_sizeout'] - $v['sti_num'];

        }
        M('warehouse')->where($wa_id)->data($warehouse)->save();
        M('stock_in_detail')->where($where)->delete();
        $this->delete("stock_in", $where);

    }

    /**
     *删除出库订单信息操作
     */
    public function doDel_out()
    {
        $this->checkPower("StudentDel");
        $ids = request('ids');
        if (empty($ids)) {
            $this->error("请先选择要删除的记录！");
        }
        $this->saveLog("删除出库订单：" . $ids, "del");
        $where['sto_id'] = array('in', $ids);
        $wa_id['wa_id'] = M('stock_out')->where($where)->getField('wa_id');
        $stock['wa_id'] = $wa_id['wa_id'];
        $wa_id['wa_id'] = $wa_id['wa_id'];
        $warehouse['wa_sizeout'] = M('warehouse')->where($wa_id)->getField('wa_sizeout');
        $delet = M('stock_out_detail')->where($where)->find();
        foreach ($delet as $key => $v) {
            $stock['go_id'] = $v['go_id'];
            $go_num = M('stock')->where($stock)->getField('go_num');
            $data['go_num'] = $go_num + $v['sto_num'];
            M('stock')->where($stock)->data($data)->save();
            $warehouse['wa_sizeout'] = $warehouse['wa_sizeout'] + $v['sto_num'];

        }
        M('warehouse')->where($wa_id)->data($warehouse)->save();
        M('stock_out_detail')->where($where)->delete();
        $this->delete("stock_out", $where);

    }

}