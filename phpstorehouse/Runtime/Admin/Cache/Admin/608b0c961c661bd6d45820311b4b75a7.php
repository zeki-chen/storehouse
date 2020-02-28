<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo ((isset($title) && ($title !== ""))?($title):$sysInfo['sys_name']); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/storehouse/Public/Admin/css/yc_edit.css"/>
<link href="/storehouse/Public/Common/css/common_yckj.css" rel="stylesheet" type="text/css" />
<link href="/storehouse/Public/Common/css/iconfont.css" rel="stylesheet" type="text/css" />
<link href="/storehouse/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/storehouse/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<link href="/storehouse/Public/Admin/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/storehouse/Public/Validform_v5.3.2/css/validform.css" rel="stylesheet" />
<link href="/storehouse/Public/layer-v3.0.1/layer/skin/default/layer.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="/storehouse/Public/webuploader-0.1.5/webuploader.css" />


<script language="JavaScript" src="/storehouse/Public/Common/js/jquery-1.8.3.min.js"></script>
<script src="/storehouse/Public/Validform_v5.3.2/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="/storehouse/Public/webuploader-0.1.5/webuploader.js"></script>

<!--kindeditor-->
<link rel="stylesheet" href="/storehouse/Public/kindeditor/themes/default/default.css" />
<script src="/storehouse/Public/kindeditor/kindeditor-min.js"></script>
<script src="/storehouse/Public/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/storehouse/Public/layer-v3.0.1/layer/layer.js"></script>


<script src="/storehouse/Public/My97DatePicker/WdatePicker.js"></script>
<script src="/storehouse/Public/Admin/js/select2.full.min.js"></script>
<script type="text/javascript" src="/storehouse/Public/Admin/js/jquery.idTabs.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/storehouse/Public/ueditor1_4_3/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/storehouse/Public/ueditor1_4_3/ueditor.all.min.js"></script>


<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="/storehouse/Public/ueditor1_4_3/lang/zh-cn/zh-cn.js"></script>


<script language="JavaScript" src="/storehouse/Public/Admin/js/common.js"></script>
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
				uploadJson: '/storehouse/Public/kindeditor/php/upload_json_media.php'
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
<div class="p10">
    <form class="mainform" role="form" method="post" action="<?php echo U('Goods/doEdit');?>">
        <input type="hidden" name="go_id" value="<?php echo ($model["go_id"]); ?>" />
        
