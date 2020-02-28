function ycUploadFile(option){
    var f=0;//记录已上传的文件数量
    var fileSingleSizeLimit=option.singlesize*1024*1024;//单个文件大小限制
    var fileSizeLimit=option.sumsize*1024*1024;//总上传文件大小限制
    var fileNumLimit=option.count;//文件数量限制
    var id=option.id;//图片上传列表id
    var btnId=option.pick_id;//图片上传按钮id
    var countTip=$(btnId).parent().prev();//提示信息
    var check=$(btnId).next();
    $(function(){
        $(id+' .remove').on('click',removeItem);
        f=$(id+' .item').size();//获取已上传的文件数量
        if(f){//已上传图片，显示提示信息
            showtipFile();
        }
        if(f>=fileNumLimit){//图片上传达到限制，隐藏上传按钮
            $(btnId).addClass('upload_hidden');
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
                label: '添加文件'
                // multiple: false
            },
            formData: {
                fileType: 0 //类型，0为文件，1为图片。
            },
            //上传文件限制
            // accept:accept,
            accept:{
                // title:'video',
                extensions: option.extensions,
                // mimeTypes: 'video/x-flv,video/mp4'
            },
            chunked: true,
            chunkSize: 2*1024*1024,
            fileNumLimit: fileNumLimit,//上传文件数量
            fileSizeLimit: fileSizeLimit,//上传文件总大小
            fileSingleSizeLimit: fileSingleSizeLimit//上传单个文件大小
        });

        //当文件被加入队列之前触发，此事件的handler返回值为false，则此文件不会被添加进入队列。
        uploader.on('beforeFileQueued',function(file){
            // console.log(file);
            if(!(fileNumLimit-f)){
                msgFaild('上传文件数量不能超过'+fileNumLimit+'个');
                return false;
            }
            $("input[type='submit']").attr('disabled','true');
            $("input[type='submit']").css('background','#ccc');
        });

        // 当有文件添加进来的时候
        uploader.on('fileQueued',function(file){
            var $li=$( '<div id="' + file.id + '" class="item">' +
                '<i class="iconfont">&#xe6cc;</i>&nbsp;' +
                '<span class="info">' + file.name + '</span>' +
                '<a href="javascript:void(0);" class="remove">删除</a>' +
                '<p class="state"></p>' +
                '</div>'
            );
            if(++f>=fileNumLimit){//已上传文件数量大于规定数量，隐藏上传按钮
                $(btnId).addClass('upload_hidden');
            }
            showtipFile();
            $li.find('.remove').on('click',function(){
                if(fileNumLimit>(--f)){//已上传文件数量小于规定数量，显示上传按钮
                    $(btnId).removeClass('upload_hidden');
                    showtipFile();
                    if(!f){
                        $(countTip).css('display','none');
                    }
                    uploader.addButton({
                        id: btnId,
                        innerHTML: '选择文件'
                    });
                }
                $(this).parent().remove();
                uploader.removeFile(file,true);
            });
            list.append($li);
        });

        //创建进度条
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress-bar');
            // 避免重复创建
            if ( !$percent.length ) {
                var title=$li.children('span');
                $('<div class="progress progress-striped">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').insertAfter( title );
                $percent=$li.find('.progress-bar');
            }
            $percent.css( 'width', percentage * 100 + '%' );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess',function(file,response){
            var fileName='<input type="hidden" name="'+option.inputName+'['+file.id+'][name]" value="'+response.name+'"/>';
            var name='<input type="hidden" name="'+option.inputName+'['+file.id+'][fileName]" value="'+response.fileName+'"/>';
            var filePath='<input type="hidden" name="'+option.inputName+'['+file.id+'][path]" value="'+response.path+'"/>';
            var fileExt='<input type="hidden" name="'+option.inputName+'['+file.id+'][ext]" value="'+response.ext+'"/>';
            var fileSize='<input type="hidden" name="'+option.inputName+'['+file.id+'][size]" value="'+response.size+'"/>';
            $('#'+file.id).append(filePath,name,fileName,fileExt,fileSize);
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            $( '#'+file.id ).find('.state').text('上传出错');
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
            $( '#'+file.id ).find('.progress').fadeOut();
            $("input[type='submit']").removeAttr('disabled');
            $("input[type='submit']").css('background','#3280fc');
        });

        // 捕捉错误消息
        uploader.on('error',function(handler){
            if(handler=='F_DUPLICATE'){
                msgFaild('该文件已经队列中');
            }else if(handler=='F_EXCEED_SIZE'){
                msgFaild('单个文件大小不能超过'+WebUploader.Base.formatSize(fileSingleSizeLimit));
            }else if(handler=='Q_EXCEED_SIZE_LIMIT'){
                msgFaild('上传文件总大小不能超过'+WebUploader.Base.formatSize(fileSizeLimit));
            }else if(handler=='Q_EXCEED_NUM_LIMIT'){
                msgFaild('上传文件数量不能超过'+fileNumLimit+'个');
            }else if(handler=='Q_TYPE_DENIED'){
                msgFaild('上传类型为'+option.extensions+'的文件');
            }else{
                msgFaild(handler);
            }
        });

        function removeItem(){
            $(this).parent().remove();
            if(fileNumLimit>(--f)){
                $(btnId).removeClass('upload_hidden');
                showtipFile();
                if(!f){
                    $(countTip).css('display','none');
                }
                uploader.addButton({
                    id: btnId,
                    innerHTML: '选择文件'
                });
            }
        }

        function showtipFile(){
            check.val(f);
            var filecount=fileNumLimit-f;
            $(countTip).html('选择'+f+'个文件，还能再上传'+filecount+'个文件');
            $(countTip).css('display','block');
        }
        this.uploaderObj=uploader;
    });
}



