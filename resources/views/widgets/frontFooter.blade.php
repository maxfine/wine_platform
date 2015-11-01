<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4>服务链接</h4>
                <ul>
                    <li><a href="">随手账学堂</a></li>
                    <li><a href="">申请发票</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>服务电话</h4>
                <ul>
                    <li class="font-26">0371-8622 2159</li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>在线客服</h4>
                <ul>
                    <li><a href="" class="btn btn-info"><i class="fa fa-qq"></i> 188855761</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>微信公众号</h4>
                <ul>
                    <li><img src="http://s1.sszimg.com/web/weixin/weixin.jpg" width="120" height="120" alt=""/></li>
                    <li class="font-12">扫描关注【随手账】</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>Copyright © 2015 郑州睿简软件科技有限公司</p>
                    <span class="font-12">豫 ICP 备 15009631 号</span>
                </div>
            </div>
        </div>
    </div>
</footer>


@section('extraSection')
<script type="text/javascript">
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp',      // Element ID
            scrollDistance: 300,         // Distance from top/bottom before showing element (px)
            scrollFrom: 'top',           // 'top' or 'bottom'
            scrollSpeed: 300,            // Speed back to top (ms)
            easingType: 'linear',        // Scroll to top easing (see http://easings.net/)
            animation: 'fade',           // Fade, slide, none
            animationSpeed: 200,         // Animation speed (ms)
            scrollTrigger: false,        // Set a custom triggering element. Can be an HTML string or jQuery object
            scrollTarget: false,         // Set a custom target element for scrolling to. Can be element or number
            scrollText: 'Scroll to top', // Text for element, can contain HTML
            scrollTitle: false,          // Set a custom <a> title if required.
            scrollImg: true,            // Set true to use image
            activeOverlay: false,        // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647           // Z-Index for the overlay
        });
    });
</script>
<script type="text/javascript">
    $(function(){
        $(".change-skin-now").on("click", function(){
            var color =  $(this).attr("id"),
                    $_token = "xhcjQ4OXg0rClWYJHmK1rHH38bxqr7YfWoKKjk1E";
            $.ajax({
                type: "POST",
                url: "http://suishouzhang.com/skin",
                data: {color:color, '_token': $_token},
                success:function()
                {
                    location.reload();
                }
            });
        });
    });
</script>
@endsection

