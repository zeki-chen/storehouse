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
				$(".leftmenu").height($(window).height() - 40);
				//导航切换
				$(".menuson .header").click(function() {
					var $parent = $(this).parent();
					$(".menuson>li.active").not($parent).removeClass("active open").find('.sub-menus').hide();
					$parent.addClass("active");
					if (!!$(this).next('.sub-menus').size()) {
						if ($parent.hasClass("open")) {
							$parent.removeClass("open").find('.sub-menus').hide();
						} else {
							$parent.addClass("open").find('.sub-menus').show();
						}
					}
				});
				// 三级菜单点击
//				$('.sub-menus li').click(function(e) {
//					$(".sub-menus li.active1").removeClass("active1");
//					$(this).addClass("active1");					
//					
//				});
				$(".menuson li").click(function(e) {
					//$(".menuson li").find('.sub-menus').hide();
					$(".menuson li").removeClass("active");
					$(this).addClass("active");					
					
				});
				
				$('.title').click(function() {
					var $ul = $(this).next('ul');
					$('dd').find('.menuson').slideUp();
					if ($ul.is(':visible')) {
						$(this).next('.menuson').slideUp();
					} else {
						$(this).next('.menuson').slideDown();
					}
				});
			})
		</script>

	</head>

	<body style="background:#f0f9fd;">
		<div class="lefttop"><span></span>功能菜单</div>

		<dl class="leftmenu">

			


<?php if(($power) == "1"): ?><dd>
        <div class="title">
            <span><img src="/phpstorehouse/Public/Admin/images/leftico01.png" /></span>仓库管理
        </div>
        <ul class="menuson">
            <?php $power=checkPower("StudentView"); if(($power) == "1"): ?><li><cite></cite><a href="<?php echo U('Warehouse/index');?>" target="rightFrame">仓库列表</a></li><?php endif; ?>
        </ul>
    </dd><?php endif; ?>



<?php $power=checkPower("MemberView"); if(($power) == "1"): ?><dd>
		<div class="title">
			<span><img src="/phpstorehouse/Public/Admin/images/leftico01.png" /></span>商品管理
		</div>
		<ul class="menuson">
			<li><cite></cite><a href="<?php echo U('Goods/index');?>" target="rightFrame">商品列表</a><i></i></li>
			<li><cite></cite><a href="<?php echo U('Goods/index2');?>" target="rightFrame">库存列表</a><i></i></li>
		</ul>
	</dd><?php endif; ?>
<?php $power=checkPower("MemberView"); if(($power) == "1"): ?><dd>
		<div class="title">
			<span><img src="/phpstorehouse/Public/Admin/images/leftico01.png" /></span>经销商管理
		</div>
		<ul class="menuson">
			<li><cite></cite><a href="<?php echo U('Manufacturer/index');?>" target="rightFrame">经销商列表</a><i></i></li>
		</ul>
	</dd><?php endif; ?>
<?php $power=checkPower("MemberView"); if(($power) == "1"): ?><dd>
		<div class="title">
			<span><img src="/phpstorehouse/Public/Admin/images/leftico01.png" /></span>出入库管理
		</div>
		<ul class="menuson">
			<li><cite></cite><a href="<?php echo U('Stock/index_in');?>" target="rightFrame">入库列表</a><i></i></li>
			<li><cite></cite><a href="<?php echo U('Stock/index_out');?>" target="rightFrame">出库列表</a><i></i></li>
		</ul>
	</dd><?php endif; ?>
<?php $power=checkPower("MemberView"); if(($power) == "1"): ?><dd>
		<div class="title">
			<span><img src="/phpstorehouse/Public/Admin/images/leftico01.png" /></span>仓库安全管理
		</div>
		<ul class="menuson">
			<li><cite></cite><a href="<?php echo U('jiedian/index1');?>" target="rightFrame">节点1列表</a><i></i></li>
			<li><cite></cite><a href="<?php echo U('jiedian/index2');?>" target="rightFrame">节点2列表</a><i></i></li>
			<li><cite></cite><a href="<?php echo U('jiedian/index3');?>" target="rightFrame">节点3列表</a><i></i></li>
		</ul>
	</dd><?php endif; ?>
<?php $power=checkPower("MemberView"); if(($power) == "1"): ?><dd>
		<div class="title">
			<span><img src="/phpstorehouse/Public/Admin/images/leftico01.png" /></span>操作员管理
		</div>
		<ul class="menuson">
			<li><cite></cite><a href="<?php echo U('User/index');?>" target="rightFrame">操作员列表</a><i></i></li>
		</ul>
	</dd><?php endif; ?>