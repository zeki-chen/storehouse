<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?php echo ($sysInfo["title"]); ?>管理后台</title>
	<title><?php echo ((isset($title) && ($title !== ""))?($title):$sysInfo['sys_name']); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/phpstorehouse/Public/Admin/css/yc_edit.css"/>
<link href="/phpstorehouse/Public/Common/css/common_yckj.css" rel="stylesheet" type="text/css" />
<link href="/phpstorehouse/Public/Common/css/iconfont.css" rel="stylesheet" type="text/css" />
<link href="/phpstorehouse/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/phpstorehouse/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<link href="/phpstorehouse/Public/Admin/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/phpstorehouse/Public/Validform_v5.3.2/css/validform.css" rel="stylesheet" />
<link href="/phpstorehouse/Public/layer-v3.0.1/layer/skin/default/layer.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="/phpstorehouse/Public/webuploader-0.1.5/webuploader.css" />


<script language="JavaScript" src="/phpstorehouse/Public/Common/js/jquery-1.8.3.min.js"></script>
<script src="/phpstorehouse/Public/Validform_v5.3.2/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="/phpstorehouse/Public/webuploader-0.1.5/webuploader.js"></script>

<!--kindeditor-->
<link rel="stylesheet" href="/phpstorehouse/Public/kindeditor/themes/default/default.css" />
<script src="/phpstorehouse/Public/kindeditor/kindeditor-min.js"></script>
<script src="/phpstorehouse/Public/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/phpstorehouse/Public/layer-v3.0.1/layer/layer.js"></script>


<script src="/phpstorehouse/Public/My97DatePicker/WdatePicker.js"></script>
<script src="/phpstorehouse/Public/Admin/js/select2.full.min.js"></script>
<script type="text/javascript" src="/phpstorehouse/Public/Admin/js/jquery.idTabs.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/phpstorehouse/Public/ueditor1_4_3/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/phpstorehouse/Public/ueditor1_4_3/ueditor.all.min.js"></script>


<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="/phpstorehouse/Public/ueditor1_4_3/lang/zh-cn/zh-cn.js"></script>


<script language="JavaScript" src="/phpstorehouse/Public/Admin/js/common.js"></script>
<script>
	var ignoreHid=true;
	KindEditor.ready(function(K) {
		var editor_img = K.editor({
			allowFileManager: true,
			allowImageUpload: true
		});
		$('.image1').click(function() {
			var parent = $(this).parent();
			editor_img.loadPlugin('image', function() {
				editor_img.plugin.imageDialog({
					imageUrl: parent.children('.url1').val(), //K('#url1').val(),
					clickFn: function(url, title, width, height, border, align) {
						parent.children('.url1').val(url);
						parent.children('.img1').attr("src", url).attr("ref", url).show();
						parent.children(".Validform_checktip").removeClass("Validform_wrong").addClass("Validform_right").html("");
						editor_img.hideDialog();
					}
				});
			});
		});
		K('.insertfile').click(function() {
			var parent = $(this).parent();
			editor_img.loadPlugin('insertfile', function() {
				
				editor_img.plugin.fileDialog({							
					fileUrl : parent.children('.url').val(),
					clickFn : function(url, title) {
						parent.children('.url').val(url);
						editor_img.hideDialog();
					}
				});
			});
		});
		var editor_media = K.editor({
				allowFileManager: true,
				allowImageUpload: true,
				uploadJson: '/phpstorehouse/Public/kindeditor/php/upload_json_media.php'
		});				
		K('.midiabtn').click(function() {
			var parent = $(this).parent();			
			editor_media.loadPlugin('insertfile', function() {				
				editor_media.plugin.fileDialog({							
					fileUrl : parent.children('.url').val(),
					clickFn : function(url, title) {
						parent.children('.url').val(url);
						parent.children('.audiobox').attr("src",url);
						parent.children('.spanurl').html(url);						
						//audiobox
						editor_media.hideDialog();
					}
				});
			});
		});
	
	
	});
</script>


	<script language="javascript">
		$(function() {
			$('.loginbox').css({
				'position': 'absolute',
				'left': ($(window).width() - 692) / 2
			});
			$(window).resize(function() {
				$('.loginbox').css({
					'position': 'absolute',
					'left': ($(window).width() - 692) / 2
				});
			})
		});
	</script>
</head>

<body style="background-color:#1c77ac; background-image:url(); background-repeat:no-repeat; background-position:center top; overflow:hidden;">

<div id="mainBody">
	<div id="cloud1" class="cloud"></div>
	<div id="cloud2" class="cloud"></div>
</div>

<div class="logintop">
	<span><?php echo ($sysInfo["title"]); ?>管理后台</span>
</div>

<div class="loginbody">
	<div class="p20 fs30 white tc pb0"><?php echo ($sysInfo["title"]); ?>管理后台</div>

	<span class="systemlogo"></span>

	<div class="loginbox loginbox1">
		<form class="mainform" role="form" method="post" action="<?php echo U('Index/doLogin');?>">
			<ul>
				<li>
					<input name="name" type="text" class="loginuser" placeholder="请输入管理员账号" />
				</li>
				<li>
					<input name="pwd" type="password" class="loginpwd" placeholder="请输入密码" />
				</li>
				<li class="yzm">
					<span><input name="verify" type="text" placeholder="请输入验证码"/></span><cite>
					<img src="<?php echo U('Index/verify');?>" class="chk_code_img" style="cursor: pointer;height: 44px;width: 112px;position: relative;top:1px;left: 0px;"  onclick="changeVerify()" />
					<script>
						function changeVerify(){
							$(".chk_code_img").attr("src", "<?php echo U('Index/verify');?>");
						}
					</script>
				</cite>
				</li>
				<li>
					<input name="" type="submit" class="loginbtn" value="登录" />
				</li>
			</ul>
		</form>

		<!--导入validform-->
		<script>
			$(function() {
				$(".mainform").Validform({
					tiptype: 4,
					ignoreHidden: true,
					showAllError: true,
					ajaxPost: true,
					beforeSubmit: function(curform) {
						loading("正在提交");
					},
					callback: function(data) {
						if (data.status == 1) {
							msgOK(data.info);
						} else {
							msgFaild(data.info);
							changeVerify();
						}
						if (data.url) {
							loading(data.info + ",正在跳转中...");
							hrefTo(data.url, 1000)
						}
					}
				});
			});
		</script>
	</div>
</div>

</body>
</html>