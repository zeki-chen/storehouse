<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Think\Template\TagLib;

use Think\Template\TagLib;

/**
 * Html标签库驱动
 */
class Ycform extends TagLib {
	protected $tags = array (
			
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'input' => array (
            'attr' => 'id,name,$value,title,class,nullmsg,errormsg,placeholder,maxlength,need,tips,datatype,maxlength,trclass,trid,onfocus,onclick',
            'close' => 1
        ),
        'password' => array (
            'attr' => 'id,name,$value,title,class,nullmsg,placeholder,maxlength,need,tips,datatype,maxlength,recheck,trclass,trid',
            'close' => 1
        ),
        'textarea' => array (
            'attr' => 'id,name,$value,title,class,nullmsg,placeholder,maxlength,need,tips,datatype,maxlength,trclass,trid',
            'close' => 1
        ),
        'uploadImg' => array (
            'attr' => 'id,name,$value,title,class,nullmsg,need,tips,datatype,src,trclass,trid',
            'close' => 1
        ),
        'radio' => array (
            'attr' => 'id,name,$value,title,class,nullmsg,need,tips,datatype,options,trclass,trid,eqvalue',
            'close' => 1
        ),
        'checkbox' => array (
            'attr' => 'id,name,$value,title,class,nullmsg,need,tips,datatype,options,trclass,trid,eqvalue',
            'close' => 1
        ),
        'select' => array (
            'attr' => 'id,name,$value,title,class,nullmsg,need,tips,datatype,options,trclass,trid,eqvalue',
            'close' => 1
        ),
        'ueditor' => array (
            'attr' => 'id,name,$value,title,class,maxlength,need,tips,style,trclass,trid,style',
            'close' => 1
        ),
        'webuploadPic' => array(
            'attr' => 'id,addbtn,name,$value,sumsize,singlesize,count,datatype,tips,nullmsg,errormsg,compress,tip,cut',
            'close' => 1
        ),
        'webuploadFile' => array(
        	'attr' => 'id,addbtn,name,$value,sumsize,singlesize,count,datatype,tips,nullmsg,errormsg,type,tip',
        	'close' => 1
        ),
	);
	/**
	 * 单行文本输入框
	 * 格式： <Ycform:input id="editor" name="remark" >{$vo.remark}</Ycform:input>
	 *
	 * @param unknown $tag        	
	 * @param unknown $content        	
	 * @return string
	 */
	public function _input($tag, $content) {
		$id = ! empty ( $tag ['id'] ) ? $tag ['id'] : '_input';
		$name = $tag ['name'];
		$value = $tag ['value'];
		$title = $tag ['title'];
		$class = ! empty ( $tag ['class'] ) ? $tag ['class'] : '';
		$tips = ! empty ( $tag ['tips'] ) ? $tag ['tips'] : '';
		$placeholder = ! empty ( $tag ['placeholder'] ) ? $tag ['placeholder'] : $tips;
		$nullmsg = ! empty ( $tag ['nullmsg'] ) ? $tag ['nullmsg'] : $tips;		
		$errormsg= ! empty ( $tag ['errormsg'] ) ? $tag ['errormsg'] : "";
		$ignore=! empty ( $tag ['ignore'] ) ? $tag ['ignore'] : '';
		$maxlength = ! empty ( $tag ['maxlength'] ) ? $tag ['maxlength'] : '0';
		$need = ! empty ( $tag ['need'] ) ? $tag ['need'] : '';
		$datatype = ! empty ( $tag ['datatype'] ) ? $tag ['datatype'] : '';
		$onfocus = ! empty ( $tag ['onfocus'] ) ? $tag ['onfocus'] : '';		
		$onclick = ! empty ( $tag ['onclick'] ) ? $tag ['onclick'] : '';
		
		$trclass = $tag ['trclass'];
		$trid = $tag ['trid'];
		$parseStr = '<tr id="' . $trid . '" class="' . $trclass . '" >';
		
		$parseStr .= "<td class=\"ft_title\">$title</td>";
		$parseStr .= "<td colspan=\"3\">";
		
		$parseStr .= "<input value=\"$value\" name=\"$name\" type=\"text\" ";
		if ($maxlength > 0) {
			$parseStr .= "  maxlength=\"$maxlength\"  ";
		}
		if (! empty ( $id )) {
			$parseStr .= "  id=\"$id\"  ";
		}
		
		if (! empty ( $onfocus )) {
			$parseStr .= '  onfocus="'.$onfocus.'"  ';
		}
		if(!empty($onclick)){
			$parseStr .= '  onclick="'.$onclick.'"  ';
		}
		if (! empty ( $datatype )) {
			$parseStr .= " datatype=\"$datatype\" ";
		}		
		if (! empty ( $errormsg )) {
			$parseStr .= '  errormsg="'.$errormsg.'"  ';
		}		
		if (! empty ( $ignore )) {
			$parseStr .= '  ignore="'.$ignore.'"  ';
		}
		$parseStr .= "  class=\"bds inp  $class\" nullmsg=\"$nullmsg\"  placeholder=\"$placeholder\"/>";
		
		$parseStr .= "<font class=\"need show_0\"> $need </font>";
		$parseStr .= "<span class=\"Validform_checktip\">$tips</span>";
		$parseStr .= "</td>";
		$parseStr .= "</tr>";
		return $parseStr;
	}
	
