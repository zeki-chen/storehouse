window.onload = function() {
	var oStar = document.getElementById("star");
	var aLi = oStar.getElementsByTagName("li");
	var oUl = oStar.getElementsByTagName("ul")[0];
	var oSpan = oStar.getElementsByTagName("span")[1];
	var oP = oStar.getElementsByTagName("p")[0];
	var i = iScore = iStar = 0;//
	fnPoint($("#hid_star").val());
	var aMsg = [
		"很不满意|差得太离谱，与卖家描述的严重不符，非常不满",
		"不满意|部分有破损，与卖家描述的不符，不满意",
		"一般|质量一般，没有卖家描述的那么好",
		"比较推荐|质量不错，与卖家描述的基本一致，还是挺满意的",
		"非常推荐|服务非常好，将会超出您的预期"
	]



	for (i = 1; i <= aLi.length; i++) {

		aLi[i - 1].index = i;
		//鼠标移过显示分数
		aLi[i - 1].onmouseover = function() {
			fnPoint(this.index);
			//浮动层显示
			//oP.style.display = "block";
			//计算浮动层位置
			//oP.style.left = oUl.offsetLeft + this.index * this.offsetWidth - 104 + "px";
			//匹配浮动层文字内容
			//oP.innerHTML = "<em><b>" + this.index + "</b> 分 " + aMsg[this.index - 1].match(/(.+)\|/)[1] + "</em>" + aMsg[this.index - 1].match(/\|(.+)/)[1]

		};



		//鼠标离开后恢复上次评分

		aLi[i - 1].onmouseout = function() {
			fnPoint();
			//关闭浮动层
			oP.style.display = "none"
		};
		//点击后进行评分处理

		aLi[i - 1].onclick = function() {
			iStar = this.index;
			$("#hid_star").val(iStar);
			oP.style.display = "none";		

		}

	}



	//评分处理

	function fnPoint(iArg) {
		//分数赋值
		iScore = iArg || iStar;
		for (i = 0; i < aLi.length; i++) aLi[i].className = i < iScore ? "on" : "";

	}



};