<?php

namespace Common\Model;

use Think\Model\ViewModel;

class AdminViewModel extends ViewModel {
	public $viewFields = array(
			'admin'=>array('aid','aname','pwd','realname','valid','ar_id','tel','addtime','updatetime','_type'=>'LEFT'),
				
			'admin_role'=>array('ar_name','ap_codes','_on'=>'admin.ar_id=admin_role.ar_id')
	);
}