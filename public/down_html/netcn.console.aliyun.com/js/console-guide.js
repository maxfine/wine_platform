var ConsoleGuide = {
    ckname:"_ww_csg_ck",
    showGuide:function(){
        var gdcookie = $.cookie(ConsoleGuide.ckname);
        if(gdcookie){
            return;
        }
        HichinaConsole.popup.dialog({
            title:'新管控中心引导',
            btnYes:'继续',
            width:780,
            btnNo:'',
            contHtml:'<img src="//gtms04.alicdn.com/tps/i4/TB1VOq9HVXXXXX3XFXXxrxiFVXX-666-374.jpg" alt="" />',
            btnXCloseOnly:true,
            btnYesClick:function(dialog,instance,opts){
                ConsoleGuide.showGuide2();
                instance.close();
            }
        });
        ConsoleGuide.cookieGuide();
    },
    showGuide2:function(){
        HichinaConsole.popup.dialog({
            title:'新管控中心引导',
            btnYes:'立即体验',
            width:780,
            btnNo:'',
            contHtml:'<img src="//gtms02.alicdn.com/tps/i2/TB1dKvJHVXXXXcrXFXXYKARPVXX-689-372.jpg" alt="" />',
            btnXCloseOnly:true,
            btnYesClick:function(dialog,instance,opts){
                instance.close();
            }
        });
    },
    cookieGuide:function(){
        $.cookie(ConsoleGuide.ckname,ConsoleGuide.ckname, { path: "/",expires:365});
    }
}