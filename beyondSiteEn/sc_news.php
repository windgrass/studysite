                                <?php
$_language->read_module('sc_latest');

/* SETTINGS */

$_l = array();
$_l['news'] = 1;

/*news pages switch*/
	if(isset($_GET['page'])) $page=(int)$_GET['page'];
	else $page = 1;
	
$queryy="SELECT newsID FROM ".PREFIX."news WHERE published='1'";

$all=mysql_query($queryy);

	$gesamt=mysql_num_rows($all);

	$pages=1;

	$max = empty($maxshownnewss) ? 20 : $maxshownnewss;
	$pages = ceil($gesamt/$max);
/*news pages switch ende */	

/* QUERYS */

$query = "SELECT n.newsID as `lastID`,n.`date`,n.poster as `addedby`, n.blog as `blog`, n.banner as `banner`, n.game as `game`, n.url1 as `url1`, n.rating as `rating`, n.rubric as `type`,'' as `parent`, nc.`headline` as `title`, nc.`intro` as `intro` FROM ".PREFIX."news as n, ".PREFIX."news_contents as nc WHERE n.newsID=nc.newsID and n.published=1 ";

/*news pages switch*/
	if($pages>1) $page_link = makepagelink("index.php?site=news", $page, $pages);
	else $page_link='';

	if($page == "1") {
/*news pages switch ende*/
$query .= " ORDER BY `date` DESC LIMIT 0,".$maxshownnews;
        $query = mysql_query($query);
	$n=$gesamt;
	}
	else {
		$start=$page*$max-$max;
$query .= " ORDER BY `date` DESC LIMIT ".$start.",".$maxshownnews;

        $query = mysql_query($query);
		$n = ($gesamt)-$page*$max+$max;
	}        

$i = 1;
while($res = mysql_fetch_array($query)) {
	$uID = $res['type'] == 'newuser' ? $res['lastID'] : $res['addedby'];
        $nick = '<a href="index.php?site=profile&id='.$uID.'">'.getnickname($uID).'</a>'; 
	$ret = '';
        if($res['banner'])  {
               $pic1 = '<img src="images/news_pics/'.$res['banner'].'" width="305px" />';
        }
        else $pic1 = '';
			
		if($res['blog'] == '1') {
			$url1="http://";
			if($res['url1']!="http://") $url1=$res['url1'];
		} 
		else {
			$url1='index.php?site=article&newsID='.$res['lastID'].'';
		}
		
        $intro = $res['intro'];

        if($res['game'] == '') { $game = ''; } 
        else { $game = '<img src="images/games/'.$res['game'].'.png" width="16px" height="16px" />'; }

	$dateformat = $res['type'] == 'award' ? "d.m.Y" : "F d, Y";
	$date = date($dateformat,$res['date']);
	$day = date("d",$res['date']);
	$month = date("M",$res['date']);
	$year = date("Y",$res['date']);
	
	$date = strftime('%e %B %Y',strtotime($date));
	
    $type = getrubricname($res['type']);
		
		if(mb_strlen($res['title'])>100) {
			$res['title']=mb_substr($res['title'], 0, 100);
			$res['title'].='...';
		}
	
	$ret .= $res['title'];
	
	eval ("\$sc_latest = \"".gettemplate("sc_latest")."\";");
	echo $sc_latest;
	
	$i++;
	
}
	
?>