	public function _password($tag, $content) {
		$id = ! empty ( $tag ['id'] ) ? $tag ['id'] : '_input';
		$name = $tag ['name'];
		$value = $tag ['value'];
		$title = $tag ['title'];
		$class = ! empty ( $tag ['class'] ) ? $tag ['class'] : '';
		$tips = ! empty ( $tag ['tips'] ) ? $tag ['tips'] : '';
		$placeholder = ! empty ( $tag ['placeholder'] ) ? $tag ['placeholder'] : $tips;
		$nullmsg = ! empty ( $tag ['nullmsg'] ) ? $tag ['nullmsg'] : $tips;
		$maxlength = ! empty ( $tag ['maxlength'] ) ? $tag ['maxlength'] : '0';
		$need = ! empty ( $tag ['need'] ) ? $tag ['need'] : '';
		$datatype = ! empty ( $tag ['datatype'] ) ? $tag ['datatype'] : '';
		$recheck = ! empty ( $tag ['recheck'] ) ? $tag ['recheck'] : '';
		
		$trclass = $tag ['trclass'];
		$trid = $tag ['trid'];
		$parseStr = '<tr id="' . $trid . '" class="' . $trclass . '" >';
		
		$parseStr .= "<td class=\"ft_title\">$title</td>";
		$parseStr .= "<td colspan=\"3\">";
		
		$parseStr .= "<input value=\"$value\" name=\"$name\" type=\"password\" ";
		if ($maxlength > 0) {
			$parseStr .= "  maxlength=\"$maxlength\"  ";
		}
		if (! empty ( $id )) {
			$parseStr .= "  id=\"$id\"  ";
		}
		if (! empty ( $datatype )) {
			$parseStr .= " datatype=\"$datatype\" ";
		}
		
		if (! empty ( $recheck )) {
			$parseStr .= " recheck=\"$recheck\" ";
		}
		
		$parseStr .= "  class=\"bds inp  $class\" nullmsg=\"$nullmsg\"  placeholder=\"$placeholder\"/>";
		
		$parseStr .= "<font class=\"need show_0\"> $need </font>";
		$parseStr .= "<span class=\"Validform_checktip\">$tips</span>";
		$parseStr .= "</td>";
		$parseStr .= "</tr>";
		return $parseStr;
	}
	
