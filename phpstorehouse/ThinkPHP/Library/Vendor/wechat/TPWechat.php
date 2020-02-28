<?php
/**
 *	微信公众平台PHP-SDK, ThinkPHP实例
 *  @author dodgepudding@gmail.com
 *  @link https://github.com/dodgepudding/wechat-php-sdk
 *  @version 1.2
 *  usage:
 *   $options = array(
 *			'token'=>'tokenaccesskey', //填写你设定的key
 *			'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
 *			'appid'=>'wxdk1234567890', //填写高级调用功能的app id
 *			'appsecret'=>'xxxxxxxxxxxxxxxxxxx' //填写高级调用功能的密钥
 *		);
 *	 $weObj = new TPWechat($options);
 *   $weObj->valid();
 *   ...
 *
 */
require_once dirname(__FILE__)."/wechat.class.php";
class TPWechat extends Wechat
{
	/**
	 * log overwrite
	 * @see Wechat::log()
	 */
	public function log($log){
		if ($this->debug) {
			if (function_exists($this->logcallback)) {
				if (is_array($log)) $log = print_r($log,true);
				return call_user_func($this->logcallback,$log);
			}elseif (class_exists('Log')) {
				Log::write('wechat：'.$log, Log::DEBUG);
				return true;
			}
		}
		return false;
	}

	/**
	 * 重载设置缓存
	 * @param string $cachename
	 * @param mixed $value
	 * @param int $expired
	 * @return boolean
	 */
	protected function setCache($cachename,$value,$expired){
		if($expired>500){
			$expired=$expired-500;
		}
		$str=date('Y-m-d H:i:s  : wechat setCache  cachename:');
		$str.=$cachename;
		Think\Log::record($str,'WARN');
		//Log::write('wechat：'.$str);
		$data['access_token']=$value;
		$data['expired']=time()+$expired;
		return F($cachename,$data);
		//return S($cachename,$value,$expired);
	}

	/**
	 * 重载获取缓存
	 * @param string $cachename
	 * @return mixed
	 */
	protected function getCache($cachename){
		$data=F($cachename);
		if($data['expired']<time()){
			return '';
		}
		return $data['access_token'];
// 		return S($cachename);
	}

	/**
	 * 重载清除缓存
	 * @param string $cachename
	 * @return boolean
	 */
	protected function removeCache($cachename){
		return  F($cachename,null);
		//return S($cachename,null);
	}
	
	

}



