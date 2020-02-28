// 文件上传
$(function(){
    $('#uploaderFile .remove').on('click',removeItem);
    var $list = $('#fileList'),
        uploader,
        fileSizeLimit=200 * 1024 * 1024,
        fileSingleSizeLimit=50 * 1024 * 1024,
        fileNumLimit=10;
    uploader = WebUploader.create({
        pick: {
            id: '#picker',
            label: '点击选择文件'
        },
        formData: {
            fileType: 0 //将#id 元素的Val 作为额外参数传递给Action
        },
        auto: true,
        swf: '__PUBLIC__/webuploader-0.1.5/Uploader.swf',
        chunked: true,
        chunkSize: 2 * 1024 * 1024,
        server: uploadFile,

        fileNumLimit: fileNumLimit,
        fileSizeLimit: fileSizeLimit,    // 200 M
        fileSingleSizeLimit: fileSingleSizeLimit,    // 50 M
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        var $li=$( '<div id="' + file.id + '" class="item">' +
            '<i class="iconfont">&#xe6cc;</i>&nbsp;' +
            '<h4 class="info">' + file.name + '</h4>' +
            '<a href="javascript:void(0);" class="remove">删除</a>' +
            '<p class="state"></p>' +
            '</div>' );
        $li.find('.remove').on('click',function(){
            $(this).parent().remove();
            uploader.removeFile( file,true );
        });
        $list.append($li);
    });

    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress-bar');
        // 避免重复创建
        if ( !$percent.length ) {
            var title=$li.children('h4');
            $('<div class="progress progress-striped">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                '</div>' +
                '</div>').insertAfter( title );
            $percent=$li.find('.progress-bar');
        }
        $percent.css( 'width', percentage * 100 + '%' );
    });

    uploader.on( 'uploadSuccess', function(file,response) {
        var inputName='<input type="hidden" name="file['+file.id+'][name]" value="'+response.fileName+'"/>';
        var inputPath='<input type="hidden" name="file['+file.id+'][path]" value="'+response.path+'"/>';
        $('#'+file.id).append(inputPath,inputName);
    });

    uploader.on( 'uploadError', function(file){
        $( '#'+file.id ).find('.state').text('上传出错');
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });

    uploader.on("uploadAccept", function( file, data){
        if ( data.status==0) {
            // 通过return false来告诉组件，此文件上传有错。  
            return false;
        }
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

function removeItem(){
    $(this).parent().remove();
}