var f=0;
var uploaderFile;
fileSingleSizeLimit=fileSingleSizeLimit*1024*1024;
fileSizeLimit=fileSizeLimit*1024*1024;
$(function(){
    $(fileId+' .remove').on('click',removeItem);
    f=$(fileId+' .item').size();//获取已上传的文件数量
    if(f){
        showtipFile();
    }
    if(f>=fileNumLimit){
        // $(filebtnId).css('visibility','hidden');
        $(fileBtnId).css('display','none');
    }
    var $list = $(fileId+' .fileList');

//add flash 



// 检测是否已经安装flash，检测flash的版本
            flashVersion = ( function() {
                var version;

                try {
                    version = navigator.plugins[ 'Shockwave Flash' ];
                    version = version.description;
                } catch ( ex ) {
                    try {
                        version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                                .GetVariable('$version');
                    } catch ( ex2 ) {
                        version = '0.0';
                    }
                }
                version = version.match( /\d+/g );
                return parseFloat( version[ 0 ] + '.' + version[ 1 ], 10 );
            } )(),

            supportTransition = (function(){
                var s = document.createElement('p').style,
                    r = 'transition' in s ||
                            'WebkitTransition' in s ||
                            'MozTransition' in s ||
                            'msTransition' in s ||
                            'OTransition' in s;
                s = null;
                return r;
            })();

      if ( !WebUploader.Uploader.support('flash') && WebUploader.browser.ie ) {

            // flash 安装了但是版本过低。
            if (flashVersion) {
                (function(container) {
                    window['expressinstallcallback'] = function( state ) {
                        switch(state) {
                            case 'Download.Cancelled':
                                alert('您取消了更新！')
                                break;

                            case 'Download.Failed':
                                alert('安装失败')
                                break;

                            default:
                                alert('安装已成功，请刷新！');
                                break;
                        }
                        delete window['expressinstallcallback'];
                    };

                    var swf = './expressInstall.swf';
                    // insert flash object
                    var html = '<object type="application/' +
                            'x-shockwave-flash" data="' +  swf + '" ';

                    if (WebUploader.browser.ie) {
                        html += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                    }

                    html += 'width="100%" height="100%" style="outline:0">'  +
                        '<param name="movie" value="' + swf + '" />' +
                        '<param name="wmode" value="transparent" />' +
                        '<param name="allowscriptaccess" value="always" />' +
                    '</object>';

                    container.html(html);

                })($wrap);

            // 压根就没有安转。
            } else {
                $wrap.html('<a href="http://www.adobe.com/go/getflashplayer" target="_blank" border="0"><img alt="get flash player" src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" /></a>');
            }

            return;
        } else if (!WebUploader.Uploader.support()) {
            alert( 'Web Uploader 不支持您的浏览器！');
            return;
        }

        //end flash

    uploaderFile = WebUploader.create({
        //选完文件后，是否自动上传。
        auto: true,
        //swf文件路径
        swf: PUBLIC_DIR+'/webuploader-0.1.5/Uploader.swf',
        //文件接收服务端。
        server: uploadFile,
        //选择文件的按钮。可选。
        //内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {
            id: fileBtnId,
            label: '添加文件'
        },
        formData: {
            fileType: 0 //类型，0为文件，1为图片。
        },
        chunked: true,
        chunkSize: 2 * 1024 * 1024,
        fileNumLimit: fileNumLimit,//上传文件数量
        fileSizeLimit: fileSizeLimit,//上传文件总大小
        fileSingleSizeLimit: fileSingleSizeLimit//上传单个文件大小
    });

    //当文件被加入队列之前触发，此事件的handler返回值为false，则此文件不会被添加进入队列。
    uploaderFile.on('beforeFileQueued',function(file){
        if(!(fileNumLimit-f)){
            msgFaild('上传文件数量不能超过'+fileNumLimit+'个');
            return false;
        }
    });

    // 当有文件添加进来的时候
    uploaderFile.on( 'fileQueued', function( file ) {
        var $li=$( '<div id="' + file.id + '" class="item">' +
                '<i class="iconfont">&#xe6cc;</i>&nbsp;' +
                '<span class="info">' + file.name + '</span>' +
                '<a href="javascript:void(0);" class="remove">删除</a>' +
                '<p class="state"></p>' +
                '</div>' 
            );
        if(++f>=fileNumLimit){//已上传文件数量大于规定数量，隐藏上传按钮
            // $(filebtnId).css('visibility','hidden');
            // $(fileBtnId).css('display','none'); 
            $(fileBtnId).addClass('upload_hidden');
        }
        showtipFile();
        $li.find('.remove').on('click',function(){
            if(fileNumLimit>(--f)){//已上传文件数量小于规定数量，显示上传按钮
                // $(filebtnId).css('visibility','visible');
                // $(fileBtnId).css('display','block');
                $(fileBtnId).removeClass('upload_hidden');
                showtipFile();
                if(!f){
                    $(fileId+' #fileCountTip').css('display','none');
                }
                uploaderFile.addButton({
                    id: fileBtnId,
                    innerHTML: '选择文件'
                });
            }
            $(this).parent().remove();
            uploaderFile.removeFile(file,true);
        });
        $list.append($li);
    });

    //创建进度条
    uploaderFile.on( 'uploadProgress', function( file, percentage ) {
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

    //文件上传成功
    uploaderFile.on( 'uploadSuccess', function(file,response) {
        var fileName='<input type="hidden" name="'+fileinputName+'['+file.id+'][name]" value="'+response.fileName+'"/>';
        var filePath='<input type="hidden" name="'+fileinputName+'['+file.id+'][path]" value="'+response.path+'"/>';
        $('#'+file.id).append(fileName,filePath);
    });

    //文件上传失败
    uploaderFile.on( 'uploadError', function(file){
        $( '#'+file.id ).find('.state').text('上传出错');
    });

    //完成上传完了，成功或者失败，先删除进度条。
    uploaderFile.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });

    //文件上传到服务端响应后，会派送此事件来询问服务端响应是否有效
    uploaderFile.on("uploadAccept", function( file, data){
        if ( data.status==0) {
            // 通过return false来告诉组件，此文件上传有错。  
            return false;
        }
    });

    //捕捉错误消息
    uploaderFile.on( 'error', function( handler ) {
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
    if(fileNumLimit>(--f)){
        // $(filebtnId).css('visibility','visible');
        $(fileBtnId).css('display','block');
        showtipFile();
        if(!f){
            $(fileId+' #fileCountTip').css('display','none');
        }
        uploaderFile.addButton({
            id: fileBtnId,
            innerHTML: '选择文件'
        });
    }
}

function showtipFile(){
    var filecount=fileNumLimit-f;
    $(fileId+' #fileCountTip').html('选择'+f+'个文件，还能再上传'+filecount+'个文件');
    $(fileId+' #fileCountTip').css('display','block');
}