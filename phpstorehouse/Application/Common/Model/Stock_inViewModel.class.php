<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/11/2
 * Time: 12:22
 */

namespace Common\Model;
use Think\Model\ViewModel;

class Stock_inViewModel extends ViewModel{
    public $viewFields = array(
        'stock_in'=>array('*','_type'=>'LEFT'),

        'warehouse'=>array('wa_name','_on'=>'stock_in.wa_id=warehouse.wa_id'),

        'user'=>array('us_name','_on'=>'stock_in.us_id=user.us_id')
    );
}