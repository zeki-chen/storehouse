<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
<title><?php echo ($title); ?> - <?php echo ($sysInfo['title']); ?></title>
<link rel="stylesheet" type="text/css" href="/xfzz/web/Public/Index/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/xfzz/web/Public/Index/css/common.css" />
<link href="/xfzz/web/Public/layer-v3.0.1/layer/skin/default/layer.css" rel="stylesheet"/>
<link href="/xfzz/web/Public/Validform_v5.3.2/css/validform.css" rel="stylesheet" />

<script type="text/javascript" src="/xfzz/web/Public/Index/js/jquery.min.js"></script>
<script type="text/javascript" src="/xfzz/web/Public/layer-v3.0.1/layer/layer.js"></script>
<script type="text/javascript" src="/xfzz/web/Public/Common/js/layer_close.js"></script>
<script type="text/javascript" src="/xfzz/web/Public/Validform_v5.3.2/js/Validform_v5.3.2_min.js"></script>
		<link rel="stylesheet" type="text/css" href="/xfzz/web/Public/Index/css/pic_list.css" />
	</head>

	<body>
		<!--顶部及导航栏-->
		<!--公共顶部-->
<div class="xf_public_top">
    <div class="public_container clearFloat">
        <div class="top_logo"><img src="/xfzz/web/Public/Index/img/top_logo.png" /></div>
        <div class="top_right_box">
            <div class="users clearFloat">
                <?php if(empty($student)): ?><a href="javascript:void(0)" class="login" id="login">登 录</a>
                <?php else: ?>
                    <div class="after_login">
                        <span class="user_name"><?php echo ($student["name"]); ?></span>
                        <span class="dot red">·</span>
                        <a href="<?php echo U('UserInfo/index');?>" class="user_info">个人信息中心</a>
                        <a href="javascript:void(0);" class="quit" onclick="quit()">退出</a>
                    </div><?php endif; ?>
            </div>
            <div class="search_box clearFloat">
                <form action="<?php echo U('Search/index');?>" method="post">
                    <input type="text" name="keyword" class="search_input" />
                    <input type="submit" value="" class="search_sub" />
                </form>
            </div>
        </div>
    </div>
</div>
<div class="login_box" style="display:none">
    <div class="student_login">学生登录 </div>
    <form class="mainform" action="<?php echo U('Index/doLogin');?>" method="post">
    	<div class="login_item"> 
    		<span>学 号：</span> 
    		<input type="text" name="student_number" class="login_input" placeholder="请输入学号"/>
    	</div>
      	<div class="login_item">
      		<span>密 码：</span>
      		<input type="password" name="student_pwd" class="login_input" placeholder="请输入学号密码" />
      	</div>
        <input type="submit" value="登 录" class="sub_btn" />
    </form>
    <div class="close" id="close" onclick="layerClose()">X</div>
</div>
<!--公共顶部-->

<!--导航栏-->
<?php $navList=yc_get_nav_new(); ?>
<div class="xf_public_nav">
    <ul class="nav_list public_container clearFloat">
        <?php if(is_array($navList)): foreach($navList as $key=>$item): ?><li class="nav_item">
                <?php if($item['type'] == 0): ?><a class="item" href="<?php echo dealNavLink($item['link_url']);?>" target="<?php echo ($item["link_target"]); ?>" title="<?php echo ($item['title']); ?>"><?php echo ($item['title']); ?></a>
                <?php else: ?>
                    <?php $link_url=U('List/yckj',array('model_id'=>$item['type'])); $link_url=str_replace('yckj',$item['action'],$link_url); ?>
                    <a class="item" href="<?php echo ($link_url); ?>" target="<?php echo ($item["link_target"]); ?>" title="<?php echo ($item['title']); ?>"><?php echo ($item ['title']); ?></a><?php endif; ?>
                <?php if(!empty($item['subNav'])): ?><ul class="sub_ul" >
                        <?php if(is_array($item['subNav'])): foreach($item['subNav'] as $key=>$subitem): ?><li class="sub_li">
                                <?php if($subitem['type'] == 0): ?><a class="sub_item" href="<?php echo dealNavLink($subitem['link_url']);?>" target="<?php echo ($subitem["link_target"]); ?>" title="<?php echo ($subitem['title']); ?>"><?php echo ($subitem['title']); ?></a>
                                    <?php else: ?>
                                    <?php if(empty($subitem['link_url'])){ $link_url=U('List/yckj',array('cid'=>$subitem['type'])); $link_url=str_replace('yckj',$subitem['action'],$link_url); }else{ $link_url=$subitem['link_url']; } ?>
                                    <a class="sub_item" href="<?php echo ($link_url); ?>" target="<?php echo ($subitem["link_target"]); ?>"
                                        title="<?php echo ($subitem['title']); ?>"><?php echo ($subitem['title']); ?></a><?php endif; ?>
                            </li><?php endforeach; endif; ?>
                    </ul><?php endif; ?>
            </li><?php endforeach; endif; ?>
    </ul>
