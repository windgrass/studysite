function slidePlay(banimg, bannum, numpages, time, boolen) {
    var $banlist = $(banimg).children();
    var guidenow = $(numpages).find("b");
    var guideall = $(numpages).find("em");
    guideall.html($banlist.length);
    var $bannum = $(bannum).find("li");
    var num = 0;
    var timer = null;
    autoPlay();

    function autoPlay() {
        timer = setInterval(function() {
            $banlist.eq(num).fadeOut("slow");
            num++;
            if (banimg == ".banner_list") {
                $banlist.eq(num).css("background-image", "url(" + $banlist.eq(num).attr("data-src") + ")");
                if (num < $banlist.length) {
                    $banlist.eq(num + 1).css("background-image", "url(" + $banlist.eq(num + 1).attr("data-src") + ")")
                }
            }
            if (boolen) {
                if (num == $banlist.index()) {
                    clearInterval(timer)
                }
            }
            if (num > $banlist.index()) {
                num = 0
            }
            guidenow.html(num + 1);
            $bannum.eq(num).addClass("current").siblings().removeClass("current");
            $banlist.eq(num).fadeIn("slow")
        }, time)
    }
    $bannum.hover(function() {
        clearInterval(timer);
        num = $(this).index();
        if (banimg == ".banner_list") {
            $banlist.eq(num).css("background-image", "url(" + $banlist.eq(num).attr("data-src") + ")");
            if (num < $banlist.length) {
                $banlist.eq(num + 1).css("background-image", "url(" + $banlist.eq(num + 1).attr("data-src") + ")")
            }
        }
        $(this).addClass("current").siblings().removeClass("current");
        $banlist.eq(num).stop(true, true).fadeIn("slow").siblings().fadeOut("slow");
        autoPlay()
    })
}
function prdSwitch(prdbg, pages, shownum) {
    var $bg_children = $(prdbg).children();
    var $now_count = $(pages).find("b");
    var $all_count = $(pages).find("em");
    var $switch_left = $bg_children.find("a").eq(0);
    var $switch_right = $bg_children.find("a").eq(1);
    var $oul = $bg_children.eq(1).find("ul");
    var $oli = $bg_children.eq(1).find("li");
    var mod = $oli.length % shownum;
    var mr = parseInt($oli.css("marginRight"));
    if (isNaN(mr)) {
        mr = 0
    }
    var dis = $oli.width() + mr;
    var count = Math.ceil($oli.length / shownum);
    var num = 0;
    var move = 0;
    $all_count.html(count);

    function switchMove() {
        $now_count.html(num + 1);
        move = num * dis * shownum;
        if ($now_count.html() == count && mod != 0) {
            move = ((num - 1) * dis * shownum) + dis * mod
        }
        $oul.stop(true).animate({
            marginLeft: -move + "px"
        }, 800)
    }
    $switch_left.click(function() {
        num--;
        if (num < 0) {
            num = count - 1
        }
        switchMove()
    });
    $switch_right.click(function() {
        num++;
        if (num > count - 1) {
            num = 0
        }
        switchMove()
    })
}
function share(shareCon, pages, mask) {
    var $share_left = $(mask).children().eq(0);
    var $share_right = $(mask).children().eq(1);
    var $share_li = $(shareCon).find("li");
    var loazd_num = $share_li.eq(0).find("img").length;
    var $share_img = $share_li.find("img");
    var $pages = $(pages).find(".pages");
    var $s_now_count = $pages.find("b");
    var $s_all_count = $pages.find("em");
    var shareLength = $share_li.length;
    var num = 0;
    $s_all_count.html(shareLength);

    function shareSlide() {
        if ($share_img.eq(num).attr("data-original")) {
            for (var i = 0; i < loazd_num; i++) {
                $share_img.eq(num * loazd_num + i).attr("src", $share_img.eq(num * loazd_num + i).attr("data-original"))
            }
        }
        $s_now_count.html(num + 1);
        $share_li.eq(num).stop(true, true).fadeIn("slow").siblings().fadeOut("slow")
    }
    $share_left.click(function() {
        num--;
        if (num < 0) {
            num = $share_li.index()
        }
        shareSlide()
    });
    $share_right.click(function() {
        num++;
        if (num > $share_li.index()) {
            num = 0
        }
        shareSlide()
    })
}
function newSwitch(newsbg, promo_news_tit, shownum) {
    var $news_list = $(newsbg).find("a");
    var $news = $(newsbg).find(".list");
    var $prev = $(promo_news_tit).find(".prev");
    var $next = $(promo_news_tit).find(".next");
    var $total_count = $(promo_news_tit).find(".page_num").find("em");
    var $this_count = $(promo_news_tit).find(".page_num").find("b");
    var count = Math.ceil($news_list.length / shownum);
    $total_count.html(count);
    var num = 0;
    var dis = 0;

    function newMove() {
        $this_count.html(num + 1);
        dis = 100 * num;
        $news.stop(true).animate({
            top: -dis + "px"
        }, 600)
    }
    $prev.click(function() {
        num--;
        if (num < 0) {
            num = count - 1
        }
        newMove()
    });
    $next.click(function() {
        num++;
        if (num > count - 1) {
            num = 0
        }
        newMove()
    })
}
function storePlay(storban, time) {
    var $st_ul = $(storban).children();
    var $num_li = $(storban).next().find("li");
    var dis_width = $(storban).width();
    var num = 0;
    var dis = 0;
    var timer = null;
    autoPlay();
    $num_li.click(function() {
        clearInterval(timer);
        $(this).addClass("current").siblings().removeClass("current");
        num = $(this).index();
        dis = num * dis_width;
        $st_ul.stop(true).animate({
            marginLeft: -dis + "px"
        }, 800);
        autoPlay()
    });

    function autoPlay() {
        timer = setInterval(function() {
            num++;
            if (num > $num_li.index()) {
                num = 0
            }
            dis = num * dis_width;
            $num_li.eq(num).addClass("current").siblings().removeClass("current");
            $st_ul.stop(true).animate({
                marginLeft: -dis + "px"
            }, 800)
        }, time)
    }
}
function rightPlay(adlist, page, admask, time) {
    var $ad = $(adlist).find("li");
    var $now = $(page).find("b");
    var $adcount = $(page).find("em");
    var $go_left = $(admask).find("a").eq(0);
    var $go_right = $(admask).find("a").eq(1);
    var adnum = 0;
    var timer = null;
    $adcount.html($ad.length);

    function playMove() {
        $now.html(adnum + 1);
        $ad.eq(adnum).fadeIn().siblings().fadeOut()
    }
    autoplay();

    function autoplay() {
        timer = setInterval(function() {
            adnum++;
            if (adnum > $ad.index()) {
                adnum = 0
            }
            playMove()
        }, time)
    }
    $go_left.click(function() {
        clearInterval(timer);
        adnum--;
        if (adnum < 0) {
            adnum = $ad.index()
        }
        playMove()
    });
    $go_right.click(function() {
        clearInterval(timer);
        adnum++;
        if (adnum > $ad.index()) {
            adnum = 0
        }
        playMove()
    })
};

