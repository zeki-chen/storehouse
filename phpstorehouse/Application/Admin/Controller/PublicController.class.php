<?php

namespace Admin\Controller;

use Think\Controller;

class PublicController extends AdminBaseController {
	
	public function map(){
		//24.816174,113.603756
		$lat=request("lat");
		if(empty($lat)||$lat<=0){
			$lat="24.816174";
		}
		$this->assign("lat",$lat);		
		$lng=request("lng");
		if(empty($lng)||$lng<=0){
			$lng="113.603756";
		}
		$this->assign("lng",$lng);
		$this->display();
	}


}