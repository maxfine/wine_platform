var csrfToken = {
    init:function(){
        var me = csrfToken;
        var header = "WW-Csrf-Token";
        var token = $("input[name='_ww_csrf_token']").val();
        if(token == null) {
            token = $("meta[name='_ww_csrf_header']").attr("content");
        }

        if((token != null) && (token != "null") && (token.length >0) && (token != undefined)) {
            $.ajaxPrefilter(function (options , originalOptions ,jqXHR){
                jqXHR.setRequestHeader(header , token);
            });
        }
    }
}