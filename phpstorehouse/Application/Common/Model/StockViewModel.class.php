<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2017/1/18
 * Time: 15:14
 */

namespace Common\Model;
use Think\Model\ViewModel;

class StockViewModel extends ViewModel{
    public $viewFields = array(
        'stock'=>array('*','_type'=>'left'),

        'warehouse'=>array('wa_name','_on'=>'stock.wa_id=warehouse.wa_id'),
         
        'goods'=>array('*','_on'=>'stock.go_id=goods.go_id'),

        'manufacturer'=>array('ma_name','_on'=>'goods.ma_id=manufacturer.ma_id')

    );
}