	/**
	 * 多行文本输入框
	 * 格式： <Ycform:textarea id="editor" name="remark" >{$vo.remark}</Ycform:textarea>
	 *
	 * @param unknown $tag        	
	 * @param unknown $content        	
	 * @return string
	 */
	public function _textarea($tag, $content) {
		$id = ! empty ( $tag ['id'] ) ? $tag ['id'] : '_input';
		$name = $tag ['name'];
		$value = $tag ['value'];
		$title = $tag ['title'];
		$class = ! empty ( $tag ['class'] ) ? $tag ['class'] : '';
		$tips = ! empty ( $tag ['tips'] ) ? $tag ['tips'] : '';
		$placeholder = ! empty ( $tag ['placeholder'] ) ? $tag ['placeholder'] : $tips;
		$nullmsg = ! empty ( $tag ['nullmsg'] ) ? $tag ['nullmsg'] : $tips;
		$maxlength = ! empty ( $tag ['maxlength'] ) ? $tag ['maxlength'] : '250';
		$need = ! empty ( $tag ['need'] ) ? $tag ['need'] : '';
		$datatype = ! empty ( $tag ['datatype'] ) ? $tag ['datatype'] : '';
		$trclass = $tag ['trclass'];
		$trid = $tag ['trid'];
		$parseStr = '<tr id="' . $trid . '" class="' . $trclass . '" >';
		
		$parseStr .= "<td class=\"ft_title\">$title</td>";
		$parseStr .= "<td colspan=\"3\">";
		
		$parseStr .= "<textarea  name=\"$name\" type=\"text\"    placeholder=\"$placeholder\" maxlength=\"$maxlength\" ";
		if (! empty ( $id )) {
			$parseStr .= "  id=\"$id\"  ";
		}
		if (! empty ( $datatype )) {
			$parseStr .= " datatype=\"$datatype\" ";
		}
		$parseStr .= "  class=\"bds inp  $class\" nullmsg=\"$nullmsg\"  >$value</textarea>";
		
		$parseStr .= "<font class=\"need show_0\"> $need </font>";
		$parseStr .= "<span class=\"Validform_checktip\">$tips</span>";
		$parseStr .= "</td>";
		$parseStr .= "</tr>";
		
		return $parseStr;
	}
	
	/**
	 * 上传表单控件
	 *
	 * @param unknown $tag        	
	 * @param unknown $content        	
	 * @return string
	 */
	public function _uploadImg($tag, $content) {
		$id = ! empty ( $tag ['id'] ) ? $tag ['id'] : '_input';
		$name = $tag ['name'];
		$value = $tag ['value'];
		$title = $tag ['title'];
		$class = ! empty ( $tag ['class'] ) ? $tag ['class'] : '';
		$tips = ! empty ( $tag ['tips'] ) ? $tag ['tips'] : '';
		$nullmsg = ! empty ( $tag ['nullmsg'] ) ? $tag ['nullmsg'] : $tips;
		$need = ! empty ( $tag ['need'] ) ? $tag ['need'] : '';
		$datatype = ! empty ( $tag ['datatype'] ) ? $tag ['datatype'] : '';
		$src =! empty ( $tag ['src'] ) ? $tag ['src'] : $value;
		$trclass = $tag ['trclass'];
		$trid = $tag ['trid'];
		$parseStr = '<tr id="' . $trid . '" class="' . $trclass . '" >';
		
		$parseStr .= "<td class=\"ft_title\">$title</td>";
		$parseStr .= "<td colspan=\"3\">";
		$parseStr .= "<div class=\"pos_r\">";
		
		$parseStr .= "<input value=\"$value\" name=\"$name\" type=\"text\" ";
		if (! empty ( $id )) {
			$parseStr .= "  id=\"$id\"  ";
		}
		if (! empty ( $datatype )) {
			$parseStr .= " datatype=\"$datatype\" ";
		}
		$parseStr .= "  class=\"inputImg  url1  $class\" nullmsg=\"$nullmsg\" placeholder=\"$placeholder\"
		maxlength=\"$maxlength\"  titleid=\"title1\"/>";
		$parseStr .= "<img src=\"$src\" ref=\"__PUBLIC__/images/nojpg.jpg\" class=\"img1 img_thumbs imgPreview pos_r\" >";
		
		$parseStr .= "<input type=\"button\" class=\"image1 kindimgbtn uploadImgBtn\" value=\"选择图片\">";
		$parseStr .= "<span class=\"Validform_checktip\"><font class=\"need show_0\"> $need </font>";
		$parseStr .= "<span class=\"Validform_checktip\">$tips</span>";
		
		$parseStr .= "</div>";
		$parseStr .= "</td>";
		$parseStr .= "</tr>";
		return $parseStr;
	}
	
