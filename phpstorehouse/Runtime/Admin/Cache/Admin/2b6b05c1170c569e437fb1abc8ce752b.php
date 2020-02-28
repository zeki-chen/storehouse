<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>

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
    <form class="mainform" role="form" method="post" action="<?php echo U('config/doEdit');?>">
        <input type="hidden" name="code" value="<?php echo ($model["code"]); ?>" />
        <input type="hidden" name="support" value="韶关市宇宸信息科技有限公司">
        
        <div class="tab mt10" id="tabid1">
            <div class="itab">
                <ul>
                    <li><a href="#tab1" class="selected">基本信息</a></li>
                    <li><a href="#tab2" class=" ">联系我们</a></li>
                </ul>
            </div>

            <table class="formtable " id="tab1">
                <tbody>
                <tr id="" class="" ><td class="ft_title">站点名称</td><td colspan="3"><input value="<?php echo ($model["title"]); ?>" name="title" type="text"   maxlength="50"    id="_input"   datatype="*"   class="bds inp  w300" nullmsg="请填写站点名称（必填）"  placeholder="请填写站点名称（必填）"/><font class="need show_0"> * </font><span class="Validform_checktip">请填写站点名称（必填）</span></td></tr>

                <tr id="" class="" ><td class="ft_title">域名</td><td colspan="3"><input value="<?php echo ($model["domain"]); ?>" name="domain" type="text"   maxlength="50"    id="_input"    class="bds inp  w300" nullmsg="请填写域名，格式如tourdxs.com"  placeholder="请填写域名，格式如tourdxs.com"/><font class="need show_0">  </font><span class="Validform_checktip">请填写域名，格式如tourdxs.com</span></td></tr>

                <tr id="" class="" ><td class="ft_title">备案号</td><td colspan="3"><input value="<?php echo ($model["icp"]); ?>" name="icp" type="text"   maxlength="50"    id="_input"    class="bds inp  w200" nullmsg="请填写备案号"  placeholder="请填写备案号"/><font class="need show_0">  </font><span class="Validform_checktip">请填写备案号</span></td></tr>



                <tr>
                    <td class="ft_title">微信官网二维码</td>
                    <td>
                    <div class="uploaderPic"><div class="uploader-list" id="pic"><?php if(is_array($model["qrcode"])): foreach($model["qrcode"] as $k=>$vo): ?><div id="" class="item"><img src="<?php echo ($vo['path']); ?>" width="100" height="100"><span class="info"><?php echo ($vo["name"]); ?></span><div class="picTool"><span class="iconfont delPic">&#xe60a;</span></div><span class="success"></span><input type="hidden" name="qrcode[<?php echo ($k); ?>][path]" value="<?php echo ($vo["path"]); ?>"><input type="hidden" name="qrcode[<?php echo ($k); ?>][name]" value="<?php echo ($vo["name"]); ?>"></div><?php endforeach; endif; ?></div><div class="picAdd div_addbtn"><div id="picAdd"></div></div><div class="countTip"></div><input type="text" style="width:1px;height:1px;display:inline" value="0" datatype="file" nullmsg="" errormsg="请上传微信官网二维码"/><div class="tips"></div></div><script type="text/javascript">var uploadswf="/storehouse/Public/webuploader-0.1.5/Uploader.swf";var uploadphp="/storehouse/admin.php/Webuploader/upload.html";</script><script type="text/javascript" src="/storehouse/Public/Admin/js/webUploadPicYcF.v2.js"></script><script type="text/javascript">var upload=new ycUploadPic({"1":"qrcode","inputName":"qrcode","sumsize":"2","pick_id":"#picAdd","id":"#pic","singlesize":"2","count":"1","compress":null});</script>
                    </td>
                </tr>

                <tr>
                    <td class="ft_title">微博二维码</td>
                    <td>
                    <div class="uploaderPic"><div class="uploader-list" id="weibo"><?php if(is_array($model["weibo"])): foreach($model["weibo"] as $k=>$vo): ?><div id="" class="item"><img src="<?php echo ($vo['path']); ?>" width="100" height="100"><span class="info"><?php echo ($vo["name"]); ?></span><div class="picTool"><span class="iconfont delPic">&#xe60a;</span></div><span class="success"></span><input type="hidden" name="weibo[<?php echo ($k); ?>][path]" value="<?php echo ($vo["path"]); ?>"><input type="hidden" name="weibo[<?php echo ($k); ?>][name]" value="<?php echo ($vo["name"]); ?>"></div><?php endforeach; endif; ?></div><div class="picAdd div_addbtn"><div id="addweibo"></div></div><div class="countTip"></div><input type="text" style="width:1px;height:1px;display:inline" value="0" datatype="null" nullmsg="" errormsg=""/><div class="tips"></div></div><script type="text/javascript">var uploadswf="/storehouse/Public/webuploader-0.1.5/Uploader.swf";var uploadphp="/storehouse/admin.php/Webuploader/upload.html";</script><script type="text/javascript" src="/storehouse/Public/Admin/js/webUploadPicYcF.v2.js"></script><script type="text/javascript">var upload=new ycUploadPic({"1":"weibo","inputName":"weibo","sumsize":"2","pick_id":"#addweibo","id":"#weibo","singlesize":"2","count":"1","compress":null});</script>
                    </td>
                </tr>

                <tr id="" class="" ><td class="ft_title">版权信息</td><td colspan="3"><textarea  name="copyright" type="text"    placeholder="请填写版权信息" maxlength="250"   id="_input"    class="bds inp  w400 h60" nullmsg="请填写版权信息"  ><?php echo ($model["copyright"]); ?></textarea><font class="need show_0">  </font><span class="Validform_checktip">请填写版权信息</span></td></tr>

                <tr id="contenttr" class="" ><td class="ft_title">学校概况</td><td colspan="3"><textarea id="content"   type="text/plain"  name="about" class="pct100  bdn"    style="height:300px"  ><?php echo ($model["about"]); ?></textarea><font class="need show_0">  </font><span class="Validform_checktip">请填写信息</span><script>var ue = UE.getEditor("content", {initialFrameWidth: $(window).width() - 200});</script></td></tr>
                <tr>
                    <td></td>
                    <td colspan="3">

                        <input type="submit" value="保存" class="btn button_primary btnsave" status="0">
                        <input type="button" value="返回" class="btn button_success btnsave" onclick="javascript:history.go(-1)" />
                    </td>
                </tr>

                </tbody>
            </table>

            <table class="formtable" id="tab2" style="display: none">
                <tbody>

                <tr id="" class="" ><td class="ft_title">联系电话</td><td colspan="3"><input value="<?php echo ($model["tel"]); ?>" name="tel" type="text"   maxlength="15"    id="_input"    class="bds inp  w200" nullmsg="请填写电话号码"  placeholder="请填写电话号码"/><font class="need show_0">  </font><span class="Validform_checktip">请填写电话号码</span></td></tr>

                <tr id="" class="" ><td class="ft_title">地址</td><td colspan="3"><input value="<?php echo ($model["address"]); ?>" name="address" type="text"   maxlength="50"    id="_input"    class="bds inp  w300" nullmsg="请填写学校地址"  placeholder="请填写学校地址"/><font class="need show_0">  </font><span class="Validform_checktip">请填写学校地址</span></td></tr>

                <!--<tr id="" class="" ><td class="ft_title">邮编</td><td colspan="3"><input value="<?php echo ($model["postcode"]); ?>" name="postcode" type="text"   maxlength="6"    id="_input"    class="bds inp  w100" nullmsg="请填写邮编"  placeholder="请填写邮编"/><font class="need show_0">  </font><span class="Validform_checktip">请填写邮编</span></td></tr>-->

                <!--<tr id="" class="" ><td class="ft_title">邮箱地址</td><td colspan="3"><input value="<?php echo ($model["email"]); ?>" name="email" type="text"   maxlength="50"    id="_input"    class="bds inp  w200" nullmsg="请填写电子邮箱"  placeholder="请填写电子邮箱"/><font class="need show_0">  </font><span class="Validform_checktip">请填写电子邮箱</span></td></tr>-->

                <tr>
                    <td class="ft_title">
                        地址经纬度
                    </td>
                    <td>
                        经度:
                        <input name="lng" id="lng" readonly="readonly" value="<?php echo ((isset($model["lng"]) && ($model["lng"] !== ""))?($model["lng"]):0); ?>" type="text" class="bds inp w100" nullmsg="请填写经度" placeholder="经度" maxlength="250" datatype="dz" />
                        <font class="need show_0">*</font>
                        纬度:
                        <input name="lat" id="lat" readonly="readonly" value="<?php echo ((isset($model["lat"]) && ($model["lat"] !== ""))?($model["lat"]):0); ?>" type="text" class="bds inp w100" nullmsg="请填写纬度" placeholder="纬度" maxlength="250" datatype="dz" />
                        <font class="need show_0">*</font>
                        <span class="Validform_checktip">请填写地址经纬度</span>
                        <span class="p5 btn button_success mer_map_btn" id="lng_lat">修改经纬度</span>
                        <span class="grey" style="float: none">点击“修改经纬度”按钮进行修改</span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">

                        <input type="submit" value="保存" class="btn button_primary btnsave" status="0">
                        <input type="button" value="返回" class="btn button_success btnsave" onclick="javascript:history.go(-1)" />
                    </td>
                </tr>

                </tbody>
            </table>

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
<script src="/storehouse/Public/Admin/js/jquery.md5.js"></script>
<script type="text/javascript">
    var contentIsChange=0;
    var contentOrg=$("textarea[name='about']").val();
    var orgMd5=$.md5($("textarea[name='about']").val());
    ue.addListener('contentChange',function(){
        console.log('contentIsChange:'+contentIsChange);
        console.log("orgMd5:"+orgMd5);
        if(contentIsChange==0 ){
            var newMd5=$.md5($("textarea[name='about']").val());
            console.log("newMd5:"+newMd5);
            if(orgMd5!=newMd5){

                contentIsChange=1;
                $(window).bind('beforeunload',function(){
                    return '您输入的内容尚未保存，确定离开此页面吗？';
                });
            }
        }
    });
    $(function(){
        $(window).unbind('beforeunload');
    });
    $(function() {
        $(".itab").idTabs();
    });
    $(function() {
        $("#lng_lat").click(function() {
            mapbox("newMap");
        });
    });

    function mapbox(url) {
        var url = "<?php echo U('Public/map');?>";
        url += "?lng=" + $("#lng").val() + "&lat=" + $("#lat").val();
        layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.8,
            area: ['80%', '90%'],
            content: url
        });
        return;
    };

    function setLngLat(lng, lat) {
        $("#lng").val(lng);
        $("#lat").val(lat);
        layer.closeAll();
    }
</script>
</html>