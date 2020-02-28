<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/10/28
 * Time: 21:29
 */

namespace Common\Model;
use Think\Model\ViewModel;

class GoodsViewModel extends ViewModel{
    public $viewFields = array(
        'goods'=>array('*','_type'=>'LEFT'),

        'manufacturer'=>array('ma_name','_on'=>'goods.ma_id=manufacturer.ma_id')
    );
}