	/**
	 * 单选按钮
	 *
	 * @param unknown $tag        	
	 * @param unknown $content
     * @return string
	 */
	public function _radio($tag, $content) {
		$id = ! empty ( $tag ['id'] ) ? $tag ['id'] : '_input';
		$name = $tag ['name'];
		$value = $tag ['value'];
		$title = $tag ['title'];
		$class = ! empty ( $tag ['class'] ) ? $tag ['class'] : '';
		$tips = ! empty ( $tag ['tips'] ) ? $tag ['tips'] : '';
		$placeholder = ! empty ( $tag ['placeholder'] ) ? $tag ['placeholder'] : $tips;
		$nullmsg = ! empty ( $tag ['nullmsg'] ) ? $tag ['nullmsg'] : $tips;
		$maxlength = ! empty ( $tag ['maxlength'] ) ? $tag ['maxlength'] : '250';
		$need = ! empty ( $tag ['need'] ) ? $tag ['need'] : '';
		$datatype = ! empty ( $tag ['datatype'] ) ? $tag ['datatype'] : '';
		$trclass = $tag ['trclass'];
		$trid = $tag ['trid'];
		$parseStr = '<tr id="' . $trid . '" class="' . $trclass . '" >';
		

		$eqvalue = str_replace('{$',"",$value);
		$eqvalue = str_replace('}',"",$eqvalue);//去掉大括号和美元符号	
		
		
		$parseStr .= "<td class=\"ft_title\">$title</td>";
		$parseStr .= "<td colspan=\"3\">";
		$options = $tag ['options']; // 选项
		                             // $options = $this->tpl->get ( $options ); // 转成PHP内容
		
		$parseStr .= "<foreach name=\"$options\" item=\"vo\" key=\"key\" >";
		$parseStr .= '<label class="radio-inline">';
		$parseStr .= '<input type="radio" name="' . $name . '" value="{$vo.value}" ';
		$parseStr .= "  class=\"ycRadio  $class\" ";
		$parseStr .= '  val="{$vo.value}" ';
		if (! empty ( $datatype )) { // 如果设置了datatype
			$parseStr .= '<if condition=" (key+1) eq count($' . $options . ')">';
			$parseStr .= " datatype=\"$datatype\" ";
			$parseStr .= '	</if>';
		}
		if (! empty ( $eqvalue )) {
			$parseStr .= '<eq name="' . $eqvalue . '" value="$vo[\'value\']">checked="checked"</eq>';
		}
		$parseStr .= ' />';
		$parseStr .= '{$vo.key}';
		$parseStr .= ' </label>';
		$parseStr .= "</foreach>";		
		$parseStr .= "<font class=\"need show_0\"> $need </font>";
		$parseStr .= "<span class=\"Validform_checktip\">$tips</span>";
		$parseStr .= "</td>";
		$parseStr .= "</tr>";
		return $parseStr;
	}
	/**
	 * 多选按钮
	 *
	 * @param unknown $tag        	
	 * @param unknown $content        	
	 * @return string
	 */
	public function _checkbox($tag, $content) {
		$id = ! empty ( $tag ['id'] ) ? $tag ['id'] : '_input';
		$name = $tag ['name'];
		$value = $tag ['value'];
		$title = $tag ['title'];
		$class = ! empty ( $tag ['class'] ) ? $tag ['class'] : '';
		$tips = ! empty ( $tag ['tips'] ) ? $tag ['tips'] : '';
		$placeholder = ! empty ( $tag ['placeholder'] ) ? $tag ['placeholder'] : $tips;
		$nullmsg = ! empty ( $tag ['nullmsg'] ) ? $tag ['nullmsg'] : $tips;
		$maxlength = ! empty ( $tag ['maxlength'] ) ? $tag ['maxlength'] : '250';
		$need = ! empty ( $tag ['need'] ) ? $tag ['need'] : '';
		$datatype = ! empty ( $tag ['datatype'] ) ? $tag ['datatype'] : '';
		$parseStr = "<tr>";
		$parseStr .= "<td class=\"ft_title\">$title</td>";
		$parseStr .= "<td colspan=\"3\">";
		$options = $tag ['options']; // 选项
		$options = $this->tpl->get ( $options ); // 转成PHP内容
		
		foreach ( $options as $k => $v ) {
			$parseStr .= '<label class="radio-inline">';
			$parseStr .= '<input type="checkbox" name="' . $name . '" value="' . $v ['value'] . '" ';
			$parseStr .= "  class=\"ycRadio  $class\" ";
			$parseStr .= "  val=\"$value\" ";
			if (! empty ( $datatype )) { // 如果设置了datatype
				if ($k == count ( $options ) - 1) { // 最后一个
					$parseStr .= " datatype=\"$datatype\" ";
				}
			}			
			$parseStr .= " />" . $v ['key'];
			$parseStr .= "</label>";
		}
		$parseStr .= "<font class=\"need show_0\"> $need </font>";
		$parseStr .= "<span class=\"Validform_checktip\">$tips</span>";
		$parseStr .= "</td>";
		$parseStr .= "</tr>";
		return $parseStr;
	}
	
