<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

</head>

<body>

<div class="place" style="position: relative;">
	<span>位置：</span>
	<ul class="placeul">
		<?php if(is_array($bread)): foreach($bread as $key=>$vo): ?><li>
				<?php if(empty($vo['url'])): echo ($vo["name"]); ?>
					<?php else: ?>
					<a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["name"]); ?></a><?php endif; ?>
			</li><?php endforeach; endif; ?>

	</ul>

	<a href="javascript:history.go(-1)" class="goback">返回</a>
</div>

<div class="rightinfo">

    <div class="tools">
        <ul class="toolbar">
            <?php $power=checkPower("AdminAdd"); if(($power) == "1"): ?><li class="click">
                    <a href="<?php echo U('Admin/add');?>">
                        <span><img src="/phpstorehouse/Public/Admin/images/t01.png"/></span>添加</a>
                </li><?php endif; ?>
            <?php $power=checkPower("AdminDel"); if(($power) == "1"): ?><li class="click">
                    <a href="javascript:delMut('<?php echo U(" Admin/doDel");?>')">
                    <span><img src="/phpstorehouse/Public/Admin/images/t03.png"/></span>删除</a>
                </li><?php endif; ?>
        </ul>

        <form action="<?php echo U('Admin/index');?>" method="get">
            <ul class="toolbar1">
                <li>关键词：
                    <input type="text" name="keyword" class="scinput" placeholder="请输入关键词" value="<?php echo ($keyword); ?>"/>
                </li>
                <li>
                    <input type="submit" class="scbtn button_primary" value="查询"/>
                </li>
            </ul>
        </form>

    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th width="60">
                <label class="">
                    <input type="checkbox" class="selectAll"/>全选
                </label>
            </th>
            <th width="" class="tl">管理员账号</th>
            <th width="160">角色</th>
            <th width="200">真实姓名</th>
            <th width="160">是否有效</th>
            <?php $power=checkPower("AdminEdit,AdminPsw,AdminDel"); if(($power) == "1"): ?><th width="160">操作</th><?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): foreach($list as $k=>$item): ?><tr><input class="id" type="hidden" name="aid" value="<?php echo ($item["aid"]); ?>"/>
                <td>
                    <input type="checkbox" value="<?php echo ($item["aid"]); ?>" class="del_checkbox"/>
                </td>
                <td class="tl"><?php echo ($item["aname"]); ?></td>
                <td><?php echo ($item["ar_name"]); ?></td>
                <td class="yc_edit"><span class="null" name="realname"><?php echo ($item["realname"]); ?></span></td>
                <td class="valid_show">
                    <?php if(is_array($yesno)): foreach($yesno as $key=>$itemY): if(($itemY["value"]) == $item['valid']): ?><span name="valid"><?php echo ($itemY["key"]); ?></span><?php endif; endforeach; endif; ?>
                </td>
                <?php $power=checkPower("AdminEdit,AdminPsw,AdminDel"); if(($power) == "1"): ?><td>
                        <?php $power=checkPower("AdminEdit"); if(($power) == "1"): ?><a href="<?php echo U('Admin/edit',array('aid'=>$item['aid']));?>" class="tablelink">编辑</a> &nbsp;|&nbsp;<?php endif; ?>
                        <?php $power=checkPower("AdminPsw"); if(($power) == "1"): ?><a href="<?php echo U('Admin/psw',array('aid'=>$item['aid']));?>" class="tablelink">重置密码</a> &nbsp;|&nbsp;<?php endif; ?>
                        <?php $power=checkPower("AdminDel"); if(($power) == "1"): ?><a class="delBtn tablelink" href="<?php echo U('Admin/doDel',array('ids'=>$item['aid']));?>"
                               del_title="<?php echo ($item["name"]); ?>">删除</a><?php endif; ?>
                    </td><?php endif; ?>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>

    <div class="pagin">
        <?php echo ($pages); ?>
    </div>

</div>

<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>
<?php $power=checkPower("AdminEdit"); if(($power) == "1"): ?><script type="text/javascript">
        var yc_url = "<?php echo U('AdminBase/quickEdit');?>";
        var table = "admin";
    </script>
    <script src="/phpstorehouse/Public/Admin/js/yc_edit.js"></script><?php endif; ?>
</body>

</html>