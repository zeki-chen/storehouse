function searchForm() {
	loading("搜索中...");
	$("#searchForm").submit();
}

function msgOK(msg) {
	layer.msg(msg, {
		icon: 1,
		shade: [0.5, '#000'],
		shadeClose: true
	});
}

function msgFaild(msg) {
	layer.msg(msg, {
		icon: 2,
		shade: [0.5, '#000'],
		shadeClose: true
	});
}

function loading(msg) {
	layer.msg(msg, {
		icon: 16,
		time: 0,
		shade: [0.5, '#000']
	});
}

function hrefTo(url, time) {
	if (time == 0) {
		window.location.href = url;
	} else {
		setTimeout("hrefTo('" + url + "',0)", time);
	}
}