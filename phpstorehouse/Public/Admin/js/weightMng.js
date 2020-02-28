var map;
var marker;
var action = ""; //当前操作名称 addBeginEnd:添加权值；delBeginEnd：删除权值
var lastLatLng; //最后一次经纬度

var movingOrg = new Object();
var markerArr = new Array();
var markerObj = new Object();

//setBeginEnd 设置起点终点相关信息
var beginSpid = 0;

var beginMarker;
var polylineArr = new Array(); //polylineObj.id,polylineObj.line;

$(function() {
	setContainerHeight(135); //设置地图高度 
	loadMap(); //首次加载地图 
});



//首次加载地图 
function loadMap() {
	firstMap();
	map.addControl(new BMap.NavigationControl());
	map.setMinZoom(15);
	//加载景点
	len = spotList.length;

	for (var i = 0; i < len; i++) {
		var markerLng =spotList[i].lng_baidu;
		var markerLat =  spotList[i].lat_baidu;
		point = new BMap.Point(markerLng, markerLat);
		var iconImg = locationPng;
		
		
		var myIcon = new BMap.Icon(iconImg, new BMap.Size(70, 70));
		marker = new BMap.Marker(point, {
			icon: myIcon
		}); // 创建标注
		marker.setTitle(spotList[i].spid);
		map.addOverlay(marker); // 将标注添加到地图中
		
		var label = new BMap.Label(spotList[i].spname, {
			offset: new BMap.Size(20, -0)
		});
		label.setStyle({
			display: "none"
		});
		marker.setLabel(label);
		marker.addEventListener("mouseover", showLable);
		marker.addEventListener("mouseout", hideLable);
		markerObj = new Object();
		markerObj.marker = marker;
		markerObj.spid = spotList[i].spid;



		
		
		markerArr[spotList[i].spid] = markerObj;


	}
	console.log("---");
	console.log(markerArr);
	console.log("===");
	console.log(markerArr.length);

	var menu = new BMap.ContextMenu();
	menu.addItem(new BMap.MenuItem("添加景点", addSopt));
	//map.addContextMenu(menu);

	len = weightSpotList.length;
	for (var i = 0; i < len; i++) {
		var begin = new BMap.Point(weightSpotList[i].lng_baidu1, weightSpotList[i].lat_baidu1);
		var end = new BMap.Point(weightSpotList[i].lng_baidu2, weightSpotList[i].lat_baidu2);
		var polyline = new BMap.Polyline([
			begin,
			end
		], {
			strokeColor: "blue",
			strokeWeight: 2,
			strokeOpacity: 0.5
		});
		map.addOverlay(polyline); //增加折线
		//添加文字标签

		var lablePoint = new BMap.Point((parseFloat(weightSpotList[i].lng_baidu1) + parseFloat(weightSpotList[i].lng_baidu2)) / 2, (parseFloat(weightSpotList[i].lat_baidu1) + parseFloat(weightSpotList[i].lat_baidu2)) / 2);
		debug(lablePoint);
		var opts = {
			position: lablePoint, // 指定文本标注所在的地理位置
			offset: new BMap.Size(-15, -12) //设置文本偏移量
		}
		var label = new BMap.Label(weightSpotList[i].weight, opts); // 创建文本标注对象
		label.setStyle({
			color: "red",
			fontSize: "12px",
			height: "20px",
			lineHeight: "20px",
			fontFamily: "微软雅黑"
		});
		map.addOverlay(label);

		addPolylineArr(weightSpotList[i].begin_spid, weightSpotList[i].end_spid, polyline, label);
	}

	tips("地图加载完成");

}

//显示名称
function showLable(e, ee, marker1) {
	var lable = e.target.getLabel();
	lable.setStyle({
		display: "block"
	});
}
//隐藏名称
function hideLable(e, ee, marker1) {
	var lable = e.target.getLabel();
	lable.setStyle({
		display: "none"
	});
}

//移动位置 
function spotMoveStar(e, ee, marker1) {
	if (movingOrg.marker != null) {
		//恢复原样
		movingOrg.marker.setPosition(movingOrg.position);
		movingOrg.marker.setIcon(movingOrg.icon);
		movingOrg.marker.disableDragging();
		movingOrg.marker = null;
	}
	//获取当前按钮
	movingOrg.icon = marker1.getIcon();
	marker1.setIcon(new BMap.Icon(movingPng, new BMap.Size(32, 32)));
	movingOrg.marker = marker1;
	movingOrg.position = marker1.getPosition();
	marker1.enableDragging();

}
//结束移动
function spotMoveEnd(e, ee, marker1) {
	if (movingOrg.marker == null) {
		msgFaild("请先选择一个景点作为起点！");
		return false;
	}
	if (movingOrg.marker.getTitle() !== marker1.getTitle()) {
		msgFaild("请在当前移动的景点在右键选择结束移动位置！");
		return false;
	}
	var query = new Object();
	query.spid = marker1.getTitle();
	query.lng_baidu_move = marker1.getPosition().lng;
	query.lat_baidu_move = marker1.getPosition().lat;
	$.post(updateLngLatMoveUrl, query, function(data) {
		if (data.status == 1) {
			marker1.disableDragging(); //结束移动
			marker1.setIcon(movingOrg.icon)
				//画一条线段			
			var polyline = new BMap.Polyline([
				movingOrg.marker.getPosition(),
				marker1.getPosition()
			], {
				strokeColor: "#ccc",
				strokeWeight: 1,
				strokeOpacity: 0.5
			});
			map.addOverlay(polyline); //增加折线
			movingOrg.marker = null;
			window.location.reload();
			//			msgOK(data.info);
			//			window.location.reload();
		} else {
			msgFaild(data.info);
		}
	}, "json")

}

