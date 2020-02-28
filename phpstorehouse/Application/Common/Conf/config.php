<?php
$config = array (
		'DB_PATH_NAME'=> 'databak',        //备份目录名称,主要是为了创建备份目录
		'DB_PATH'     => './databak/',     //数据库备份路径必须以 / 结尾；
		'DB_PART'     => '20971520',  //该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M
		'DB_COMPRESS' => '1',         //压缩备份文件需要PHP环境支持gzopen,gzwrite函数        0:不压缩 1:启用压缩
		'DB_LEVEL'    => '9',         //压缩级别   1:普通   4:一般   9:最高
		'TMPL_ACTION_ERROR' => 'Public:error', // 默认成功跳转对应的模板文件				
		'LOG_RECORD' => true, // 开启日志记录
		// 'SHOW_PAGE_Trace' =>true,//打开调试
		'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误

		'PAGE_SIZE'=>15,
        'MOBILE_PAGE_SIZE'=>6,
		
		'WX_ID'=>'4',//公众号ID		
		// 是否开启session
		'SESSION_AUTO_START' => true ,
		'LOAD_EXT_CONFIG' => 'db',
        'xfzz'=>array(
            'appid'=>'wx9ef62ca775283d06', // 填写高级调用功能的app id
            'appsecret'=>'2d1af00a4f71189c7378dd681f2974df'
        )
);
return $config;
