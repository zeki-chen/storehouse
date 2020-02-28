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

  <script src="/phpstorehouse/Public/incubator-echarts-4.2.1/dist/echarts.min.js"></script>
  <script src="/phpstorehouse/Public/incubator-echarts-4.2.1/test/lib/esl.js"></script>
<script src="/phpstorehouse/Public/incubator-echarts-4.2.1/test/lib/config.js"></script>
<!-- <script src="/phpstorehouse/Public/incubator-echarts-4.2.1/test/lib/jquery.min.js"></script> -->
<script src="/phpstorehouse/Public/incubator-echarts-4.2.1/test/lib/facePrint.js"></script>
 <link rel="stylesheet" href="/phpstorehouse/Public/incubator-echarts-4.2.1/test/lib/reset.css">
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
<div class="mainindex">
	<div class="welinfo">
		<span><img src="/phpstorehouse/Public/Admin/images/sun.png" alt="天气" /></span>
		<b>您好，<?php echo ($admin["aname"]); ?>，欢迎使用<?php echo ($sysInfo["title"]); ?>后台管理系统</b>
	</div>
   <b>节点1近期情况：</b>

  <div id="sync" style="height:400px;"></div>
   <script>

            var echarts;
            var colorTool;
            var chart;
            var myChart;
            var groupCategories = [];
            var groupColors = [];
           
            var j=<?php echo ($jiedian); ?>;
             var axisData=new Array();
                for(var i in j)
               {axisData[i]=j[i]['time'];}
           //  echarts = ec;
            colorTool = echarts.color;
             chart = myChart = echarts.init(document.getElementById('sync'));

            var  option = {
                    dataZoom:[
                        {type:'slider',show:'true',xAxisIndex: [0, 1] },
                        {type:'inside',show:'true',xAxisIndex: [0, 1] },
                        {type:'inside',show:'true',xAxisIndex: [0, 1] }
                    ],
                    tooltip: {
                        trigger: 'axis'
                    },
                    toolbox: {
                        feature: {
                            dataView: {
                                show: true,
                                readOnly: false
                            },
                            restore: {
                                show: true
                            },
                            saveAsImage: {
                                show: true
                            }
                        }
                    },
                    grid: {
                        containLabel: true
                    },
                    legend: {
                        data: ['温度','湿度','光照']
                    },
                    xAxis: [{
                        type: 'category',
                        axisTick: {
                            alignWithLabel: true
                        },
                        data: axisData
                    },
                    {
                        type: 'category',
                        axisTick: {
                            alignWithLabel: true
                        },
                        data:axisData
                    },
                    {
                        type: 'category',
                        axisTick: {
                            alignWithLabel: true
                        },
                        data:axisData
                    }],
                    yAxis: [{
                        type: 'value',
                        name: '单位',
                        min: 0,
                        max: 500,
                        position: 'left'
                    }],
                    series: [{
                        name: '温度',
                        type: 'line',
                        stack: '总量',
                        label: {
                            normal: {
                                show: true,
                                position: 'top',
                            }
                        },
                        lineStyle: {
                            normal: {
                                width: 3,
                                shadowColor: 'rgba(0,0,0,0.4)',
                                shadowBlur: 10,
                                shadowOffsetY: 10
                            }
                        },
                        data: []
                    }, {
                        name: '湿度',
                        type: 'line',
                        yAxisIndex: 0,
                        xAxisIndex:1,
                        stack: '总量',
                        label: {
                            normal: {
                                show: true,
                                position: 'top'
                            }
                        },
                        data:  [
                        ]
                    },
                    {
                        name: '光照',
                        type: 'line',
                        yAxisIndex: 0,
                        xAxisIndex:1,
                        stack: '总量',
                        label: {
                            normal: {
                                show: true,
                                position: 'top'
                            }
                        },
                        data:  [
                        ]
                    }]
                };

                 for(var i in j)
               {
               option['series'][0]['data'][i]=[j[i]['time'],j[i]['wendu1']];
               option['series'][1]['data'][i]=[j[i]['time'],j[i]['shidu1']];
               option['series'][2]['data'][i]=[j[i]['time'],j[i]['guangzhao1']];
               }
                chart.setOption(option);

        </script>

</body>
</html>