//取消
function spotCancle(e, ee, marker1) {
	//重置参数
	resetParam();
}
//重置参数
function resetParam() {
	//重置参数
	action = "";
	beginMarker.setAnimation(null);
	beginSpid = 0;
}

//添加景点
function addSopt(e, ee) {
	lastLatLng = e;
	debug(lastLatLng);
	//iframe层
	//alert("2014-03-22".replace(/-/g,''));
	var url = addSpotUrl;
	url = url.replace(/aalataa/, lastLatLng.lat);
	url = url.replace(/aalngaa/, lastLatLng.lng);
	layer.open({
		type: 2,
		title: '添加景点',
		shadeClose: true,
		shade: 0.8,
		area: ['80%', '90%'],
		content: url //iframe的url
	});
}
//修改景点
function editSpot(e, ee, marker1) {
	var p = marker1; // e.target;
	lastLatLng = p.getPosition();
	var url = editSpotUrl;
	url = url.replace(/aaspidaa/, p.getTitle());

	layer.open({
		type: 2,
		title: '修改景点',
		shadeClose: true,
		shade: 0.8,
		area: ['80%', '90%'],
		content: url //iframe的url
	});
}
//删除景点
function delSpot(e, ee, marker1) {
	var p = marker1; // e.target;
	if (confirm("确定要删除景点 " + marker1.getLabel().getContent() + " 吗？")) {
		var url = delSpotUrl;
		url = url.replace(/aaspidaa/, p.getTitle());
		$.get(url, function(data) {
			if (data.status == 1) {
				msgOK(data.info);
				window.location.reload();
			} else {
				msgFaild(data.info);
			}
		}, "json");
	}
}
//删除权值
function soptDblclick(e, ee, marker1) {
	debug("删除景点权值");
	action = "delBeginEnd";
	//e.domEvent.stopPropagation(); //阻止事件冒泡
	var p = marker1; // e.target;
	lastLatLng = p.getPosition();
	if (beginSpid == 0) { //如果是只点了一个点
		p.setAnimation(BMAP_ANIMATION_BOUNCE);
		beginMarker = p; //当前跳动的点
		bginLngLat = lastLatLng;
		beginSpid = p.getTitle();
		tips("请选择要删除的结束的景点");
	} else {
		if (beginSpid == p.getTitle()) {
			tips("两次点击的点不能是同一个！");
			msgFaild("两次点击的点不能是同一个！");
			return;
		}
		tips("删除权值");

		if (confirm("确定要删除权值吗？")) {
			var url = delWeight;
			url = url.replace(/aaspid1aa/, beginSpid);
			url = url.replace(/aaspid2aa/, p.getTitle());
			$.get(url, function(data) {
				if (data.status == 1) {
					msgOK(data.info);
					window.location.reload();
				} else {
					msgFaild(data.info);
				}
			}, "json");
		}
		//todo:设置权值
		//todo:在回调页删除一条线	
		delPolylineArr(beginSpid, p.getTitle());
		debug(polylineArr);
		//重置参数
		resetParam();

	}
	return false;
}

//单击景点
function soptClick(e, ee, marker1) {
	debug("添加权值");
	action = "addBeginEnd";
	//e.domEvent.stopPropagation(); //阻止事件冒泡
	var p = marker1; //e.target;
	lastLatLng = p.getPosition();
	if (beginSpid == 0) { //如果是只点了一个点
		p.setAnimation(BMAP_ANIMATION_BOUNCE);
		beginMarker = p; //当前跳动的点
		bginLngLat = lastLatLng;
		beginSpid = p.getTitle();
		tips("请选择结束的景点");
	} else {
		if (beginSpid == p.getTitle()) {
			tips("两次点击的点不能是同一个！");
			msgFaild("两次点击的点不能是同一个！");
			return;
		}
		tips("请设置权值值");

		var url = addWeight;
		url = url.replace(/aaspid1aa/, beginSpid);
		url = url.replace(/aaspid2aa/, p.getTitle());
		layer.open({
			type: 2,
			title: '添加权值',
			shadeClose: true,
			shade: 0.8,
			area: ['80%', '90%'],
			content: url //iframe的url
		});
		//todo:设置权值
		//todo:在回调页画一条线	
		return;
		var polyline = new BMap.Polyline([
			bginLngLat,
			lastLatLng
		], {
			strokeColor: "blue",
			strokeWeight: 2,
			strokeOpacity: 0.5
		});
		map.addOverlay(polyline); //增加折线
		addPolylineArr(beginSpid, p.getTitle(), polyline);
		//重置参数
		resetParam();
		debug(polylineArr);
	}
	return false;
}