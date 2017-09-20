/**
 * User: wuyujie
 * Date: 14-6-14
 * Time: 上午9:55
 * To change this template use File | Settings | File Templates.
 */
    //导航菜单

$(function(){
/*菜单*/
    var distan;
    (function(){//构建匿名函数创建闭包
        var $cate_list=$("div .menu_left");
        var $cate_list_dl=$("div .menu_left li");
        var $subcate_list=$("div .menu_right");
        var dlindex=null;
        var ispass=true;
        distan=function(){
            if($cate_list.css('display') == 'block'){
                ispass=false;//区别主页
            }
            return ispass;
        };
        distan();
        $(".cate_sort h3").hover(function(){
            $cate_list.slideDown();
        },function(){
            if(ispass){
                $cate_list.hide();
        }
        });
        $cate_list.hover(function(){
            $cate_list.show();
        },function(){
            if(ispass){
                $cate_list.hide();
            }
        });
        $subcate_list.hover(function(){
            $cate_list.show();
            $cate_list_dl.eq(dlindex).addClass('dl_current').siblings().removeClass('dl_current');
            $(this).stop(true).show();
        },function(){
            $(this).hide();
            $cate_list_dl.removeClass('dl_current');
            if(ispass){
                $cate_list.hide();
            }
        });

        $cate_list_dl.hover(function(){
            dlindex=$(this).index();
            $(this).addClass('dl_current').siblings().removeClass('dl_current');
            $subcate_list.show().find('.menu_part').eq(dlindex).show().siblings().hide();
            $cate_list.show();
        },function(){
            $subcate_list.stop(true).hide();
            $cate_list_dl.removeClass('dl_current');
        });
    }());

//回顶部
    $(".go_up").click(function(){
        $('html,body').animate({scrollTop:0+'px'},300);
    });
//公共产品切换按钮显示隐藏
    $("div .mask").parent().hover(function(){
        $(this).find('.mask').show();
    },function(){
        $(this).find('.mask').hide();
    });
    //设计服务弹出框
    dialogCookie();
    $(".des_close, .later").click(function(){
        $("div.des_dialog").animate({right:-250+'px'},800,function(){
            $(this).hide();
        });
    });
//隐藏流量监测代码所引起的样式问题
    $("#cnzz_stat_icon_1252980091").hide();
    $("iframe[name='google_conversion_frame']").hide();
    $(".login_box_con, .login_content").find("input").each(function(i){
        if($(this).val()!=''){
            $(this).siblings("em").hide();
        }
    });

    $(".login_box_con, .login_content").find("em").click(function(){
        $(this).siblings("input").focus();
    });
    var dtimer=null;
    function desDialog(time){
        dtimer=setTimeout(function(){
            $(".des_dialog img").attr('src',$(".des_dialog img").attr('data-original'));
            $(".des_dialog").fadeIn();
        },1000*30*time)
    }
    function cleanDialog(){
        clearTimeout(dtimer);
    }
    /*主页30秒后弹出，其它页面5分钟后弹出（整站一次会话只弹一次）*/
    function dialogCookie(){
        dianame=getCookie('dialogName');
        if (dianame!=null && dianame!="")//当弹出一次之后就不再弹出
        {
            cleanDialog();
        }
        else
        {
            setCookie('dialogName','logpass');//第一次弹出
            if(distan()){
                desDialog(10);//非主页
            }else{
                desDialog(1);//主页
            }
        }
    }
    (function mobileMaCookie(){//手机二维码
        mobilename=getCookie('MobileName');
        if (mobilename!=null && mobilename!="")//当弹出一次之后就不再弹出
        {
            $(".mobile_wm_bg #bg_black").hide();
            $("div.mobile_wm_bg").hide();
        }
        else
        {
            $(".mobile_wm_bg #bg_black").show();
            $("div.mobile_wm_bg").show();
            setCookie('MobileName','mobilepass',365);//第一次弹出
        }
    }())
});


//cookie时间设置
function getCookie(c_name)
{
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1)
        {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return ""
}

function setCookie(c_name,value,expiredays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : "; expires="+exdate.toGMTString());
}
//搜索框(公共)
function inpFocus(obj,name){
    if(obj.value==name){
        obj.value='';
        obj.style.color="#000";
    }
}
function inpBlur(obj,name){
    if(obj.value==''){
        obj.value=name;
        obj.style.color="#a5a5a5";
    }
}
//密码框提示
function tipFocus(obj){
    $pwd=$(obj);
    $pwd.hide().next().show().focus();
}
function tipBlur(obj){
    $pwd=$(obj);
    if($pwd.val()==''){
        $pwd.hide().prev().show();
    }
}
//登陆/注册页面的文本框验证
function verifyInp(obj){
    $inp = $(obj);
    $inp.siblings("em").hide();
}
function blurInp(obj){
    $inp = $(obj);
    if($inp.val() ==''){
        $inp.siblings("em").show();
    }else{
        $inp.siblings("em").hide();
    }
}
//收藏
function shoucang() {
    window._gaq = window._gaq || [];
    _gaq.push(["_trackEvent", "headerAddFavorite", location.href]);
    var b = window.location.href;
    var a = document.title;
    try {
        window.external.addFavorite(b, a);
    } catch (c) {
        try {
            window.sidebar.addPanel(a, b, "");
        } catch (c) {
            alert("对不起，您的浏览器不支持此操作！\n请您使用菜单栏或Ctrl+D收藏本站。");
        }
    }
}

//轮播
function BannerPlay(bannercon, num,count) {
    var $numList="";
    for(var j=1;j<count;j++){
        $numList+='<li>'+
                    '<div></div>'+
                    '<span>'+j+'</span>'+
                  '</li>';
    }
    $(num).append('<ul>'+
                    $numList+
                  '</ul>');

    var $ul = $(bannercon);
    var $limg = $ul.find('li');
    var $num = $(num).find('li');
    var dis=$limg.width();
    var i = 0;
    var move= 0;
    var timer=null;
    $num.eq(0).addClass("cur");
    autoPlay();
    function autoPlay(){
        timer=setInterval(function(){
            i++;
            if(i>$limg.index()){
                i=0;
            }
            play(i);
        },5000);
    }
    $num.click(function() {
        clearInterval(timer);
        i = $(this).index();
        play(i);
        autoPlay();
    });
    function play(listindex) {
        move=dis*i;
        $ul.stop(true).animate({marginLeft:-move+'px'},800);
        $num.eq(listindex).addClass('cur').siblings().removeClass('cur')
    }
}
