$(document).ready(function() {

	function setRootFontSize(){
		screenWidth=$(window).width();
		fontsize=screenWidth/320*100;
		$('html').css('font-size',fontsize+"px");
	}

	$(function(){		
		setRootFontSize();
		$(window).resize(function(){
			setRootFontSize();
		});
	});
	
});

function loading(){
	layer.open({type: 2,shadeClose :false,shade: 'background-color: rgba(0,0,0,.9)'});
}

function msgOK(msg) {
	layer.open({
		content: msg,
		style: 'background-color:#09C1FF; color:#fff; border:none;padding:0.1rem;',
		time: 0
	});
}

function msgFaild(msg) {
	layer.open({
		content: msg,
		style: 'background-color:red; color:#fff; border:none;padding:0.1rem',
		time: 2
	});
}

function hrefTo(url, time) {
	if (time == 0) {
		window.location.href = url;
	} else {
		setTimeout("hrefTo('" + url + "',0)", time);
	}
}