	/**
	 * 下拉选项
	 *
	 * @param unknown $tag        	
	 * @param unknown $content        	
	 * @return string
	 */
	public function _select($tag, $content) {
		$id = ! empty ( $tag ['id'] ) ? $tag ['id'] : '_input';
		$name = $tag ['name'];
		$value = $tag ['value'];
		$title = $tag ['title'];
		$class = ! empty ( $tag ['class'] ) ? $tag ['class'] : '';
		$tips = ! empty ( $tag ['tips'] ) ? $tag ['tips'] : '';
		$placeholder = ! empty ( $tag ['placeholder'] ) ? $tag ['placeholder'] : $tips;
		$nullmsg = ! empty ( $tag ['nullmsg'] ) ? $tag ['nullmsg'] : $tips;
		$maxlength = ! empty ( $tag ['maxlength'] ) ? $tag ['maxlength'] : '250';
		$need = ! empty ( $tag ['need'] ) ? $tag ['need'] : '';
		$datatype = ! empty ( $tag ['datatype'] ) ? $tag ['datatype'] : '';	
			
		$eqvalue = str_replace('{$',"",$value);
		$eqvalue = str_replace('}',"",$eqvalue);
		//$eqvalue = ! empty ( $tag ['eqvalue'] ) ? $tag ['eqvalue'] : '';
		
		$trclass = $tag ['trclass'];
		$trid = $tag ['trid'];
		$parseStr = '<tr id="' . $trid . '" class="' . $trclass . '" >';
		
		$parseStr .= "<td class=\"ft_title\">$title</td>";
		$parseStr .= "<td colspan=\"3\">";
		$options = $tag ['options'];
		
		$parseStr .= "<select name=\"$name\"  class=\"ycSec inp bds $class \" nullmsg=\"$nullmsg\" ";
		if (! empty ( $id )) {
			$parseStr .= "  id=\"$id\"  ";
		}
		if (! empty ( $datatype )) {
			$parseStr .= " datatype=\"$datatype\" ";
		}
		$parseStr .= " val=\"$value\" >";
		$parseStr .= "<option value=\"\">请选择</option>";
		$parseStr .= "<foreach name=\"$options\" item=\"item\" >";
		$parseStr .= '<option value="{$item.value}" ';
		if (! empty ( $eqvalue )) {
			$parseStr .= '<eq name="' . $eqvalue . '" value="$item[\'value\']">selected="selected"</eq>';
		}
		//$parseStr .= '<eq name="' . $eqname . '" value="' . $eqvalue . '">selected="selected"</eq>';
		
		$parseStr .= ' >';
		$parseStr .= '{$item.key}</option>';
		$parseStr .= "</foreach>";
		
		$parseStr .= "	</select>";
		
		$parseStr .= "<font class=\"need show_0\"> $need </font>";
		$parseStr .= "<span class=\"Validform_checktip\">$tips</span>";
		$parseStr .= "</td>";
		$parseStr .= "</tr>";
		return $parseStr;
	}
	public function _ueditor($tag, $content) {
		$id = ! empty ( $tag ['id'] ) ? $tag ['id'] : '_input';
		$name = $tag ['name'];
		$value = $tag ['value'];
		$title = $tag ['title'];
		$class = ! empty ( $tag ['class'] ) ? $tag ['class'] : '';
		$tips = ! empty ( $tag ['tips'] ) ? $tag ['tips'] : '';
		$maxlength = ! empty ( $tag ['maxlength'] ) ? $tag ['maxlength'] : '250';
		$need = ! empty ( $tag ['need'] ) ? $tag ['need'] : '';
		$style = ! empty ( $tag ['style'] ) ? $tag ['style'] : '';
		$trclass = $tag ['trclass'];
		$trid = $tag ['trid'];
		
		$parseStr = '<tr id="' . $trid . '" class="' . $trclass . '" >';
		$parseStr .= "<td class=\"ft_title\">$title</td>";
		$parseStr .= "<td colspan=\"3\">";
		
		$parseStr .= '<textarea id="' . $id . '"   type="text/plain"  name="' . $name . '" class="' . $class . '"  ';
		if (! empty ( $style )) {
			$parseStr .= "  style=\"$style\"  ";
		}
		$parseStr .= '>' . $value;
		$parseStr .= '</textarea>';
		
		$parseStr .= "<font class=\"need show_0\"> $need </font>";
		$parseStr .= "<span class=\"Validform_checktip\">$tips</span>";
		
		$parseStr .= '<script>var ue = UE.getEditor("' . $id . '", {initialFrameWidth: $(window).width() - 200});</script>';
		
		$parseStr .= "</td>";
		$parseStr .= "</tr>";
		
		return $parseStr;
	}

