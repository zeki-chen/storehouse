// 文件上传
$(function(){
    $('#uploaderPic .item').on('mouseenter',showTool);
    $('#uploaderPic .delPic').on('click',removePic);
    var $list = $('#picList'),
        fileSizeLimit=200 * 1024 * 1024,
        fileSingleSizeLimit=50 * 1024 * 1024,
        fileNumLimit=30;
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: '__PUBLIC__/webuploader-0.1.5/Uploader.swf',

        // 文件接收服务端。
        server: uploadFile,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {
            id: '#addPic',
            label: '添加图片'
        },
        formData: {
            fileType: 1 //将#id 元素的Val 作为额外参数传递给Action
        },

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'jpg,jpeg,png',
            mimeTypes: 'image/jpg,image/jpeg,image/png'
        },

        fileNumLimit: fileNumLimit,
        fileSizeLimit: fileSizeLimit,    // 200 M
        fileSingleSizeLimit: fileSingleSizeLimit,    // 50 M
    });
    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        var $li = $(
                '<div id="' + file.id + '" class="item">' +
                '<img>' +
                '<span class="info">' + file.name + '</span>' +
                '<div class="picTool"><span class="iconfont delPic">&#xe60a;</span></div>' +
                '</div>'
            ),
            $img = $li.find('img');
        $li.on('mouseenter',showTool);
        $li.find('.delPic').on('click',function(){
            $(this).parent().parent().remove();
            uploader.removeFile( file,true );
        });

        // $list为容器jQuery实例
        $list.append( $li );
        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr( 'src', src );
        }, 100, 100 );
    });

// 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file ,response) {
        // $( '#'+file.id ).addClass('upload-state-done');
        $( '#'+file.id ).append('<span class="success"></span>');
        var inputName='<input type="hidden" name="pic['+file.id+'][name]" value="'+response.fileName+'"/>';
        var inputPath='<input type="hidden" name="pic['+file.id+'][path]" value="'+response.path+'"/>';
        $('#'+file.id).append(inputPath,inputName);
    });

// 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('.ulerror');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="ulerror"></div>').appendTo( $li );
        }
        $error.text('上传失败');
    });

    uploader.on("uploadAccept", function( file, data){
        if ( data.status==0) {
            // 通过return false来告诉组件，此文件上传有错。  
            return false;
        }
    });

// 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        // $( '#'+file.id ).find('.progress').fadeOut();
    });

    uploader.on( 'error', function( handler ) {
        if(handler=='F_DUPLICATE'){
            msgFaild('该文件已经队列中');
        }else if(handler=='F_EXCEED_SIZE'){
            msgFaild('单个文件大小不能超过'+WebUploader.Base.formatSize(fileSingleSizeLimit));
        }else if(handler=='Q_EXCEED_SIZE_LIMIT'){
            msgFaild('上传文件总大小不能超过'+WebUploader.Base.formatSize(fileSizeLimit));
        }else if(handler=='Q_EXCEED_NUM_LIMIT'){
            msgFaild('上传文件数量不能超过'+fileNumLimit+'个');
        }else{
            msgFaild(handler);
        }
    });
});

function showTool(){
    $(this).mouseover(function () {
        $(this).find('.picTool').show("fast");
    });
    $(this).mouseleave(function () {
        $(this).find('.picTool').hide("fast");
    });
}

function removePic(){
    $(this).parent().parent().remove();
}