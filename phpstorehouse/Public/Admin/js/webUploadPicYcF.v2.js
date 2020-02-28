function ycUploadPic(option){
    var p=0;//记录已上传的图片数量
    var picSingleSizeLimit=option.singlesize*1024*1024;//单个文件大小限制
    var picSizeLimit=option.sumsize*1024*1024;//总上传文件大小限制
    var picNumLimit=option.count;//文件数量限制
    var id=option.id;//图片上传列表id
    var btnId=option.pick_id;//图片上传按钮id
    var countTip=$(btnId).parent().next();//提示信息
    var check=countTip.next();
    var compress=(option.compress==1)?true:false;//是否启用图片压缩
    $(function(){
        $(id+' .item').on('mouseenter',showTool);
        $(id+' .delPic').on('click',removePic);
        p=$(id+' .item').size();//获取已上传的文件数量
        if(p){//已上传图片，显示提示信息
            showtip();
        }
        if(p>=picNumLimit){//图片上传达到限制，隐藏上传按钮
            $(btnId).parent().addClass('upload_hidden');
        }
        var list=$(id);
        var uploader = WebUploader.create({
            //选完文件后，是否自动上传。
            auto: true,
            //图片压缩，false不压缩
            compress:false,
            //swf文件路径
            swf: uploadswf,
            //文件接收服务端。
            server: uploadphp,
            //选择文件的按钮。可选。
            //内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                id: btnId,
                label: '添加图片'
                // multiple: false
            },
            formData: {
                fileType: 1 //类型，0为文件，1为图片。
            },
            //只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'jpg,jpeg,png',
                mimeTypes: 'image/jpg,image/jpeg,image/png'
            },
            fileNumLimit: picNumLimit,//上传文件数量
            fileSizeLimit: picSizeLimit,//上传文件总大小
            fileSingleSizeLimit: picSingleSizeLimit//上传单个文件大小
        });

        if(compress){
            // console.log(compress);
            //启用图片压缩
            uploader.option('compress',{
                width: 1600,
                height: 1600,
                // 图片质量，只有type为`image/jpeg`的时候才有效。
                quality: 90,
                // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
                allowMagnify: false,
                // 是否允许裁剪。
                crop: false,
                // 是否保留头部meta信息。
                preserveHeaders: true,
                // 如果发现压缩后文件大小比原来还大，则使用原来图片
                // 此属性可能会影响图片自动纠正功能
                noCompressIfLarger: false,
                // 单位字节，如果图片大小小于此值，不会采用压缩。
                compressSize: 0
            });
        }

        //当文件被加入队列之前触发，此事件的handler返回值为false，则此文件不会被添加进入队列。
        uploader.on('beforeFileQueued',function(file){
            if(!(picNumLimit-p)){
                msgFaild('上传文件数量不能超过'+picNumLimit+'个');
                return false;
            }
            $("input[type='submit']").attr('disabled','true');
            $("input[type='submit']").css('background','#ccc');
        });

        // 当有文件添加进来的时候
        uploader.on('fileQueued',function(file){
            var $li=$('<div id="' + file.id + '" class="item">' +
                    '<img>' +
                    '<span class="info">' + file.name + '</span>' +
                    '<div class="picTool"><span class="iconfont delPic">&#xe60a;</span></div>' +
                    '</div>'
                ),
                $img = $li.find('img');
            $li.on('mouseenter',showTool);
            if(++p>=picNumLimit){//已上传文件数量大于规定数量，隐藏上传按钮
                $(btnId).parent().addClass('upload_hidden');
            }
            $li.find('.delPic').on('click',function(){
                if(picNumLimit>(--p)){//已上传文件数量小于规定数量，显示上传按钮
                    $(btnId).parent().removeClass('upload_hidden');
                    showtip();
                    if(!p){
                        $(countTip).css('display','none');
                    }
                    uploader.addButton({
                        id: btnId,
                        innerHTML: '选择图片'
                    });
                }
                $(this).parent().parent().remove();
                uploader.removeFile(file,true);
            });

            showtip();

            list.append($li);
            //创建缩略图
            //如果为非图片文件，可以不用调用此方法。
            //thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb(file,function(error,src){
                if(error){
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }
                $img.attr('src',src);
            },100,100);
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess',function(file,response){
            $( '#'+file.id ).append('<span class="success"></span>');
            var picName='<input type="hidden" name="'+option.inputName+'['+file.id+'][name]" value="'+response.fileName+'"/>';
            var picPath='<input type="hidden" name="'+option.inputName+'['+file.id+'][path]" value="'+response.path+'"/>';
            $('#'+file.id).append(picPath,picName);
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            var $li=$('#'+file.id),
                $error=$li.find('.ulerror');
            //避免重复创建
            if(!$error.length){
                $error=$('<div class="ulerror"></div>').appendTo($li);
            }
            $error.text('上传失败');
        });

        // 文件上传到服务端响应后，会派送此事件来询问服务端响应是否有效
        uploader.on("uploadAccept",function(file,data){
            if(data.status==0) {
                // 通过return false来告诉组件，此文件上传有错。
                return false;
            }
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete',function(file){
            // $( '#'+file.id ).find('.progress').fadeOut();
            $("input[type='submit']").removeAttr('disabled');
            $("input[type='submit']").css('background','#3280fc');
        });

        // 捕捉错误消息
        uploader.on('error',function(handler){
            if(handler=='F_DUPLICATE'){
                msgFaild('该文件已经队列中');
            }else if(handler=='F_EXCEED_SIZE'){
                msgFaild('单个文件大小不能超过'+WebUploader.Base.formatSize(picSingleSizeLimit));
            }else if(handler=='Q_EXCEED_SIZE_LIMIT'){
                msgFaild('上传文件总大小不能超过'+WebUploader.Base.formatSize(picSizeLimit));
            }else if(handler=='Q_EXCEED_NUM_LIMIT'){
                msgFaild('上传文件数量不能超过'+picNumLimit+'个');
            }else{
                msgFaild(handler);
            }
        });

        //删除图片
        function removePic(){
            $(this).parent().parent().remove();
            if(picNumLimit>(--p)){
                $(btnId).parent().removeClass('upload_hidden');
                uploader.addButton({
                    id: btnId,
                    innerHTML: '选择图片'
                });
            }

            showtip();
            if(!p){
                $(countTip).css('display','none');
            }
        }

        //显示提示
        function showtip(){
            check.val(p);
            var piccount=picNumLimit-p;
            $(countTip).html('选择'+p+'张图片，还能再上传'+piccount+'张图片');
            $(countTip).css('display','block');
        }

        //显示或隐藏删除按钮
        function showTool(){
            $(this).mouseover(function () {
                $(this).find('.picTool').show("fast");
            });
            $(this).mouseleave(function () {
                $(this).find('.picTool').hide("fast");
            });
        }
        this.uploaderObj=uploader;
    });
}



