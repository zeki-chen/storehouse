<?php

if (get_magic_quotes_gpc ()) {

	function stripslashes_deep($value) {
		$value = is_array ( $value ) ? array_map ( 'stripslashes_deep', $value ) : stripslashes ( $value );
		return $value;
	}
	$_POST = array_map ( 'stripslashes_deep', $_POST );
	$_GET = array_map ( 'stripslashes_deep', $_GET );
	$_COOKIE = array_map ( 'stripslashes_deep', $_COOKIE );
}

/**
 * 裁剪字符串
 * @param unknown $str
 * @param unknown $len
 * @return string
 */
function  cutString($str,$len){
	$str=strip_tags($str);
	$strLen=strlen($str);
	//$str=$strLen.$str;
	if($strLen<=$len*3){
		return $str;
	}	
	$str=str_replace("&nbsp;", '',$str);//替换空格
	$str=str_replace(" ", '',$str);//替换空格
	return mb_substr($str,0,$len,'utf-8')."...";
}

/**
 * 序列化
 * @param unknown $obj
 * @return string
 */
function my_serialize($obj) {
	return base64_encode ( gzcompress ( serialize ( $obj ) ) );
}

// 反序列化
/**
 * 反序列化
 * @param unknown $txt
 * @return mixed
 */
function my_unserialize($txt) {
	return unserialize ( gzuncompress ( base64_decode ( $txt ) ) );
}

/**
 * 获取参数
 *
 * @param unknown $key
 * @param unknown $df_value
 */
function request($key='', $df_value = '') {
	if($key==''){//如果为空，就接收所有参数
		$requestArr=array();
		foreach($_REQUEST as $k=>$v){
			$requestArr[$k]=trim(I($k));		
		}
		return $requestArr;
	}
	return isset ( $_REQUEST [$key] ) ? trim ( $_REQUEST [$key] ) : $df_value;	
}
/**
 * 获取POST变量
 * @param string $key
 * @param string $df_value
 * @return multitype:|string
 */
function requestPost($key='', $df_value = '') {
	if($key==''){//如果为空，就接收所有参数
		$requestArr=array();
		foreach($_POST as $k=>$v){
			$requestArr[$k]=trim($_POST[$k]);			
		}
		return $requestArr;
	}
	return isset ( $_POST [$key] ) ? trim ( $_POST [$key] ) : $df_value;
}

/**
 * 获取GET变量
 * @param string $key
 * @param string $df_value
 * @return multitype:|string
 */
function requestGet($key='', $df_value = '') {
	if($key==''){//如果为空，就接收所有参数
		$requestArr=array();
		foreach($_GET as $k=>$v){
			$requestArr[$k]=trim($_GET[$k]);		
		}
		return $requestArr;
	}
	return isset ( $_GET [$key] ) ? trim ( $_GET [$key] ) : $df_value;
}



/**
 * 获取参数，先get,后post,最后cookie
 * @param unknown $key 参数名
 * @return unknown|mixed|string
 */
function getParam($key){
	//$str="oetCntxEFGHI22Ko4CDqQCoxjAB";
	$val=request($key);
	if(empty($val)){
		$val=cookie($key);
	}
	return $val;
}

/**
 * 输出图片。根据需求自动裁剪图片
 *
 * @param unknown $file
 * @param number $width
 * @param number $height
 * @param string $def
 * @return unknown|mixed 使用例子：<img src="{:img('/wyzxqy/Tools/Upload/../../Upload/image/20150529/20150529103500_39141.jpg',90,90)}" />
 */
function img($file, $width = 200, $height = 200, $def = '') {

    if (preg_match ( '/^http:\/\//', $file )) {
        // 如果是远程文件
        return $file;
    }
    if(empty($file)){
        return  $def;
    }
    $root=dirname( $_SERVER['DOCUMENT_ROOT']."/aa")."/" ;
    //var_dump( $_SERVER['DOCUMENT_ROOT']);
    $realFile=$root.$file;
    //var_dump($root);

    //获得文件扩展名
    $temp_arr = explode(".", $file);
    $file_ext = array_pop($temp_arr);
    $file_ext = trim($file_ext);
    $file_ext = strtolower($file_ext);

    $baseFile = basename ( $file ); // 找到文件名
    $basePath = str_replace ( $baseFile, "", $file ) . "temp/"; // 找到目录
    $baseFile = str_replace ( ".", "", $baseFile ); // 替换掉“.”
    $baseFile .= $width . "x" . $height . ".jpg";
    $basePath = str_replace ( C ( 'VIR_DIR' ), ".", $basePath ); // 替换掉虚拟目录

    if (! is_readable ( $root.$basePath )) { // 判断文件夹是否存在，不存在就创建
        is_file ( $root.$basePath ) or mkdir ( $root.$basePath, 0777 );
    }
    $baseFile = $basePath . $baseFile;
    // trace ( $baseFile, "basefiel" );
    $file = str_replace ( C ( 'VIR_DIR' ), ".", $file ); // 替换掉虚拟目录

    //var_dump($file);

    if (! file_exists ($root.$file )) { // 判断原文件是否存在,不存在直接返回。
        if (empty ( $def )) { // 如果没有默认图片
            return $file;
        } else {
            // trace($def,"def");
            return $def;
        }
    }


    //后缀名
    if($file_ext=="gif"){
        return $file;
    }



    if (! file_exists ( $root.$baseFile )) { // 判断文件是否存在
        $image = new \Think\Image ();
        $image->open ( $root.$file ); // 生成一个缩放后填充大小的缩略图并保存
        $image->thumb ( $width, $height,\Think\Image::IMAGE_THUMB_CENTER )->save ( $root.$baseFile ); // 生成缩略图
    }
    $str2 = substr ( $baseFile, 0, 2 ); // 取前两个字符串

    if ($str2 == "./") {
        $baseFile = C ( 'VIR_DIR' ) . substr ( $baseFile, 1 ); // 取前两个字符串
    }
    return $baseFile;
}

