//第一次加载地图
function firstMap(){
	map = new BMap.Map("container", {
		enableMapClick: false		
	}); // 创建Map实例
	var point = new BMap.Point(defaultLng, defaultLat);
	map.centerAndZoom(point, defaultZoom); // 初始化地图,设置中心点坐标和地图级别
	//map.addControl(new BMap.MapTypeControl()); //添加地图类型控件
	map.addControl(new BMap.ScaleControl());
	//map.addControl(new BMap.NavigationControl());
	map.setDefaultCursor("default"); //鼠标样式
	
	//地图显示范围
	//todo:范围坐标最终要以参数传进来
//	var bArea = new BMap.Bounds(new BMap.Point(113.704337,24.996482),new BMap.Point(113.77074,25.055678));//参数分别为西南角坐标和东北角坐标。	
//	try {	
//		BMapLib.AreaRestriction.setBounds(map, bArea);
//	} catch (e) {
//		alert(e);
//	}
}

//debug
function debug(obj) {
	if (isDebug) {
		console.log(obj);
	}
}
