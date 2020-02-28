<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=is0ThnOIy9pCjzRU6mmYhrBp"></script>
		<script type="text/javascript">
			var lngDefault=<?php echo ($lng); ?>;
			var latDefault=<?php echo ($lat); ?>;
			var map,localSearch,mark;

			function init() {
				map = new BMap.Map("container", {enableMapClick:false});
			    // map.centerAndZoom("25.051957", 16);
			    map.centerAndZoom(new BMap.Point(lngDefault, latDefault), 14);
			    map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
			    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
			    map.addControl(new BMap.ScaleControl());
			    mark = new BMap.Marker(new BMap.Point(lngDefault, latDefault));  // 创建标注，为要查询的地方对应的经纬度
				map.addOverlay(mark);	// 添加标示
				mark.enableDragging();
			    mark.addEventListener("dragging",function(){
			    	var p = mark.getPosition();       //获取marker的位置
			        document.getElementById("lng").value = p.lng;
			        document.getElementById("lat").value = p.lat;
			    });
			    map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
			    localSearch = new BMap.LocalSearch(map);
			    localSearch.enableAutoViewport(); //允许自动调节窗体大小			    
				map.addEventListener("click", mapClick);
				map.panTo(new BMap.Point(lngDefault, latDefault));
			}
			function mapClick(e){
//				alert(e.point.lng + ", " + e.point.lat);
				mark.setPosition(new BMap.Point(e.point.lng,e.point.lat));
				document.getElementById("lng").value = e.point.lng;
			        document.getElementById("lat").value = e.point.lat;
			}
		   
		    function searchByStationName() {
		        map.clearOverlays();//清空原来的标注
		        var keyword = document.getElementById("address").value;
		        localSearch.setSearchCompleteCallback(function (searchResult) {
		            var poi = searchResult.getPoi(0);
		            document.getElementById("lng").value = poi.point.lng;
		            document.getElementById("lat").value = poi.point.lat;
		            map.centerAndZoom(poi.point, 14);
		            var marker = new BMap.Marker(new BMap.Point(poi.point.lng, poi.point.lat));  // 创建标注，为要查询的地方对应的经纬度
		            map.addOverlay(marker);
		            marker.enableDragging();
		            marker.addEventListener("dragging",function(){
				    	var p = marker.getPosition();       //获取marker的位置
				        document.getElementById("lng").value = p.lng;
				        document.getElementById("lat").value = p.lat;
				    });
		        });
		        localSearch.search(keyword);
		    } 
		    $(function() {
				init();
				$("#container").height($(window).height()-37);
				//查询地址
				$("#mapform").submit(function() {
					searchByStationName();
					return false;
				});
				//点击确定
				$("#yesBtn").click(function() {
					
					window.parent.setLngLat($("#lng").val(),$("#lat").val());
				});
			});
		</script>
		<div class="map_body">
			<div style="width:100%;height:98%;position: absolute;top:37px" id="container"></div>
			<div style="position: absolute;width: 100%;background: #fff;">
				<div class="map_form p5 tl w300 fl ">
					<form id="mapform">
						<input type="text" placeholder="请输入地名,如韶关市第一中学" class="w200 inp bds" value="" id="address" />
						<input type="submit" id="submit" value="查询" class="inp" />
					</form>
				</div>
				<div class="map_form p5 tr w400 fr ">
					经度：
					<input type="text" class="w80 inp bds" id="lng" value="<?php echo ($lng); ?>" /> 纬度：
					<input type="text" class="w80 inp bds" id="lat" value="<?php echo ($lat); ?>" />
					<input type="button" id="yesBtn" value="确定并退出" class="inp" />
				</div>
			</div>

		</div>

	</body>

</html>