/**
 * 输出图片。根据需求自动裁剪图片,四周留白
 *
 * @param unknown $file
 * @param number $width
 * @param number $height
 * @param string $def
 * @return unknown|mixed 使用例子：<img src="{:img('/wyzxqy/Tools/Upload/../../Upload/image/20150529/20150529103500_39141.jpg',90,90)}" />
 */
function img_filled($file, $width = 200, $height = 200, $def = '') {

    if (preg_match ( '/^http:\/\//', $file )) {
        // 如果是远程文件
        return $file;
    }
    if(empty($file)){
        return  $def;
    }
    $root=dirname( $_SERVER['DOCUMENT_ROOT']."/aa")."/" ;
    //var_dump( $_SERVER['DOCUMENT_ROOT']);
    $realFile=$root.$file;
    //var_dump($root);

    //获得文件扩展名
    $temp_arr = explode(".", $file);
    $file_ext = array_pop($temp_arr);
    $file_ext = trim($file_ext);
    $file_ext = strtolower($file_ext);

    $baseFile = basename ( $file ); // 找到文件名
    $basePath = str_replace ( $baseFile, "", $file ) . "temp/"; // 找到目录
    $baseFile = str_replace ( ".", "", $baseFile ); // 替换掉“.”
    $baseFile .= $width . "x" . $height . ".jpg";
    $basePath = str_replace ( C ( 'VIR_DIR' ), ".", $basePath ); // 替换掉虚拟目录

    if (! is_readable ( $root.$basePath )) { // 判断文件夹是否存在，不存在就创建
        is_file ( $root.$basePath ) or mkdir ( $root.$basePath, 0777 );
    }
    $baseFile = $basePath . $baseFile;
    // trace ( $baseFile, "basefiel" );
    $file = str_replace ( C ( 'VIR_DIR' ), ".", $file ); // 替换掉虚拟目录

    //var_dump($file);

    if (! file_exists ($root.$file )) { // 判断原文件是否存在,不存在直接返回。
        if (empty ( $def )) { // 如果没有默认图片
            return $file;
        } else {
            // trace($def,"def");
            return $def;
        }
    }


    //后缀名
    if($file_ext=="gif"){
        return $file;
    }



    if (! file_exists ( $root.$baseFile )) { // 判断文件是否存在
        $image = new \Think\Image ();
        $image->open ( $root.$file ); // 生成一个缩放后填充大小的缩略图并保存
        $image->thumb ( $width, $height,\Think\Image::IMAGE_THUMB_FILLED )->save ( $root.$baseFile ); // 生成缩略图
    }
    $str2 = substr ( $baseFile, 0, 2 ); // 取前两个字符串

    if ($str2 == "./") {
        $baseFile = C ( 'VIR_DIR' ) . substr ( $baseFile, 1 ); // 取前两个字符串
    }
    return $baseFile;
}

/**
 * 高亮关键字
 * @param unknown $title
 * @param string $keyword
 * @return unknown
 */
function  markKeyword($keyword='',$title){
	if(empty($keyword)){
		return  $title;
	}
	$str=str_replace($keyword, '<span style="color:#bc2121">'.$keyword.'</span>',$title);
	return $str;
}



/**
 * 跳转
 *
 * @param unknown $url
 */
function jumpUrl($url) {
	if (! empty ( $url )) {
		redirect ( $url );
		exit ();
	}
}


function simpleHtmlEncode($str){
	$str = str_replace ( "\r\n", "<br/>", $str ); // \r\n
	$str= str_replace ( "\r", "<br/>", $str ); // 替换"\r"
	$str= str_replace ( "\n", "<br/>", $str ); // 替换"\n"
	$str= str_replace ( " ", "&nbsp;", $str ); // 替换"\n"
	return $str;
}


function simpleHtmlDecode($str){
	$str=str_replace("<br/>","\r\n",$str);
	$str=str_replace("&nbsp;"," ",$str);
	return $str;
}

/**
 * 显示关键字
 * @param unknown $keyword
 * @param unknown $content
 * @return mixed
 */
function showKeyword($keyword,$content){
	return str_replace($keyword,"<font class='red'>$keyword</font>",$content);
}


/**
 * 发邮件
 * @param unknown $mailto
 * @param unknown $subject
 * @param unknown $content
 */