function BannerPlay(bannercon, mask, num) {
    var $limg = $(bannercon).find('li');
    var $left = $(mask).find('a.mask_left');
    var $right = $(mask).find('a.mask_right');
    var $num = $(num).find('li');
    var i = 0;
    $left.click(function() {
        i--;
        if (i < 0) {
            i = $limg.index()
        }
        play(i)
    });
    $right.click(function() {
        i++;
        if (i > $limg.index()) {
            i = 0
        }
        play(i)
    });
    $num.hover(function() {
        i = $(this).index();
        play(i)
    });

    function play(listindex) {
        $limg.eq(listindex).fadeIn('slow').siblings().fadeOut('slow');
        $num.eq(listindex).addClass('current').siblings().removeClass('current')
    }
}

/*集成家居*/
function buprdPlay(banlist,mask,num){
    var $mask_left=$(mask).find('a.mask_left');
    var $mask_right=$(mask).find('a.mask_right');
    var $num=$(num).find('a');
    var $img;
    var i=0;
    $mask_left.click(function(){
        juedge();
        i--;
        if(i<0){
            i=$img.length-1;
        }
        $img.eq(i).fadeIn().siblings().fadeOut();
    });
    $mask_right.click(function(){
        juedge();
        i++;
        if(i>$img.length-1){
            i=0;
        }
        $img.eq(i).fadeIn().siblings().fadeOut();
    });
    $num.live('click',function(){
        var nindex=$(this).index();
        $(this).addClass('current').siblings().removeClass('current');
        $(banlist).eq(nindex).show().siblings().hide();
    });
    function juedge(){
        $(banlist).each(function(k,v){
            if($(this).css('display')=='block'){
                $img=$(this).find('a');
            }
        })
    }
}