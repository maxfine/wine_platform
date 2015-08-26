// 图片上传demo
jQuery(function() {
    var $ = jQuery,
        $list = $('#fileList'),
        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 100 * ratio,
        thumbnailHeight = 100 * ratio,

        // Web Uploader实例
        uploader,

    // 初始化Web Uploader
    uploader = WebUploader.create({

        // 自动上传。
        auto: true,

        // swf文件路径
        swf: BASE_URL + '/js/plugins/webuploader-0.1.5/Uploader.swf',

        // 文件接收服务端。
        server: BASE_URL + '/dome/files/upload',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {
            id:'#filePicker',
            multiple:false
        },

        // 只允许选择文件，可选。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        formData: {
            _token: $('meta[name="_token"]').attr('content')
        }
        //fileNumLimit:2 //不限上传次数，避免无法重新上传, 如果只允许上传一张图片, 只需要上传成功后删除前一张
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        var $li = $(
                '<div id="' + file.id + '" class="file-item pull-left">' +
                    '<img class="img-thumbnail">' +
                    '<a class="btn btn-danger btn-block dim btn-outline del-image" href="javascript:void(0);"><i class="fa fa-times"></i> 删除</a>' +
                    //'<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
            $img = $li.find('img');

        $list.append( $li );

        // 创建缩略图
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                //$img.replaceWith('<span>不能预览</span>');
                $img.attr('src', 'https://placeholdit.imgix.net/~text?txtsize=33&txt=%E4%B8%8D%E8%83%BD%E9%A2%84%E8%A7%88&w=110&h=100');
                return;
            }

            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');

        //避免重复创建
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                    .appendTo( $li )
                    .find('span');
        }

        $percent.css( 'width', percentage * 100 + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file, response) {
        layer.msg('图片上传成功');

        var ismultiple = uploader.options.pick.multiple;
        var fileUrl = response.fileUrl;
        var thumb = 'thumb'; //缩略图字段名称, 需要与程序对接
        var $imageInput = $('<input type="hidden" name="' +thumb+ '" value="' + fileUrl + '">');

        //todo: 1. 预留图片src替换成上传后的图片地址 2. 页面插入<input type="hidden" name="image" value="fileUrl">
        if(false === ismultiple){
            //单文件上传
            $('#fileList .upload-state-done').remove();
            $('#filePicker').hide();
            $( '#'+file.id ).addClass('upload-state-done');
            $( '#'+file.id+' img.img-thumbnail').attr('src', fileUrl);
            $('#'+file.id).append($imageInput);
            $( '#'+file.id+' .del-image').on('click', function(e){
                //ajax删除图片, 如果删除成功
                $( '#'+file.id).remove();
                $('#filePicker').show();
                //如果图片删除失败, 弹出层提示
            });
        }else{
            //多文件上传
            $( '#'+file.id ).addClass('upload-state-done');
        }
    });

    // 文件上传失败，现实上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        //$error.text('上传失败');
        layer.msg('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });
});