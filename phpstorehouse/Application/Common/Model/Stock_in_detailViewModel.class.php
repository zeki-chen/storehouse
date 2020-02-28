<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/11/2
 * Time: 12:22
 */

namespace Common\Model;
use Think\Model\ViewModel;

class Stock_in_detailViewModel extends ViewModel{
    public $viewFields = array(
        'stock_in_detail'=>array('*','_type'=>'LEFT'),

        'goods'=>array('go_name','go_price','_on'=>'stock_in_detail.go_id=goods.go_id')
    );
}