</div>
<!--导航栏-->
<script>
    var login_html = $(".login_box").html();
    $('.login_box').remove();
    $("#login").click(function(){
        layer.open({
            type: 1,
            skin: 'login_box', //样式类名
            anim: 2,
            title:0,
            closeBtn:0,
            shadeClose: false, //开启遮罩关闭
            content: login_html
        });
        $(".mainform").Validform({
            tiptype: 4,
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
   function layerClose(){
        layer.closeAll();
    }
   function quit() {
		var url = "<?php echo U('Index/quit');?>";
		$.get(url, function(data) {
			if(data.status) {
				msgOK(data.info);
				hrefTo(data.url, 1000);
			}
		})
	}
</script>

		<!--顶部及导航栏-->

		<!--顶部大图-->
		<?php $banList=yc_get_artList("model_id:20;cid:13;pageSize:4"); ?>
<div class="xf_banner">
    <div class="picture_box" id="banner">
        <ul id="banner_content">
            <?php if(is_array($banList)): foreach($banList as $key=>$item): ?><li><a href="<?php echo ($item['link_url']); ?>" target="_blank"><img src="<?php echo ($item['pic'][0]['path']); ?>" /></a></li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>

<?php if(count($banList) > 1): ?><script type="text/javascript" src="/xfzz/web/Public/Index/js/banner.js"></script>
    <script type="text/javascript">
        $(function(){
            //顶部轮播图
            var $window = $(window), window_width = $window.width();
            $('#banner, #banner_content li').width(window_width);
            new $.Tab({
                target: $('#banner_content li'),
                effect: 'slide3d',
                animateTime: 1000,
                stay: 3500,
                autoPlay: true,
                merge: true
            });
        });
    </script><?php endif; ?>
		<!--顶部大图-->

		<div class="minute">
			<div class="public_container clearFloat">
				<div class="list_box">
					<!--面包屑-->
					<div class="bread">
    <img src="/xfzz/web/Public/Index/img/bread.png" class="bread_icon"/>
    <div class="bread_details">
        您所在的位置：
        <?php if(is_array($bread)): foreach($bread as $k=>$item): if(empty($item['url'])): ?><span class="bread_name <?php if(($k) == $breadLength-1): ?>current<?php endif; ?>"><?php echo ($item["name"]); ?></span>
            <?php else: ?>
                <a href="<?php echo ($item["url"]); ?>" class="bread_link"> <span class="bread_name <?php if(($k) == $breadLength-1): ?>current<?php endif; ?>"><?php echo ($item["name"]); ?></span></a><?php endif; ?>
            <?php if($k < $breadLength-1): ?>&gt;&gt;<?php endif; endforeach; endif; ?>
    </div>
</div>
					<!--面包屑-->
					<div class="essay_list">
						<?php if(is_array($list)): foreach($list as $key=>$item): ?><div class="item">
								<a href="<?php echo U('Details/index',array('aid'=>$item[aid]));?>" target="_blank" title="<?php echo ($item["title"]); ?>" class="clearFloat">
									<div class="cover"><img src="<?php echo img($item['pic'][0]['path'],150,100);?>" /></div>
									<div class="matter">
										<div class="title"><?php echo ($item["title"]); ?></div>
										<div class="sub"><?php echo ($item["description"]); ?></div>
										<div class="read"><?php echo ($item["hits"]); ?></div>
										<div class="date"><?php echo (date("Y年m月d日",$item["pubdate"])); ?></div>
									</div>
								</a>
							</div><?php endforeach; endif; ?>
					</div>
					<div class="page clearFloat">
						<?php echo ($pages); ?>
					</div>
				</div>
				<div class="fast_track">
    <div class="top"> <span class="title">快速通道</span></div>
    <?php $fastList=get_fast_track(); ?>
    <ul>
        <?php if(is_array($fastList)): foreach($fastList as $key=>$item): $link_url=U('List/yckj',array('model_id'=>$item['model_id'])); if(empty($item['action'])){ $item['action']='index'; } $link_url=str_replace('yckj',$item['action'],$link_url); ?>
            <li><a href="<?php echo ($link_url); ?>" class="item"><?php echo ($item["model_name"]); ?></a></li><?php endforeach; endif; ?>
    </ul>
</div>
			</div>
		</div>

		<!--公共底部栏-->
		<div class="xf_bottom">
    <div class="public_container clearFloat">
        <div class="bottom_info clearFloat">
            <?php $linkList=yc_get_links(); ?>
            <div class="link">
                <div class="title">友情链接</div>
                <div class="link_info">
                    <?php if(is_array($linkList)): foreach($linkList as $key=>$item): ?><a href="<?php echo ($item["url"]); ?>" target="<?php echo ($item["link_target"]); ?>" title="<?php echo ($item["name"]); ?>"><?php echo ($item["name"]); ?></a><?php endforeach; endif; ?>
                </div>
            </div>
            <div class="contact">
                <div class="title">联系方式</div>
                <div class="contact_info">
                    <div class="phone">联系电话：<?php echo ($sysInfo["tel"]); ?></div>
                    <div class="address">学校地址：</div>
                    <div class="address_details"><?php echo ($sysInfo["address"]); ?></div>
                </div>
            </div>
            <div class="qr_code">
                <div class="single_code">
                    <img src="<?php echo ($sysInfo['qrcode']['path']); ?>" />
                    <div class="code_name">官方微信</div>
                </div>
                <div class="single_code">
                    <img src="<?php echo ($sysInfo['weibo']['path']); ?>" />
                    <div class="code_name">官方微博</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--版权信息-->
<div class="copyright">
    <div class="public_container">
        <div class="info"><?php echo ($sysInfo['copyright']); ?> 版权所有
            <a href="www.miitbeian.gov.cn" target="_blank">备案号：<?php echo ($sysInfo['icp']); ?></a>
        </div>
        <div class="support">技术支持：<?php echo ($sysInfo['support']); ?></div>
    </div>
</div>
<!--版权信息-->
		<!--公共底部栏-->

		<script type="text/javascript" src="/xfzz/web/Public/Index/js/overTexts.js"></script>
		<script>
			$(function() {
				$(".sub").each(function(){
					var textStr=$(this).text();
					$(this).overTexts({
						texts: textStr,
						textLength: "115",
						overText: "展开",
						openText: "收起",
						ooType: "3"
					});
				});
			})
		</script>
	</body>

</html>