<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/10/31
 * Time: 19:03
 */

namespace Admin\Controller;
use Think\Controller;

class ModelController extends AdminBaseController{
    public function __construct(){
        parent::__construct();
        $this->addBread('模型管理');
        $this->addBread('模型列表',U('Model/index'));
        $this->assign('yesno',$this->dicM->getByIndexCode('yesno'));
    }

    public function index(){
        $this->checkPower('ModelView');
        $this->assign('bread',$this->bread);
        $this->assign('title','模型列表');
        cookie('backurl',get_url());

        $where=array();
        $pageParam=array();

        $keyword=urldecode(request('keyword'));
        if($keyword!=""||$keyword!=null){
            $where['model_name']=array('like',"%$keyword%");
            $pageParam['keyword']=urlencode($keyword);
            $this->assign('keyword',$keyword);
        }
        $orderby="sort asc,addtime desc";
        $this->getList('model',$where,$orderby,$pageParam);
        $this->saveLog('查看模型列表','view');
        $this->display();
    }

    public function add(){
        $this->checkPower('ModelAdd');
        $this->addBread('添加模型');
        $this->assign('title','添加模型');
        $this->assign('bread',$this->bread);
        $this->getField();
        $this->display();
    }

    public function edit(){
        $this->checkPower('ModelEdit');
        $this->addBread('修改模型');
        $this->assign('title','修改模型');
        $this->assign('bread',$this->bread);
        $model_id=requestGet('model_id',0);
        if($model_id<=0){
            $this->error('参数错误');
        }
        $where['model_id']=$model_id;
        $model=M('model')->where($where)->find();
        if(!$model){
            $this->error('没有找到记录');
        }
        $config=unserialize($model['config']);
        // dump($config);
        $this->assign('null',$config['null']);//字段是否必填
        $this->assign('field',$config['field']);//模型已启用字段
        $this->assign('f_sort',$config['f_sort']);
        $this->assign('model_id',$model_id);
        $this->assign('config',$config);
        $this->getField();
        $this->display();
    }

    /**
     *添加模型
     */
    public function doAdd(){
        $this->checkPower('ModelAdd');
        $data=requestPost();

        $data['config']=$this->dealData();
        $this->saveLog('添加模型：'.$data['model_name'],'insert');
        $this->save('model',$data,1,'insert',cookie('backurl'));
    }

    /**
     *修改模型
     */
    public function doEdit(){
        $this->checkPower('ModelEdit');
        $data=requestPost();
        $data['config']=$this->dealData();
        $this->saveLog('修改模型：'.$data['model_name'],'update');
        $this->save('model',$data,1,'update',cookie('backurl'));
    }

    /**
     * 删除模型
     */
    public function doDel(){
        $this->checkPower("ModelDel");
        $ids=request('ids');
        if(empty($ids)){
            $this->error("请先选择要删除的记录！");
        }
        $where['model_id']=array('in',$ids);
        $model=M('art')->where($where)->find();
        if($model){
            $this->error('该模型下存在内容，请清空内容后重试');
        }
        $model=M('art_class')->where($where)->find();
        if($model){
            $this->error('该模型下存在分类，请清空分类后重试');
        }
        $this->saveLog("删除模型：".$ids,"del");
        $this->delete("model", $where);
    }


    /**
     *获取字段并赋值
     */
    private function getField(){
        $where['valid']=1;
        $orderby="sort asc,addtime desc";
        $fieldList=M('field')->where($where)->order($orderby)->select();
        // $field=array();
        // foreach($fieldList as $k=>$v){
            
        // }
        // print_r($fieldList);
        $this->assign('fieldList',$fieldList);
    }


    /**
     * 处理配置数据
     * @return string
     */
    private function dealData(){
        $config=$_POST;
        unset($config['addtime'],$config['updatetime']);
        $config['field']=implode(',',$config['field']);
        $arr=$config['f_sort'];
        asort($arr);
        $config['f_sort']=$arr;
        return serialize($config);
    }

    public function quickEdit(){
        $this->checkPower('ModelEdit');
        $table=I('get.table');
        $id_name=I('get.id_name');
        $id_value=I('get.id_value');
        $where[$id_name]=$id_value;
        $model=M($table)->where($where)->find();
        if(!$model){
            $this->error('修改失败');
        }
        $config=unserialize($model['config']);
        $key=I('get.key');
        $content=I('get.content');
        $config[$key]=$content;
        $model[$key]=$content;
        $model['updatetime']=time();
        $model['config']=serialize($config);
        $res=M($table)->data($model)->save();
        if(!$res){
            $this->ajaxReturn(array('status'=>0,'info'=>'修改失败'));
        }else{
            $this->ajaxReturn(array('status'=>1,'info'=>'修改成功'));
        }
    }
}