<div class="     ">
    <div class="formtitle ">
        <span>商品信息</span>
        <div class="slideup slideup_sub" tabid="tabid1"></div>
    </div>
    <div class="tab mt10" id="tabid1">
        <table class="formtable ">
            <tbody>
            <tr id="" class="" ><td class="ft_title">商品中文名</td><td colspan="3"><input value="<?php echo ($model["go_name"]); ?>" name="go_name" type="text"   maxlength="6"    id="_input"   datatype="*"   class="bds inp  w100" nullmsg="请填写商品中文名"  placeholder="请填写商品中文名"/><font class="need show_0"> * </font><span class="Validform_checktip">请填写商品中文名</span></td></tr>
            <tr id="" class="" ><td class="ft_title">商品英文名</td><td colspan="3"><input value="<?php echo ($model["go_engname"]); ?>" name="go_engname" type="text"   maxlength="6"    id="_input"   datatype="*"   class="bds inp  w100" nullmsg="请填写商品英文名"  placeholder="请填写商品英文名"/><font class="need show_0"> * </font><span class="Validform_checktip">请填写商品英文名</span></td></tr>
            <tr id="" class="" ><td class="ft_title">商品规格</td><td colspan="3"><input value="<?php echo ($model["go_size"]); ?>" name="go_size" type="text"   maxlength="6"    id="_input"   datatype="*"   class="bds inp  w100" nullmsg="请填写商品规格,如：瓶，个"  placeholder="请填写商品规格,如：瓶，个"/><font class="need show_0"> * </font><span class="Validform_checktip">请填写商品规格,如：瓶，个</span></td></tr>
            <tr id="" class="" ><td class="ft_title">商品单价</td><td colspan="3"><input value="<?php echo ($model["go_price"]); ?>" name="go_price" type="text"   maxlength="6"    id="_input"   datatype="*"   class="bds inp  w100" nullmsg="商品单价，单位：元"  placeholder="商品单价，单位：元"/><font class="need show_0"> * </font><span class="Validform_checktip">商品单价，单位：元</span></td></tr>
            <tr>
              <td class="ft_title">经销商</td>
              <td><select name="ma_id">
                            <?php if(is_array($manufacturer)): foreach($manufacturer as $key=>$vo): if($model["ma_id"] == $vo['ma_id']): ?><option value="<?php echo ($vo["ma_id"]); ?>" selected="selected"><?php echo ($vo["ma_name"]); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo ($vo["ma_id"]); ?>"><?php echo ($vo["ma_name"]); ?></option><?php endif; endforeach; endif; ?>
                        </select></td>
                      </tr>
            <tr>
                <td class="ft_title">图片</td>
                <td>
                    <div class="uploaderPic"><div class="uploader-list" id="pic"><?php if(is_array($model['go_picture'])): foreach($model['go_picture'] as $k=>$vo): ?><div id="" class="item"><img src="<?php echo img_filled($vo['path'],100,100);?>" width="100" height="100"><span class="info"><?php echo ($vo["name"]); ?></span><div class="picTool"><span class="iconfont delPic">&#xe60a;</span></div><span class="success"></span><input type="hidden" name="go_picture[<?php echo ($k); ?>][path]" value="<?php echo ($vo["path"]); ?>"><input type="hidden" name="go_picture[<?php echo ($k); ?>][name]" value="<?php echo ($vo["name"]); ?>"></div><?php endforeach; endif; ?></div><div class="picAdd div_addbtn"><div id="picbtn"></div></div><div class="countTip"></div><input type="text" style="width:1px;height:1px;display:inline" value="0" datatype="null" nullmsg="请上传照片" errormsg="请上传照片"/><div class="tips"></div></div><script type="text/javascript">var uploadswf="/storehouse/Public/webuploader-0.1.5/Uploader.swf";var uploadphp="/storehouse/admin.php/Webuploader/upload.html";</script><script type="text/javascript" src="/storehouse/Public/Admin/js/webUploadPicYcF.v2.js"></script><script type="text/javascript">var upload=new ycUploadPic({"1":"go_picture","inputName":"go_picture","sumsize":"2","pick_id":"#picbtn","id":"#pic","singlesize":"2","count":"1","compress":"0"});</script>
                </td>
            </tr>

      

            <tr>
                <td></td>
                <td colspan="3">

                    <input type="hidden" name="updatetime" value="<?php echo time();?>" />
                    <input type="submit" value="保存" class="btn button_primary btnsave" status="0">
                    <input type="button" value="返回" class="btn button_success btnsave" onclick="javascript:history.go(-1)" />
                </td>
            </tr>

            </tbody>
        </table>
    </div>

    <div class="h10"></div>
</div>

    </form>
    <!--导入validform-->
    <script>
	var validForm = null
	var flag = false;
	$(function() {

		if($("#content").size()){
			$(window).bind('beforeunload',function(){
				return '您输入的内容尚未保存，确定离开此页面吗？';
			});
		}

		validForm = $(".mainform").Validform({
			tiptype: 4,
			datatype: {
                "null":function(gets,obj,curform){
                    return true;
                },
                "dz":/^-?([1-9]+(\.(\d*)|0)?)|(0(\.\d+){1})$/, //经纬度验证
				"nz": /^[1-9]\d*$/,//正整数
				"zs": /^([1-9]\d*\.\d*|0\.\d+|[1-9]\d*|0)$/, //正数
				"wz":/(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?/,//网址
				"ip":/((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?)/,  //ip
                "idcard":/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/,//身份证号码
                "checkName":function(gets,obj,curform){
                    var aname = gets;
                    var url_check = "<?php echo U('Admin/checkName');?>";
                    $.ajax({
                        data:{'aname':aname},
                        type:"POST",
                        url:url_check,
                        async:false,
                        datatype:'json',
                        success:function(data){
                            if(data.status==1){
                                flag = true;
                            }else{
                                flag = false;
                            }
                        }
                    });
                    return flag;
                },
                "cj":function(gets,obj,curform){
                    var score = gets;
                    if(score>100){
                        return false;
                    }
                },
 				"file":function(gets,obj,curform){
 					var fileCount=gets;
 					if(fileCount<=0)
 						return false;
 				}
			//注意return可以返回true 或 false 或 字符串文字，true表示验证通过，返回字符串表示验证失败，字符串作为错误提示显示，返回false则用errmsg或默认的错误提示;
			},
			ignoreHidden: ignoreHid,
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
				}
				if (data.url) {
					//loading("正在提交");
					$(window).unbind('beforeunload');
					loading(data.info + ",跳转中...");
					hrefTo(data.url, 500)
				}
			}
		});
	});
</script>
</div>
</body>
</html>