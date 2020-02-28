<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo ((isset($title) && ($title !== ""))?($title):$sysInfo['sys_name']); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/xfzz/web/Public/Admin/css/yc_edit.css"/>
<link href="/xfzz/web/Public/Common/css/common_yckj.css" rel="stylesheet" type="text/css" />
<link href="/xfzz/web/Public/Common/css/iconfont.css" rel="stylesheet" type="text/css" />
<link href="/xfzz/web/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/xfzz/web/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<link href="/xfzz/web/Public/Admin/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/xfzz/web/Public/Validform_v5.3.2/css/validform.css" rel="stylesheet" />
<link href="/xfzz/web/Public/layer-v3.0.1/layer/skin/default/layer.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="/xfzz/web/Public/webuploader-0.1.5/webuploader.css" />


<script language="JavaScript" src="/xfzz/web/Public/Common/js/jquery-1.8.3.min.js"></script>
<script src="/xfzz/web/Public/Validform_v5.3.2/js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="/xfzz/web/Public/webuploader-0.1.5/webuploader.js"></script>

<!--kindeditor-->
<link rel="stylesheet" href="/xfzz/web/Public/kindeditor/themes/default/default.css" />
<script src="/xfzz/web/Public/kindeditor/kindeditor-min.js"></script>
<script src="/xfzz/web/Public/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/xfzz/web/Public/layer-v3.0.1/layer/layer.js"></script>


<script src="/xfzz/web/Public/My97DatePicker/WdatePicker.js"></script>
<script src="/xfzz/web/Public/Admin/js/select2.full.min.js"></script>
<script type="text/javascript" src="/xfzz/web/Public/Admin/js/jquery.idTabs.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/xfzz/web/Public/ueditor1_4_3/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/xfzz/web/Public/ueditor1_4_3/ueditor.all.min.js"></script>


<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="/xfzz/web/Public/ueditor1_4_3/lang/zh-cn/zh-cn.js"></script>


<script language="JavaScript" src="/xfzz/web/Public/Admin/js/common.js"></script>
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
				uploadJson: '/xfzz/web/Public/kindeditor/php/upload_json_media.php'
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
    <form class="mainform" method="post" action="<?php echo U('Art/doAdd',array('model_id'=>$model_id));?>">
        <input type="hidden" name="model_id" value="<?php echo ($model_id); ?>"/>
        <input type="hidden" name="addtime" value="<?php echo time();?>" />
        
