<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/10/27
 * Time: 15:55
 */

namespace Think\Template\TagLib;
use Think\Template\TagLib;

class YcPower extends TagLib{
	protected $tags=array(
		'li'=>array(
			'attr'=>'title,power,href,target',
			'close'=>1
		),
		'cp'=>array(
			'attr'=>'power',
			'close'=>1
		),
	);

	public function _li($tag,$content){
		$title=$tag['title'];
		$power=$tag['power'];
		$href=$tag['href'];
		$target=$tag['target'];
		$str='<php>$power=checkPower("'.$power.'");</php>';
		$str.="<eq name=\"power\" value=\"1\"><li><cite></cite><a href=\"$href\" target=\"$target\">$title</a></li></eq>";
		dump($str);
		return $str;
	}

	public function _cp($tag,$content){
		$power=$tag['power'];
		$str='<php>$power=checkPower("'.$power.'");</php>';
		$str.="<eq name=\"power\" value=\"1\">".$content."</eq>";
		return $str;
	}
}