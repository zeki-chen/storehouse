<?php
require_once dirname(__FILE__)."/TPWechat.php";
class wxauth {
	private $options;
	public $open_id;
	public $wxuser;
	private $authOption;
	public function __construct($options, $authOption) {
		$this->options = $options;
		$this->authOption = $authOption;
		$this->wxoauth ( $authOption );
		session_start ();
	}
	public function wxoauth() {
		// $scope='snsapi_base';//'snsapi_userinfo'
		$scope = $this->authOption ['scope'];
		$toUrl = $this->authOption ['url'];
		$code = isset ( $_GET ['code'] ) ? $_GET ['code'] : '';
		$token_time = isset ( $_SESSION ['token_time'] ) ? $_SESSION ['token_time'] : 0;
		if (1 == 2 && ! $code && isset ( $_SESSION ['open_id'] ) && isset ( $_SESSION ['user_token'] ) && $token_time > time () - 600) {
			if (! $this->wxuser) {
				$this->wxuser = $_SESSION ['wxuser'];
			}
			$this->open_id = $_SESSION ['open_id'];
			return $this->open_id;
		} else {
			$options = array (
					'token' => $this->options ["token"], // 填写你设定的key
					'appid' => $this->options ["appid"], // 填写高级调用功能的app id
					'appsecret' => $this->options ["appsecret"] 
			); // 填写高级调用功能的密钥
			
			$we_obj = new TPWechat ( $options );
			if ($code) {
				$json = $we_obj->getOauthAccessToken ();
				$we_obj->log("code:".$code);
				if (! $json) {
					unset ( $_SESSION ['wx_redirect'] );
					die ( '获取用户授权失败，请重新确认' );
				}
				$_SESSION ['open_id'] = $this->open_id = $json ["openid"];
				$access_token = $json ['access_token'];
				$_SESSION ['user_token'] = $access_token;
				$_SESSION ['token_time'] = time ();
				$userinfo = $we_obj->getUserInfo ( $this->open_id );
				
				if ($userinfo && ! empty ( $userinfo ['nickname'] )) {
					// 已经关注的用户,scope是snsapi_base
					$this->wxuser = array (
							'openid' => $this->open_id,
							'nickname' => $userinfo ['nickname'],
							'sex' => intval ( $userinfo ['sex'] ),
							'location' => $userinfo ['province'] . '-' . $userinfo ['city'],
							'headimgurl' => $userinfo ['headimgurl'],
							'country' => $userinfo ['country'] 
					);
				} elseif (strstr ( $json ['scope'], 'snsapi_userinfo' ) !== false) {
					$userinfo = $we_obj->getOauthUserinfo ( $access_token, $this->open_id );
					if ($userinfo && ! empty ( $userinfo ['nickname'] )) {
						$this->wxuser = array (
								'openid' => $this->open_id,
								'nickname' => $userinfo ['nickname'],
								'sex' => intval ( $userinfo ['sex'] ),
								'location' => $userinfo ['province'] . '-' . $userinfo ['city'],
								'headimgurl' => $userinfo ['headimgurl'],
								'country' => $userinfo ['country'] 
						);
					} else {
						return $this->open_id;
						
					}
				} else {
					// 只获取OPENID，且未关注
					$this->wxuser = array (
							'openid' => $this->open_id 
					);
				}
				if ($this->wxuser) {
					$_SESSION ['wxuser'] = $this->wxuser;
					$_SESSION ['open_id'] = $json ["openid"];
					unset ( $_SESSION ['wx_redirect'] );
					return $this->open_id;
				}
				return $userinfo;
				// $scope = 'snsapi_userinfo';
			}
			$oauth_url = $we_obj->getOauthRedirect ( $toUrl, "wxbase", $scope );
			$we_obj->log("get code url:".$oauth_url);				
			header ( 'Location: ' . $oauth_url );
		}
	}
}


