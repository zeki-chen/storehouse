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
    <form class="mainform" role="form" method="post" action="<?php echo U('Art/doCheck',array('model_id'=>$model_id));?>">
        <input type="hidden" name="model_id" value="<?php echo ($model_id); ?>"/>
        <input type="hidden" name="aid" value="<?php echo ($model["aid"]); ?>" />
        <input type="hidden" name="title" value="<?php echo ($model["title"]); ?>" />
        <input type="hidden" name="is_show" value="<?php echo ($model["is_show"]); ?>" />
        
        <div class="     ">
            <div class="formtitle ">
                <span>文章详情</span>
                <div class="slideup slideup_sub" tabid="tabid1"></div>
            </div>
            <div class="tab mt10" id="tabid1">
                <table class="formtable ">
                    <tbody>
                    <tr>
                        <td class="ft_title">文章标题</td>
                        <td><?php echo ($model["title"]); ?></td>
                    </tr>

                    <?php if(is_array($field)): foreach($field as $key=>$item): if($item['type'] == 6): ?><tr>
                                <td class="ft_title"><?php echo ($item["field_name"]); ?></td>
                                <td>
                                    <?php if(!empty($model[$item['code']])): if(is_array($model[$item['code']])): foreach($model[$item['code']] as $key=>$vo): ?><div id="" class="thumb" style="cursor: pointer;">
                                                <img src="<?php echo ($vo['path']); ?>" width="100" height="100">
                                                <span class="info"><?php echo ($vo['name']); ?></span>
                                            </div><?php endforeach; endif; ?>
                                        <?php else: ?>
                                        没有<?php echo ($item['field_name']); endif; ?>
                                </td>
                            </tr>
                        <?php elseif($item['type'] == 7): ?>
                            <tr>
                                <td class="ft_title"><?php echo ($item['field_name']); ?></td>
                                <td>
                                    <?php if(!empty($model[$item['code']])): if(is_array($model[$item['code']])): foreach($model[$item['code']] as $key=>$vo): ?><div style="margin: 10px;">
                                                <i class="iconfont">&#xe6cc;</i>
                                                <h4 class="info dis_inline"><?php echo ($vo["name"]); ?></h4>
                                                <a href="<?php echo ($vo["path"]); ?>" class="li_a ml15" download="<?php echo ($vo["name"]); ?>">下载</a>
                                            </div><?php endforeach; endif; ?>
                                        <?php else: ?>
                                        没有<?php echo ($item['field_name']); endif; ?>
                                </td>
                            </tr>
                        <?php elseif($item['type'] == 8): ?>
                            <tr>
                                <td class="ft_title"><?php echo ($item['field_name']); ?></td>
                                <td>
                                    <?php if(!empty($model[$item['code']])): ?><div style="display: inline-block;border: 1px solid #ccc;background-color: #f0f0f0;padding: 4px;">
                                        <?php if($model['video_type'] == 1): ?><!-- 本地视频 -->
                                            <script type="text/javascript" src="/xfzz/web/Public/flowplayer/flowplayer-3.2.13.min.js"></script>
                                            <a  href="<?php echo ($model[$item['code']]); ?>" style="display:block;width:520px;height:330px" id="player">
                                                <img src="/xfzz/web/Public/flowplayer/play_large.png" style="margin: 124px 0 0 219px">
                                            </a>
                                            <script>
                                                var flow=flowplayer("player", "/xfzz/web/Public/flowplayer/flowplayer-3.2.18.swf");
                                            </script> 
                                            <!-- 本地视频 -->
                                        <?php else: ?>
                                            <!-- 网络视频 -->
                                            <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="520" height="330">
                                                <param name="movie" value="<?php echo ($model[$item['code']]); ?>" />
                                                <param name="quality" value="high" />
                                                <param name="wmode" value="opaque" />
                                                <param name="swfversion" value="8.0.35.0" />
                                                <param value="true" name="allowFullScreen">
                                                <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
                                                <!-- <param name="expressinstall" value="../Scripts/expressInstall.swf" /> -->
                                                <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
                                                <!--[if !IE]>-->
                                                <object type="application/x-shockwave-flash" data="<?php echo ($model[$item['code']]); ?>" width="520"
                                                    height="330">
                                                    <!--<![endif]-->
                                                    <param name="quality" value="high" />
                                                    <param name="wmode" value="opaque" />
                                                    <param name="swfversion" value="8.0.35.0" />
                                                    <param value="true" name="allowFullScreen">
                                                    <!-- <param name="expressinstall" value="../Scripts/expressInstall.swf" /> -->
                                                    <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
                                                    <div>
                                                        <h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4>
                                                        <p>
                                                            <a href="http://www.adobe.com/go/getflashplayer">
                                                                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获取 Adobe Flash Player" width="112" height="33" />
                                                            </a>
                                                        </p>
                                                    </div>
                                                    <!--[if !IE]>-->
                                                </object>
                                                <!--<![endif]-->
                                            </object>
                                            <!-- 本地视频 --><?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        没有<?php echo ($item['field_name']); endif; ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td class="ft_title"><?php echo ($item['field_name']); ?></td>
                                <td>
                                    <?php if(empty($model[$item['code']])): ?>未填写
                                        <?php else: echo ($model[$item['code']]); endif; ?>
                                </td>
                            </tr><?php endif; endforeach; endif; ?>
                    <tr>
                        <td class="ft_title">排序</td>
                        <td><?php echo ($model['sort']); ?></td>
                    </tr>
                    <tr>
                        <td class="ft_title">是否显示</td>
                        <td>
                            <?php if(is_array($yesno)): foreach($yesno as $key=>$itemY): if(($itemY["value"]) == $model['is_show']): echo ($itemY["key"]); endif; endforeach; endif; ?>
                        </td>
                    </tr>
                    <?php if(($config['check']) == "1"): $power=checkPower("ArtCheck"); ?>
                        <?php if(($power) == "1"): ?><tr id="" class="" ><td class="ft_title">审核状态</td><td colspan="3"><?php if(is_array($art_status)): foreach($art_status as $key=>$vo): ?><label class="radio-inline"><input type="radio" name="is_check" value="<?php echo ($vo["value"]); ?>"   class="ycRadio  "   val="<?php echo ($vo["value"]); ?>" <?php if( (key+1) == count($art_status)): ?>datatype="*"<?php endif; if(((isset($model["is_check"]) && ($model["is_check"] !== ""))?($model["is_check"]):1) == $vo['value']): ?>checked="checked"<?php endif; ?> /><?php echo ($vo["key"]); ?> </label><?php endforeach; endif; ?><font class="need show_0"> * </font><span class="Validform_checktip"></span></td></tr>

                            <tr id="passinfo_tr" class="" ><td class="ft_title">备注</td><td colspan="3"><textarea  name="pass_info" type="text"    placeholder="请填写备注" maxlength="1000"   id="_input"   datatype="*"   class="bds inp  w500 h100" nullmsg="请填写备注"  ><?php echo ($model["pass_info"]); ?></textarea><font class="need show_0"> * </font><span class="Validform_checktip">请填写备注</span></td></tr>
                            <script type="text/javascript">
                                $(function(){
                                    var status=<?php echo ($model['is_check']); ?>;
                                    if(status!=2){
                                        $("#passinfo_tr").css('display','none');
                                    }
                                    $("input[name='is_check']").change(statusChange);
                                });

                                function statusChange(){
                                    var value=$(this).val();
                                    if(value==2){
                                        $("#passinfo_tr").css('display','');
                                    }else{
                                        $("#passinfo_tr").css('display','none');
                                    }
                                }
                            </script>
                        <?php else: ?>
                            <tr>
                                <td class="ft_title">审核状态</td>
                                <td>
                                    <?php if(is_array($art_status)): foreach($art_status as $key=>$itemY): if(($itemY["value"]) == $model['is_check']): echo ($itemY["key"]); endif; endforeach; endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="ft_title">备注</td>
                                <td><?php echo ($model["pass_info"]); ?></td>
                            </tr><?php endif; endif; ?>
                    <tr>
                        <td></td>
                        <td colspan="3">
                            <input type="hidden" name="updatetime" value="<?php echo time();?>" />
                            <?php if(($config['check']) == "1"): $power=checkPower("ArtCheck"); ?>
                                <?php if(($power) == "1"): ?><input type="submit" value="保存" class="btn button_primary btnsave" status="0"><?php endif; endif; ?>
                            <?php $power=checkPower("ArtEdit"); ?>
                            <?php if(($power) == "1"): ?><a href="<?php echo U('Art/edit',array('model_id'=>$model['model_id'],'aid'=>$model['aid']));?>" class="btn button_primary btnsave">编辑</a><?php endif; ?>
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
<script type="text/javascript">
    $(function(){
        $('.thumb').on('click',showphoto);
    })
    function showphoto(){
        var url=$(this).find('img').attr('src');
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            skin: 'yourclass',
            area: ['600px','450px'],
            content: '<img src="'+url+'" width="600" height="450" class="layui-layer-wrap">'
        });
    }
</script>
</html>