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
					<li class="click">
						<a href="javascript:databack()">
							<span><img src="/phpstorehouse/Public/Admin/images/t01.png" /></span>备份</a>
					</li>
					<li class="click">
						<a href="javascript:delMut('<?php echo U("SysData/doDel");?>')">
							<span><img src="/phpstorehouse/Public/Admin/images/t03.png" /></span>删除</a>
					</li>
				</ul>

				<form action="<?php echo U('SysData/index');?>" method="get">
					<ul class="toolbar1">
						<li>关键词：
							<input type="text" name="keyword" class="scinput" placeholder="请输入关键词" value="<?php echo ($keyword); ?>" />
						</li>
						<li>
							<input type="submit" class="scbtn button_primary" value="查询" />
						</li>

					</ul>
				</form>

			</div>

			<table class="tablelist" id="exampletable">
				<thead>
					<tr>
						<th width="60">
							<label class="">
								<input type="checkbox" class="selectAll" />全选
							</label>
						</th>
						<th width="" class="tl">文件名</th>
						<th width="80">类型</th>
						<th width="80">大小</th>
						<th width="150" class="tc">创建时间</th>
						<th width="120">操作</th>
					</tr>
				</thead>
				<tbody id="tbody">
				</tbody>
			</table>

			<div class="pagin">
				<?php echo ($pages); ?>
			</div>

		</div>

		<script type="text/javascript">
			$('.tablelist tbody tr:odd').addClass('odd');

			function databack() {
				var url = "<?php echo U('SysData/doBak');?>";
				loading("备份中，请稍候...");
				$.get(url, function(data) {
					msgOK(data.info);
					hrefTo("<?php echo get_url();?>", 500);
				}, "json");
			}
			$(function() {
				$(".recBtn").click(function() {
					var url = $(this).attr("href");
					$(this).removeAttr("href");
					layer.confirm('确定要还原 ' + $(this).attr('del_title') + ' 吗？', {
						btn: ['确定', '取消'] //按钮
					}, function() {
						loading("正在还原...");
						$.get(url, function(data) {
							if (data.status == 1) {
								msgOK(data.info);
							} else {
								msgFaild(data.info);
							}
							if (data.url) {
								//loading("正在提交");
								loading(data.info + ",跳转中...");
								hrefTo(data.url, 500)
							}
						}, "json");
					}, function() {
						//取消时操作
					});
					$(this).attr("href", url);
					return false;
				});
			})
		</script>

        <script>
            //分页显示数据
            $(function(){
                $('.pagin a').live('click',pageClick);
            });
            var list=<?php echo ($list); ?>;
            var total_page=list.page;//总页数
            var data=list.data;//数据集合
            var page=1;//当前页数
            var pageSize=list.pageSize;//分页大小
            var count=list.count;//数据集数量

            if(count!=0){
                showPage(page,total_page);
                showData(page);
            }

            //构造分页
            function showPage(page,total_page){
                var Page='';//
                var now_cool_page=5.5;
                var ceil_now_cool_page=6;
                var pageHtml='<div>';//分页HTML
                if(total_page>11&&(page-now_cool_page)>=1){
                    pageHtml+='<a class="first" page="1" href="###1">1...</a>';
                }
                if(page>1){
                    pageHtml+='<a class="prev" page="'+(page-1)+'" href="###'+(page-1)+'">&lt;&lt;</a>';
                }
                for(var i=1;i<=11;i++){
                    if((page-now_cool_page)<=0){
                        Page=i;
                    }else if((parseFloat(page)+parseFloat(now_cool_page)-1)>total_page){
                        Page=total_page-11+i;
                    }else{
                        Page=page-ceil_now_cool_page+i;
                    }
                    if(Page>0&&Page!=page){
                        if(Page<=total_page){
                            pageHtml+='<a class="num" page="'+Page+'" href="###'+Page+'">' + Page + '</a>';
                        }else{
                            break;
                        }
                    }else{
                        if(Page>0&&total_page!=1){
                            pageHtml+='<span class="current">' + Page + '</span>'
                        }
                    }
                }
                if(page<total_page){
                    pageHtml+='<a class="next" page="'+(parseInt(page)+1)+'" href="###'+(parseInt(page)+1)+'">&gt;&gt;</a>'
                }
                if(page<total_page-now_cool_page){
                    pageHtml+='<a class="end" page="'+total_page+'" href="###'+total_page+'">'+total_page+'</a>'
                }
                pageHtml+='</div>';
//                console.log(pageHtml);
                $('.pagin').html(pageHtml);
            }

            //切换分页
            function pageClick(){
                loading('处理中...');
                page=$(this).attr('page');
                showPage(page,total_page);
                showData(page);
                layer.closeAll();
            }

            //显示数据
            function showData(page){
                var tbody=$('#tbody');
                tbody.html('');
                var start=(page-1)*pageSize;
                var end=page*pageSize-1;
                if(page==total_page){
                    end=count-1;
                }
                for(var i=start;i<=end;i++){
                    var html='';
                    html+='<tr>';
                    html+='<td><input type="checkbox" value="'+data[i]['url_path']+'" class="del_checkbox" /></td>';
                    html+='<td class="tl">'+data[i]['name']+'</td>';
                    html+='<td>'+data[i]['ext']+'</td>';
                    html+='<td>'+data[i]['size']+'</td>';
                    html+='<td>'+data[i]['addtime']+'</td>';
                    html+='<td><a href="'+data[i]['doRecovery']+'" class="recBtn tablelink" del_title="'+data[i]['name']+'"> 还原</a> &nbsp;|&nbsp;';
                    html+='<a href="'+data[i]['doDel']+'" class="delBtn tablelink" del_title="'+data[i]['name']+'"> 删除</a> </td>';
                    html+='</tr>';
                    tbody.append(html);
                }
            }
        </script>

	</body>

</html>