	public function _webuploadPic($tag,$content){
        $id=!empty($tag['id'])?$tag['id']:'_webuploadPic';
        $addbtn=!empty($tag['addbtn'])?$tag['addbtn']:time();
        $datatype=!empty($tag['datatype'])?$tag['datatype']:'';
        $tips=!empty($tag['tips'])?$tag['tips']:'';
        $nullmsg=!empty($tag['nullmsg'])?$tag['nullmsg']:$tips;
        $errormsg=!empty($tag['errormsg'])?$tag['errormsg']:$tips;
        $tip=$tag['tip'];
        $compress=$tag['compress'];
        $name=$tag['name'];
        $value=$tag['value'];
        $sumsize=!empty($tag['sumsize'])?$tag['sumsize']:5;
        $singlesize=!empty($tag['singlesize'])?$tag['singlesize']:1;
        $count=!empty($tag['count'])?$tag['count']:1;
        $forvalue = str_replace('{$',"",$value);
        $forvalue = str_replace('}',"",$forvalue);//去掉大括号和美元符号
        //进行图片裁剪
        $cut = !empty( $tag ['cut']) ? $tag ['cut'] : '';
        if(!empty($cut)){
            $cut=explode(',',$cut);
        }

        //构造上传控件参数
        $arr['1']=$name;
        $arr['inputName']=$name;
        $arr['sumsize']=$sumsize;
        $arr['pick_id']='#'.$addbtn;
        $arr['id']='#'.$id;
        $arr['singlesize']=$singlesize;
        $arr['count']=$count;
        $arr['compress']=$compress;
        $option=json_encode($arr);

        $parseStr='<div class="uploaderPic">'.
        	'<div class="uploader-list" id="'.$id.'">'.
        		'<foreach name="'.$forvalue.'" item="vo" key="k">'.
                    '<div id="" class="item">';
        if($cut[2]=='center'){
            $parseStr.='<img src="{:img($vo[\'path\'],'.$cut[0].','.$cut[1].')}" width="100" height="100">';
        }elseif ($cut[2]=='filled'){
            $parseStr.='<img src="{:img_filled($vo[\'path\'],'.$cut[0].','.$cut[1].')}" width="100" height="100">';
        }else{
            $parseStr.='<img src="{$vo[\'path\']}" width="100" height="100">';
        }
        $parseStr.='<span class="info">{$vo.name}</span>'.
                        '<div class="picTool">'.
                            '<span class="iconfont delPic">&#xe60a;</span>'.
                        '</div>'.
                        '<span class="success"></span>'.
                        '<input type="hidden" name="'.$name.'[{$k}][path]" value="{$vo.path}">'.
                        '<input type="hidden" name="'.$name.'[{$k}][name]" value="{$vo.name}">'.
                    '</div>'.
                '</foreach>'.
            '</div>'.
            '<div class="picAdd div_addbtn">'.
            	'<div id="'.$addbtn.'"></div>'.
            '</div>'.
            '<div class="countTip"></div>'.
            '<input type="text" style="width:1px;height:1px;display:inline" value="0" datatype="'.$datatype.'" nullmsg="'.$nullmsg.'" errormsg="'.$errormsg.'"/>'.
            '<div class="tips">'.$tip.'</div>'.
        '</div>';
        $parseStr.='<script type="text/javascript">'.
			'var uploadswf="__PUBLIC__/webuploader-0.1.5/Uploader.swf";'.
			'var uploadphp="__ROOT__/admin.php/Webuploader/upload.html";'.
		'</script>'.
		'<script type="text/javascript" src="__PUBLIC__/Admin/js/webUploadPicYcF.v2.js"></script>'.
		'<script type="text/javascript">'.
			'var upload=new ycUploadPic('.$option.');'.
		'</script>';
        return $parseStr;
    }