<!-- <link rel="stylesheet" type="text/css" href="/xfzz/web/Public/webuploader-0.1.5/webuploader.css" /> -->
<!-- <script type="text/javascript" src="/xfzz/web/Public/webuploader-0.1.5/webuploader.js"></script> -->
<div class="     ">
<div class="formtitle ">
        <span><?php echo ($config['model_name']); ?>信息</span>
        <div class="slideup slideup_sub" tabid="tabid1"></div>
    </div>
    <div class="tab mt10" id="tabid1">
        <!--基本信息-->
        <table class="formtable" id="basicinfo">
            <tbody>
            <tr id="" class="" ><td class="ft_title">文章标题</td><td colspan="3"><input value="<?php echo ($model["title"]); ?>" name="title" type="text"   id="_input"   datatype="*"   class="bds inp  w300" nullmsg="请填写文章标题"  placeholder="请填写文章标题"/><font class="need show_0"> * </font><span class="Validform_checktip">请填写文章标题</span></td></tr>
            <?php if(($config['art_class']) == "1"): ?><tr id="" class="" ><td class="ft_title">分类</td><td colspan="3"><select name="cid"  class="ycSec inp bds  " nullmsg="请选择分类"   id="_input"   datatype="*"  val="<?php echo ($model["cid"]); ?>" ><option value="">请选择</option><?php if(is_array($classList)): foreach($classList as $key=>$item): ?><option value="<?php echo ($item["value"]); ?>" <?php if(($model["cid"]) == $item['value']): ?>selected="selected"<?php endif; ?> ><?php echo ($item["key"]); ?></option><?php endforeach; endif; ?>	</select><font class="need show_0"> * </font><span class="Validform_checktip">请选择分类</span></td></tr><?php endif; ?>
            <?php if(is_array($field)): foreach($field as $key=>$item): switch($item['type']): case "0": ?><tr id="" class="" ><td class="ft_title"><?php echo ($item['field_name']); ?></td><td colspan="3"><input value="<?php echo ($model[$item['code']]); ?>" name="<?php echo ($item['code']); ?>" type="text"   id="_input"   datatype="<?php echo ($item['datatype']); ?>"   class="bds inp  <?php echo ($item['css']); ?>" nullmsg="请填写<?php echo ($item['field_name']); ?>"  placeholder="请填写<?php echo ($item['field_name']); ?>"/><font class="need show_0"> <?php echo ($item['need']); ?> </font><span class="Validform_checktip">请填写<?php echo ($item['field_name']); ?></span></td></tr><?php break;?>
                    <!--类型1 多行文本框-->
                    <?php case "1": ?><tr id="" class="" ><td class="ft_title"><?php echo ($item['field_name']); ?></td><td colspan="3"><textarea  name="<?php echo ($item['code']); ?>" type="text"    placeholder="请填写<?php echo ($item['field_name']); ?>" maxlength="250"   id="_input"   datatype="<?php echo ($item['datatype']); ?>"   class="bds inp  <?php echo ($item['css']); ?>" nullmsg="请填写<?php echo ($item['field_name']); ?>"  ><?php echo ($model[$item['code']]); ?></textarea><font class="need show_0"> <?php echo ($item['need']); ?> </font><span class="Validform_checktip">请填写<?php echo ($item['field_name']); ?></span></td></tr><?php break;?>
                    <?php case "2": break;?>
                    <!--类型3 文本编辑器-->
                    <?php case "3": ?><tr id="contenttr" class="" ><td class="ft_title"><?php echo ($item['field_name']); ?></td><td colspan="3"><textarea id="content"   type="text/plain"  name="<?php echo ($item['code']); ?>" class="<?php echo ($item['css']); ?>"    style="height:300px"  ><?php echo ($model[$item['code']]); ?></textarea><font class="need show_0"> <?php echo ($item['need']); ?> </font><span class="Validform_checktip">请填写<?php echo ($item['field_name']); ?></span><script>var ue = UE.getEditor("content", {initialFrameWidth: $(window).width() - 200});</script></td></tr><?php break;?>
                    <!--类型4 时间选择框-->
                    <?php case "4": ?><tr id="" class="" ><td class="ft_title"><?php echo ($item['field_name']); ?></td><td colspan="3"><input value="<?php echo (date('Y-m-d',$model[$item['code']])); ?>" name="<?php echo ($item['code']); ?>" type="text"   id="_input"    onclick="WdatePicker()"   datatype="<?php echo ($item['datatype']); ?>"   class="bds inp  w100 Wdate" nullmsg="请填写<?php echo ($item['field_name']); ?>"  placeholder="请填写<?php echo ($item['field_name']); ?>"/><font class="need show_0"> <?php echo ($item['need']); ?> </font><span class="Validform_checktip">请填写<?php echo ($item['field_name']); ?></span></td></tr><?php break;?>
                    <!--类型5 单选按钮-->
                    <?php case "5": ?><tr id="" class="" ><td class="ft_title"><?php echo ($item['field_name']); ?></td><td colspan="3"><?php if(is_array($yesno)): foreach($yesno as $key=>$vo): ?><label class="radio-inline"><input type="radio" name="<?php echo ($item["code"]); ?>" value="<?php echo ($vo["value"]); ?>"   class="ycRadio  "   val="<?php echo ($vo["value"]); ?>" <?php if( (key+1) == count($yesno)): ?>datatype="<?php echo ($item['datatype']); ?>"<?php endif; if(((isset($model[$item['code']]) && ($model[$item['code']] !== ""))?($model[$item['code']]):1) == $vo['value']): ?>checked="checked"<?php endif; ?> /><?php echo ($vo["key"]); ?> </label><?php endforeach; endif; ?><font class="need show_0"> <?php echo ($item['need']); ?> </font><span class="Validform_checktip">请选择<?php echo ($item['field_name']); ?></span></td></tr><?php break;?>
                    <!-- 类型6 图片上传 -->
                    <?php case "6": ?><tr>
                            <td class="ft_title"><?php echo ($item["field_name"]); ?></td>
                            <td>
                                <div class="uploaderPic"><div class="uploader-list" id="<?php echo ($item['code']); ?>"><?php if(is_array($model[$item['code']])): foreach($model[$item['code']] as $k=>$vo): ?><div id="" class="item"><img src="<?php echo ($vo['path']); ?>" width="100" height="100"><span class="info"><?php echo ($vo["name"]); ?></span><div class="picTool"><span class="iconfont delPic">&#xe60a;</span></div><span class="success"></span><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][path]" value="<?php echo ($vo["path"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][name]" value="<?php echo ($vo["name"]); ?>"></div><?php endforeach; endif; ?></div><div class="picAdd div_addbtn"><div id="<?php echo ($item['code']); ?>btn"></div></div><div class="countTip"></div><input type="text" style="width:1px;height:1px;display:inline" value="0" datatype="<?php echo ($item['datatype']); ?>" nullmsg="请上传<?php echo ($item["field_name"]); ?>" errormsg="请上传<?php echo ($item["field_name"]); ?>"/><div class="tips"><?php echo ($item['tips']); ?></div></div><script type="text/javascript">var uploadswf="/xfzz/web/Public/webuploader-0.1.5/Uploader.swf";var uploadphp="/xfzz/web/admin.php/Webuploader/upload.html";</script><script type="text/javascript" src="/xfzz/web/Public/Admin/js/webUploadPicYcF.v2.js"></script><script type="text/javascript">var upload=new ycUploadPic({"1":"{$item['code']}","inputName":"<?php echo ($item['code']); ?>","sumsize":"<?php echo ($item['sumsize']); ?>","pick_id":"#<?php echo ($item['code']); ?>btn","id":"#<?php echo ($item['code']); ?>","singlesize":"<?php echo ($item['singlesize']); ?>","count":"<?php echo ($item['count']); ?>","compress":"<?php echo ($item['compress']); ?>"});</script>
                            </td>
                        </tr><?php break;?>
                    <!-- 类型7 文件上传 -->
                    <?php case "7": ?><tr>
                            <td class="ft_title"><?php echo ($item["field_name"]); ?></td>
                            <td>
                                <div class="uploaderFile"><div class="uploader-list" id="<?php echo ($item['code']); ?>"><?php if(is_array($model[$item['code']])): foreach($model[$item['code']] as $k=>$vo): ?><div class="item"><i class="iconfont">&#xe6cc;</i><span class="info">&nbsp;<?php echo ($vo["name"]); ?></span><a href="javascript:void(0);" class="remove">删除</a><p class="state"></p><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][path]" value="<?php echo ($vo["path"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][name]" value="<?php echo ($vo["name"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][fileName]" value="<?php echo ($vo["fileName"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][ext]" value="<?php echo ($vo["ext"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][size]" value="<?php echo ($vo["size"]); ?>"></div><?php endforeach; endif; ?></div><div id="fileCountTip"></div><div class="btns"><div id="<?php echo ($item['code']); ?>btn" style="display: inline;">选择文件</div><input type="text" style="width:1px;height:1px;display:block" value="0" datatype="<?php echo ($item['datatype']); ?>" nullmsg="请上传<?php echo ($item["field_name"]); ?>" errormsg="请上传<?php echo ($item["field_name"]); ?>"/><div class="tips"><?php echo ($item['tips']); ?></div></div></div><script type="text/javascript">var uploadswf="/xfzz/web/Public/webuploader-0.1.5/Uploader.swf";var uploadphp="/xfzz/web/admin.php/Webuploader/upload.html";</script><script type="text/javascript" src="/xfzz/web/Public/Admin/js/webUploadFileYcF.v2.js"></script><script type="text/javascript">var upload=new ycUploadFile({"1":"{$item['sumsize']}","sumsize":"<?php echo ($item['sumsize']); ?>","inputName":"<?php echo ($item['code']); ?>","pick_id":"#<?php echo ($item['code']); ?>btn","id":"#<?php echo ($item['code']); ?>","singlesize":"<?php echo ($item['singlesize']); ?>","count":"<?php echo ($item['count']); ?>","extensions":""});</script>
                            </td>
                        </tr><?php break;?>
                    <!-- 类型8 视频上传 -->
                    <?php case "8": ?><tr>
                            <td class="ft_title">视频类型</td>
                            <td>
                                <label class="radio-inline"><input type="radio" name="video_type" value="0" class="ycRadio" <?php if(((isset($model['video_type']) && ($model['video_type'] !== ""))?($model['video_type']):0) == "0"): ?>checked<?php endif; ?>>网络视频</label>
                                <label class="radio-inline"><input type="radio" name="video_type" value="1" class="ycRadio" <?php if(($model['video_type']) == "1"): ?>checked<?php endif; ?>>本地上传</label>
                            </td>
                        </tr>
                        <tr id="online_video" style="display: none;">
                            <td class="ft_title">视频链接地址</td>
                            <td>
                                <textarea type="text" name="<?php echo ($item['code']); ?>" class="bds inp  w300 h100" errormsg="请填写视频链接地址" nullmsg="请填写视频链接地址" placeholder="请填写视频链接地址"><?php echo ($model['video']); ?></textarea>
                                <span class="Validform_checktip">请填写视频链接地址</span>
                            </td>
                        </tr>
                        <tr id="outline_video" style="display: none;">
                            <td class="ft_title">本地上传视频</td>
                            <td>
                                <div class="uploaderFile"><div class="uploader-list" id="<?php echo ($item['code']); ?>"><?php if(is_array($model[$item['code']])): foreach($model[$item['code']] as $k=>$vo): ?><div class="item"><i class="iconfont">&#xe6cc;</i><span class="info">&nbsp;<?php echo ($vo["name"]); ?></span><a href="javascript:void(0);" class="remove">删除</a><p class="state"></p><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][path]" value="<?php echo ($vo["path"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][name]" value="<?php echo ($vo["name"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][fileName]" value="<?php echo ($vo["fileName"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][ext]" value="<?php echo ($vo["ext"]); ?>"><input type="hidden" name="<?php echo ($item['code']); ?>[<?php echo ($k); ?>][size]" value="<?php echo ($vo["size"]); ?>"></div><?php endforeach; endif; ?></div><div id="fileCountTip"></div><div class="btns"><div id="<?php echo ($item['code']); ?>btn" style="display: inline;">选择文件</div><input type="text" style="width:1px;height:1px;display:block" value="0" datatype="<?php echo ($item['datatype']); ?>" nullmsg="请上传本地视频" errormsg="请上传本地视频"/><div class="tips"><?php echo ($item['tips']); ?></div></div></div><script type="text/javascript">var uploadswf="/xfzz/web/Public/webuploader-0.1.5/Uploader.swf";var uploadphp="/xfzz/web/admin.php/Webuploader/upload.html";</script><script type="text/javascript" src="/xfzz/web/Public/Admin/js/webUploadFileYcF.v2.js"></script><script type="text/javascript">var upload=new ycUploadFile({"1":"{$item['sumsize']}","sumsize":"<?php echo ($item['sumsize']); ?>","inputName":"<?php echo ($item['code']); ?>","pick_id":"#<?php echo ($item['code']); ?>btn","id":"#<?php echo ($item['code']); ?>","singlesize":"<?php echo ($item['singlesize']); ?>","count":"<?php echo ($item['count']); ?>","extensions":"mp4,flv"});</script>
                            </td>
                        </tr>
                        <script>
                            $(function(){
                                var video_type=<?php echo ((isset($model['video_type']) && ($model['video_type'] !== ""))?($model['video_type']):0); ?>;
                                if(video_type==0){
                                    $("#online_video").css('display','');
                                    $("#online_video input").removeAttr('disabled');
                                }else if(video_type==1){
                                    $("#online_video textarea").val('');
                                    $("#outline_video").css('display','');
                                    $("#outline_video input").removeAttr('disabled');
                                }
                                $("input[name='video_type']").change(typeChange);
                            });

                            function typeChange(){
                                var type=$(this).val();
                                if(type==0){
                                    $("#online_video").css('display','');
                                    $("#online_video input").removeAttr('disabled');
                                    $("#outline_video").css('display','none');
                                    $("#outline_video input").attr('disabled','true');
                                }else if(type==1){
                                    $("#outline_video").css('display','');
                                    $("#outline_video input").removeAttr('disabled');
                                    $("#online_video").css('display','none');
                                    $("#online_video input").attr('disabled','true');
                                    new ycUploadFile({"1":"{$item['sumsize']}","sumsize":"<?php echo ($item['sumsize']); ?>","inputName":"<?php echo ($item['code']); ?>","pick_id":"#<?php echo ($item['code']); ?>btn","id":"#<?php echo ($item['code']); ?>","singlesize":"<?php echo ($item['singlesize']); ?>","count":"<?php echo ($item['count']); ?>","extensions":"mp4,flv"});
                                }
                            }
                        </script><?php break; endswitch; endforeach; endif; ?>

            <tr id="" class="" ><td class="ft_title">排序</td><td colspan="3"><input value="<?php echo ((isset($model["sort"]) && ($model["sort"] !== ""))?($model["sort"]):99); ?>" name="sort" type="text"   id="_input"   datatype="n"   class="bds inp  w80" nullmsg="请填写排序"  placeholder="请填写排序"/><font class="need show_0"> * </font><span class="Validform_checktip">请填写排序</span></td></tr>

            <tr id="" class="" ><td class="ft_title">是否显示</td><td colspan="3"><?php if(is_array($yesno)): foreach($yesno as $key=>$vo): ?><label class="radio-inline"><input type="radio" name="is_show" value="<?php echo ($vo["value"]); ?>"   class="ycRadio  "   val="<?php echo ($vo["value"]); ?>" <?php if( (key+1) == count($yesno)): ?>datatype="*"<?php endif; if(((isset($model["is_show"]) && ($model["is_show"] !== ""))?($model["is_show"]):1) == $vo['value']): ?>checked="checked"<?php endif; ?> /><?php echo ($vo["key"]); ?> </label><?php endforeach; endif; ?><font class="need show_0"> * </font><span class="Validform_checktip">请选择是否显示</span></td></tr>
            </tbody>
        </table>
        <!--基本信息-->

        <div class="formbtn">
            <input type="hidden" name="updatetime" value="<?php echo time();?>" />
            <input type="submit" value="保存" class="btn button_primary btnsave" status="0">
            <input type="button" value="返回" class="btn button_success btnsave" onclick="javascript:history.go(-1)" />
        </div>
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