$(function() {
		$(".select2").select2();
		if (!placeholderSupport()) {
			$('[placeholder]').focus(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
					input.removeClass('placeholder');
				}
			}).blur(function() {
				var input = $(this);
				if (input.val() == '' || input.val() == input.attr('placeholder')) {
					input.addClass('placeholder');
					input.val(input.attr('placeholder'));
				}
			}).blur();
		};
//		//初始化选中
//		$(".ycSec").each(function() {
//			var obj = $(this);
//			obj.val(obj.attr("val"));
//		});
//		$(".ycRadio").each(function(){
//			var obj = $(this);
//			if(obj.val()==obj.attr("val")){
//				obj.attr("checked","checked");
//			}
//		});
//		$(".ycSec").find("option[text='pxx']").attr("selected", true);
		$(".delBtn").live('click',function() {
			var url = $(this).attr("href");
			$(this).removeAttr("href");
			//询问框
			layer.confirm('删除后不可恢复，确定要删除 '+$(this).attr('del_title')+' 吗？', {
				btn: ['确定', '取消'] //按钮
			}, function() {
				loading("正在删除...");
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
		$(".selectAll").click(function() {
			if ($(this).attr("checked") == "checked") {
				$(".del_checkbox").attr("checked", "checked");
			} else {
				$(".del_checkbox").removeAttr("checked");
			}
			//alert($(this).attr("checked"));
		});
	})
	//搜索
function searchForm() {
	loading("搜索中...");
	$("#searchForm").submit();
}
//多行删除
function delMut(url) {
	var chkList = $(".del_checkbox");
	var aids = "";
	var dot = "";
	for (var i = 0; i < chkList.length; i++) {
		if ($(chkList[i]).attr("checked")) {
			aids += dot + $(chkList[i]).val();
			dot = ",";
		}
	}
	if (aids == "") {
		msgFaild("请先选择要删除的记录");
		return false;
	}

	//询问框
	layer.confirm('删除后不可恢复，确定要删除这些记录吗？', {
		btn: ['确定', '取消'] //按钮
	}, function() {
		loading("正在删除...");
		var query = new Object();
		query.ids = aids;
		$.post(url, query, function(data) {
			layer.closeAll();
			if (data.status == 1) {
				//alert(data.info);
				msgOK(data.info);
				window.location.reload();
			} else {
				msgFaild(data.info);
			}
		}, "json");
	}, function() {
		//取消时操作
	});
}

function placeholderSupport() {
	return 'placeholder' in document.createElement('input');
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