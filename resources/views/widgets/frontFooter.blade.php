<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4>服务链接</h4>
                <ul>
                    <li><a href="http://www.znyes.com/">正言网络科技</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>服务电话</h4>
                <ul>
                    <li class="font-26">400-666-2574</li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>在线客服</h4>
                <ul>
                    <li><a href="tencent://message/?uin=358577184&Site=%E4%BA%A7%E5%93%81%E5%92%A8%E8%AF%A2&Menu=yes" class="btn btn-info"><i class="fa fa-qq"></i> 358577184</a></li>
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
                    <p>版权所有 © 杭州正言网络科技有限公司 2008-2018</p>
                    <span class="font-12">浙ICP备14012374号-1</span>
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
                    $_token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ url('/skin') }}",
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

