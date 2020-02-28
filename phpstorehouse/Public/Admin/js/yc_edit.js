/**
 * Created by Wang on 2016/10/27.
 */
/**
 *用于点击标题、排序、跳转链接等进行编辑，文本框失去焦点后进行保存。
 * 是否有效/是否显示通过点击字段进行更改。
 * 需要加入编辑功能的标签需要在父元素加入.yc_edit
 * 是否有效/是否显示的标签需要在父元素加入.valid_show
 */

var content="";//临时保存编辑前的内容
var key="";//临时保存数据字段
var class_name="";//用于判断是否能为空
var temp="";
var model_id;
$(function(){
    if(typeof(model_id)==undefined){
        model_id='';
    }
    $('.yc_edit').on('click',click_edit);
    $('.valid_show').on('click',click_change);
});

function click_edit(){
    $('.yc_edit').unbind('click');
    var span=$(this).children();
    class_name=span.attr('class');
    content=span.html();
    key=span.attr('name');
    var input="";
    if(key=='sort'){
        input='<input type="number" class="yc_doedit yc_sort" name="'+key+'" value="'+content+'" maxlength="2"/>';
    }else {
        input='<input type="text" class="yc_doedit yc_input" name="'+key+'" value="'+content+'"/>';
    }
    input=$(input).blur(save_data);
    $(this).html(input);
    $('.yc_doedit').focus().select();
}

function click_change(){
    var id=$(this).parent().find('.id');
    var id_value=id.val();
    var id_name=id.attr('name');
    span=$(this).children();
    key=span.attr('name');
    var value='';
    if(key=='type'){
        value=(span.html()=='多选')?0:1;
    }else{
        value=(span.html()=='是')?0:1;
    }
    $.get(yc_url,{model_id:model_id,table:table,id_name:id_name,id_value:id_value,key:key,content:value},function(data){
        if(data.status){
            if(key=='type'){
                span.html((value?'多选':'单选'));
            }else{
                span.html((value?'是':'否'));
            }
        }else{
            msgFaild(data.info);
            if(key=='type'){
                span.html((value?'单选':'多选'));
            }else{
                span.html((value ? '否' : '是'));
            }
        }
    },"json");
}

function save_data(){
    var yc_edit=$(this);
    var new_content=yc_edit.val();
    new_content=$.trim(new_content);
    var id=yc_edit.parent().parent().find('.id');
    var id_value=id.val();
    var id_name=id.attr('name');
    var span='<span class="null" name="'+key+'"></span>';
    span=$(span);
    if(class_name!='null'){
        span.removeClass('null');
        if(new_content==""||new_content==null){
            $('.yc_edit').on('click',click_edit);
            span.html(temp+content);
            yc_edit.parent().html(span);
            msgFaild('不能为空');
            return;
        }
    }
    $.get(yc_url,{model_id:model_id,table:table,id_name:id_name,id_value:id_value,key:key,content:new_content},function(data){
        if(data.status==0){
            $('.yc_edit').on('click',click_edit);
            span.html(temp+content);
            yc_edit.parent().html(span);
            msgFaild(data.info);
        }else{
            $('.yc_edit').on('click',click_edit);
            span.html(temp+new_content);
            yc_edit.parent().html(span);
        }
    },"json");
}
