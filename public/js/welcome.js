//欢迎信息
layer.ready(function () {

    var html = $('#welcome-template').html();
    $('a.viewlog').click(function () {
        parent.layer.open({
            title: '初见倾心',
            type: 1,
            area: ['700px', 'auto'],
            content: html,
            btn: ['确定', '取消']
        });
        return false;
    });

    if ($(this).width() > 768) {
        setTimeout(function () {
            parent.layer.closeAll();
            parent.layer.open({
                title: '欢迎访问H+主页',
                type: 1,
                area: ['700px', 'auto'],
                content: html,
                btn: ['确定', '取消']
            });
        }, 5000);
    }
});