<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
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

	<script type="text/javascript">
		$(function() {
			//顶部导航切换
			$(".nav li a").click(function() {
				$(".nav li a.selected").removeClass("selected")
				$(this).addClass("selected");
				// parent.rightFrame.location.href=$(this).attr('righturl');
			})
		})
	</script>

</head>

<body style="background:url(/phpstorehouse/Public/Admin/images/topbg.gif) repeat-x;">

<div class="topleft" >
	<a href="javascript:void(0)" target="_parent"><?php echo ($sysInfo["title"]); ?>管理系统</a>
</div>

<ul class="nav">
	<!-- <li>
		<a href="<?php echo U('Main/main');?>" target="rightFrame" class="selected"><img src="/phpstorehouse/Public/Admin/images/icon01.png" title="工作台" />
			<h2>工作台</h2>
		</a>
	</li> -->
	<?php $power=checkPower("ArtView,ArtClassView,SurveyView,MemberView,FeedBackView,VisitView,EnterpriseView"); if(($power) == "1"): ?><li>
			<a href="<?php echo U('Main/left');?>" righturl="<?php echo U('Art/index',array('model_id'=>13));?>" target="leftFrame" class=""><img src="/phpstorehouse/Public/Admin/images/icon16.png" title="资讯管理" />
				<h2>数据管理</h2>
			</a>
		</li><?php endif; ?>

	<?php $power=checkPower("AdminView,AdminRoleView,AdminPowerView"); if(($power) == "1"): ?><li>
			<a href="<?php echo U('Main/left_user');?>" righturl="<?php echo U('Admin/index');?>" target="leftFrame"><img src="/phpstorehouse/Public/Admin/images/icon13.png" title="用户管理" />
				<h2>管理员管理</h2>
			</a>
		</li><?php endif; ?>

	<?php $power=checkPower("PageLogView,DataBakView,LogSettingView,WebSettingView,ApiSettingView,KeywordView,NavView,ModelView,FieldView"); if(($power) == "1"): ?><li>
			<a href="<?php echo U('Main/left_sys');?>" righturl="<?php echo U('PageLog/index');?>" target="leftFrame"><img src="/phpstorehouse/Public/Admin/images/icon06.png" title="系统维护" />
				<h2>系统维护</h2>
			</a>
		</li><?php endif; ?>
</ul>

<div class="topright">
	<ul>

		<li><a><?php echo ($admin["aname"]); ?>,欢迎您</a></li>
		<li><a href="/phpstorehouse/index.php" target="_blank">网站首页</a></li>
		<li><a href="<?php echo U('Index/quit');?>" target="_top" onclick="javascript:parent.loading('退出成功！')">退出</a></li>
	</ul>

</div>

</body>
<script type="text/javascript">
	$(function(){
		// console.log($('.nav li').size());
		var li=$('.nav li').first();
		var a=li.find('a');
		a.addClass('selected');
		var href=a.attr('href');
		if(typeof(href)!='undefined'){
			parent.leftFrame.location.href=href;
		}
	})
</script>

</html>