function  sendMail($mailto,$subject,$content){	
	vendor("Mail.phpmailer");
	$conditon['code']='web';
	$result=M('config')->where($conditon)->find();
	$model=unserialize($result['content']);

	$mail = new PHPMailer();   
    $mail->IsSMTP();                  // send via SMTP   
    $mail->Host = $model['SMTPServer'];   // SMTP servers   
    $mail->SMTPAuth = true;           // turn on SMTP authentication   
    $mail->Username = $model['SMTPusername'];     // SMTP username  注意：普通邮件认证不需要加 @域名   
    $mail->Password = $model['SMTPpwd']; // SMTP password   
    $mail->From = $model['email'];      // 发件人邮箱   
    $mail->FromName =  "管理员";  // 发件人   
    $mail->CharSet = "utf-8";   // 这里指定字符集！   
    //$mail->Encoding = "base64";   
    $mail->AddAddress($mailto);  // 收件人邮箱和姓名   
    //$mail->AddReplyTo("songend@126.com","yourdomain.com");//回复地址   
    //$mail->WordWrap = 50; // set word wrap 换行字数   
    //$mail->AddAttachment("115.28.161.5/phpmailer/class.phpmailer.php"); // attachment 附件   
    // $mail->AddAttachment("./test/test.png", "new.jpg");   
    $mail->IsHTML(true);  // send as HTML   
    // 邮件主题   
    $mail->Subject = $subject;   
    // 邮件内容   
    $mail->Body = "  
	    <html><head>  
	    <meta http-equiv='Content-Language' content='zh-cn'>  
	    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>  
	    </head>  
	    <body>"  
	    .$content. 
	    "</body>  
	    </html>  
	    ";                                                                         
    $mail->AltBody ="text/html";   
    if(!$mail->Send())   
    {   
        return false;   
        exit;   
    }   
    else {   
        return true;   
    }   

	// //使用163邮箱服务器
	// $smtpserver =$model['SMTPServer'];// "smtp.qq.com";
	// //163邮箱服务器端口
	// $smtpserverport = 25;
	// //你的163服务器邮箱账号
	// $smtpusermail =$model['email'];// "ycxxkj002@qq.com";
	// //收件人邮箱
	// $smtpemailto =$mailto;// "lzj500@qq.com";
	// //你的邮箱账号(去掉@163.com)
	// $smtpuser =$model['SMTPusername'];// "2936890167";//SMTP服务器的用户帐号
	// //你的邮箱密码
	// $smtppass = $model['SMTPpwd'];//"mail2015"; //SMTP服务器的用户密码
	// //邮件主题
	// $mailsubject = $subject;//"测试邮件发送";
	// //邮件内容
	// $mailbody =$content;// "<strong> PHP</strong>+<font style='color:red'>MySQL</font>+<a href='http://www.baidu.com'>点击跳转</a>";
	// //邮件格式（HTML/TXT）,TXT为文本邮件
	// $mailtype = "HTML";
	// //这里面的一个true是表示使用身份验证,否则不使用身份验证.
	// $smtp = new \smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
	// //是否显示发送的调试信息
	// $smtp->debug =false;// TRUE;
	// //$smtp->debug = TRUE;
	// //发送邮件
	// $res=$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
	// return $res;
	
}

/**
 * 获取当前完整URL
 * @return string
 */
function get_url() {
	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}


/**
 *  lzj:2015-12-17 add
 * 递归无限层级分类
 * @param unknown $data 要排序的数据
 * @param number $pid 父节点ID
 * @param number $depth 深度
 * @param string $id 主键ID
 * @param string $name 名称键值
 * @param string $pidKey 父结点键值
 * @return Ambigous <multitype:, multitype:string >
 */
function getTree(&$data,$pid=0,$depth=0,$id='cid',$name='class_name',$pidKey='pid'){
	$arr = array();
	foreach($data as $k=>$v){
		if($v[$pidKey] == $pid){
			$line = "";
			for($i = 0; $i < $depth; $i++){
				$line.= "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if($depth > 0){
				$line .= "|";
			}
			for($i = 0; $i < $depth; $i++){
				$line.= "—";
			}
			$v[$name] = $line.$v[$name];
			$arr[] = $v;
			$arr = array_merge($arr,getTree($data,$v[$id],$depth+1,$id,$name,$pidKey));
			//递归，结束条件$data没有对应PID的子元素了
		}
	}
	return $arr;
}


/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {	
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for ($i = 0; $size >= 1024 && $i < 5; $i++){
		$size /= 1024;
	}
	return round($size, 2) . $delimiter . $units[$i];
}
/**
 * 判断是不是数组的最后一位
 * @param unknown $arr
 * @param unknown $index
 */
function  isArrLast($arr,$index){
	$count=count($arr);
	if($index==$count-1){
		return true;
	}
	return false;
}

/**
 * 组合数组成字符串
 * @param $arr
 * @return string
 */
function conbineArr2Str($arr){
	$str="";
	$dot="";
	foreach($arr as $k=>$v){
		$str.=$dot.$v;
		$dot=",";
	}
	return $str;
}

?>