    public function _webuploadFile($tag,$content){
        $id=!empty($tag['id'])?$tag['id']:'_webuploadFile';
        $addbtn=!empty($tag['addbtn'])?$tag['addbtn']:time();
        $datatype=!empty($tag['datatype'])?$tag['datatype']:'';
        $tips=!empty($tag['tips'])?$tag['tips']:'';
        $nullmsg=!empty($tag['nullmsg'])?$tag['nullmsg']:$tips;
        $errormsg=!empty($tag['errormsg'])?$tag['errormsg']:$tips;
        $type=!empty($tag['type'])?$tag['type']:'*';
        $tip=$tag['tip'];
        $name=$tag['name'];
        $value=$tag['value'];
        $sumsize=!empty($tag['sumsize'])?$tag['sumsize']:5;
        $singlesize=!empty($tag['singlesize'])?$tag['singlesize']:1;
        $count=!empty($tag['count'])?$tag['count']:'null';
        $forvalue = str_replace('{$',"",$value);
        $forvalue = str_replace('}',"",$forvalue);//去掉大括号和美元符号

        //构造上传控件参数
        $arr['1']=$sumsize;
        $arr['sumsize']=$sumsize;
        $arr['inputName']=$name;
        $arr['pick_id']='#'.$addbtn;
        $arr['id']='#'.$id;
        $arr['singlesize']=$singlesize;
        $arr['count']=$count;
        if($type=='video'){
//            $accept=json_encode(array('title'=>'video',
//                'extensions'=>'mp4,flv',
//                'mimeTypes'=>'video/x-flv,audio/mp4,video/mp4'
//            ));
            $arr['extensions']='mp4,flv';
        }elseif ($type=='xls'){
            $arr['extensions']='xls,xlsx';
        } else {
            $arr['extensions']='';
        }
        $option=json_encode($arr);

        $parseStr='<div class="uploaderFile">'.
        	'<div class="uploader-list" id="'.$id.'">'.
        		'<foreach name="'.$forvalue.'" item="vo" key="k">'.
                    '<div class="item">'.
                    	'<i class="iconfont">&#xe6cc;</i>'.
                        '<span class="info">&nbsp;{$vo.name}</span>'.
                        '<a href="javascript:void(0);" class="remove">删除</a>'.
                        '<p class="state"></p>'.
                        '<input type="hidden" name="'.$name.'[{$k}][path]" value="{$vo.path}">'.
                        '<input type="hidden" name="'.$name.'[{$k}][name]" value="{$vo.name}">'.
                        '<input type="hidden" name="'.$name.'[{$k}][fileName]" value="{$vo.fileName}">'.
                        '<input type="hidden" name="'.$name.'[{$k}][ext]" value="{$vo.ext}">'.
                        '<input type="hidden" name="'.$name.'[{$k}][size]" value="{$vo.size}">'.
                    '</div>'.
                '</foreach>'.
            '</div>'.
            '<div id="fileCountTip"></div>'.
            '<div class="btns">'.
            	'<div id="'.$addbtn.'" style="display: inline;">选择文件</div>'.
            	'<input type="text" style="width:1px;height:1px;display:block" value="0" datatype="'.$datatype.'" nullmsg="'.$nullmsg.'" errormsg="'.$errormsg.'"/>'.
            	'<div class="tips">'.$tip.'</div>'.
            '</div>'.
        '</div>';
        $parseStr.='<script type="text/javascript">'.
			'var uploadswf="__PUBLIC__/webuploader-0.1.5/Uploader.swf";'.
			'var uploadphp="__ROOT__/admin.php/Webuploader/upload.html";'.
		'</script>'.
		'<script type="text/javascript" src="__PUBLIC__/Admin/js/webUploadFileYcF.v2.js"></script>'.
		'<script type="text/javascript">'.
			'var upload=new ycUploadFile('.$option.');'.
		'</script>';
        return $parseStr;
    }
}