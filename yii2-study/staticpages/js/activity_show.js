/*
* 说明：以后此文件专门放置首页各特殊活动所需要的脚本
* create time:2014.9.19
* create by wyujie
* */

//首页今日最优惠倒计时
(function (obj){
    var time=new Date();
    var osecond=(new Date('2104/12/10 23:59:59').getTime()-time.getTime())/1000;
    setInterval(function(){
        var ohour=Math.floor((osecond/3600)%24);
        var omin=Math.floor((osecond / 60) % 60);
        var oseco=Math.floor(osecond%60);
        osecond--;
        $(obj).find('.hour').html(ohour<10? '0'+ohour:ohour);
        $(obj).find('.min').html(omin<10? '0'+omin:omin);
        $(obj).find('.seco').html(oseco<10? '0'+oseco:oseco);
    },1000)
}('.last_time'));
/*首页报名弹框*/
$("ul.demand_list li").click(function(){
    $(this).toggleClass('select');
});
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('$(\'#11\').z(B(){6 a=$(\'#X\');6 b=$(\'#O\');6 c=$(\'#Z\').l();6 d=$(\'#T\').l();6 e=$("#Y").A();6 f=$("#12").A();6 g=$(\'#N\').l();6 h=/^[一-龥 a-P-Q-9]{2,}$/;j(c==\'\'||c==\'您的真实姓名\'){$(\'.i\').k(\'请输入您的真实姓名！\').5({m:\'q\',n:\'p\'});o}j(!h.M(c)){$(\'.i\').k(\'亲，您的真实姓名格式错误！\').5({m:\'q\',n:\'p\'});o}C=/(^((\\+?t)|(\\(\\+t\\)))?\\d{3,4}-{1}\\d{7,8}(-{0,1}\\d{3,4})?$)|(^((\\+?t)|(\\(\\+t\\)))?1[3-9]\\d{9}$)/;j(!C.M(d)){$(\'.i\').k(\'请输入正确的手机号码！\').5({m:\'q\',n:\'x\'});o}j(a.u("v:w").l()==0||a.u("v:w").l()==\'\'){$(\'.i\').k(\'亲，省份末填写哦！\').5({m:\'y\',n:\'p\'});o}j(b.u("v:w").l()==0||b.u("v:w").l()==\'\'){$(\'.i\').k(\'亲，城市末填写哦！\').5({m:\'y\',n:\'p\'});o}$E={R:{S:c,F:d,U:e,V:f}};$.W(\'/G/H/I.J?r=K/10&c=L\',$E,B(s){j(s==\'13\'){$(\'#14,.15\').16();$("#17").z();$(".18").5(\'19\',\'#1a\');$(\'#1b\').1c(\'1d\',\'/G/H/I.J?r=K/1e&c=L&F=\'+d)}D j(s==\'1f\'){$(\'.i\').k(\'该手机号码已申请过！\').5({m:\'q\',n:\'x\'})}D{$(\'.i\').k(\'申请测量失败！\').5({m:\'y\',n:\'x\'})}})});',62,78,'|||||css|var||||||||||||tips|if|html|val|left|top|return|130px|50px|||86|find|option|selected|205px|310px|click|text|function|pattern|else|data|mobile|oppein|edmsys|index|php|site|pcseosite|test|app_other|selCity|zA|Z0|Appuser|username|app_tel|address_sheng|address_shi|post|selProvince|selProvinceShow|app_name|app|btn_appsubmit|selCityShow|yes|bg_black|apply_box_dialog|show|post_reset|cont|color|999|iframeDoApp|attr|src|ajaxdoapp|compno'.split('|'),0,{}))
//报名成功后的提示框关闭按钮
$('.close').click(function(){
    $('#bg_black,.apply_box_dialog').hide();
});

/*
function CloseAuto(time){
        $("span.time").html(time);
        var timer=setInterval(function(){
        if(time<=1){
        $('.apply_sucess').hide();
        $("#bg_black").hide();
        clearInterval(timer);
        }
    time--;
    $("span.time").html(time);
    },1000)
    }
    */
    /*无缝滚动*/
/*
    var mar={
        ul:$(".clien_list ul"),
        i:0,
        timer:null
        };
    run();
    mar.ul.hover(function(){
        clearInterval(mar.timer)
        },function(){
        run()
        });
    function run(){
        mar.timer=setInterval(function(){
            mar.i-=0.5;
            if(Math.abs(mar.i)>120){
                mar.i=0;
            }
    mar.ul.css('top',mar.i+'px');
    },30);
}
*/

