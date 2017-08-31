<?php

$_language = $GLOBALS['_language'];
$_language->read_module('seo');

function settitle($string){
	return $GLOBALS['hp_title'].' :: '.$string;
	//return $GLOBALS['hp_title'];
}

function breadcrumb($content){
	$breadcrumb = '';
	foreach($content AS $entry){
		$breadcrumb .= '<li><a class="white" href="'.$entry['link'].'">'.$entry['text'].'</a></li><br \>';
	}
	define('BREADCRUMB', $breadcrumb);
}

if(isset($_GET['action'])) $action = $_GET['action'];
else $action='';

if(isset($_GET['cat'])) $cat = $_GET['cat'];
else $cat='';

switch ($GLOBALS['site']) {
	
	case 'tablet':
		define('PAGETITLE', settitle('Tablet'));
		$breadcrumb = array(array('link' => 'index.php?site=tablet#solving', 'text' => 'Solving 3 Main Pain Points for Parents'), 
							array('link' => 'index.php?site=tablet#best', 'text' => 'Best of Virtual and Best of Physical Worlds Combined'),
							array('link' => 'index.php?site=tablet#what', 'text' => 'What Is Beyond Tablet'),
							array('link' => 'index.php?site=tablet#tech', 'text' => 'Technology Embedded in Beyond Tablet'),
							array('link' => 'index.php?site=tablet#original', 'text' => 'An Original Invention (take away patent numbers)'));
		breadcrumb($breadcrumb);
		break;
	case 'games':
		define('PAGETITLE', settitle('Games'));
		break;
		
	case 'intelligences':
		define('PAGETITLE', settitle('Intelligences'));
		break;
	
	case 'press':
		define('PAGETITLE', settitle('Press'));
		break;

	case 'award':
		define('PAGETITLE', settitle('Award'));
		break;
	
	case 'game':
		if(isset($_GET['s'])) $sponsorID = (int)$_GET['s'];
		else $sponsorID = '';
		$get=mysql_fetch_array(safe_query("SELECT name FROM `".PREFIX."sponsors` WHERE s='$sponsorID'"));
		define('PAGETITLE', settitle('Game &raquo; '.$get['name']));
		break;
	
	case 'articles':
		if(isset($_GET['articlesID'])) $articlesID = (int)$_GET['articlesID'];
		else $articlesID = '';
		if($action=="show") {
			$get=mysql_fetch_array(safe_query("SELECT title FROM `".PREFIX."articles` WHERE articlesID='$articlesID'"));
			define('PAGETITLE', settitle($_language->module['articles'].'&nbsp; &raquo; &nbsp;'.$get['title']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['articles']));
		}
		break;
	
	case 'awards':
		if(isset($_GET['awardID'])) $awardID = (int)$_GET['awardID'];
		else $awardID = '';		
		if($action=="details") {
			$get=mysql_fetch_array(safe_query("SELECT award FROM `".PREFIX."awards` WHERE awardID='$awardID'"));
			define('PAGETITLE', settitle($_language->module['awards'].' » '.$get['award']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['awards']));
		}
		break;
	
	case 'buddys':
		define('PAGETITLE', settitle($_language->module['buddys']));
		break;
	
	case 'calendar':
		define('PAGETITLE', settitle($_language->module['calendar']));
		break;
	
	case 'cash_box':
		define('PAGETITLE', settitle($_language->module['cash_box']));
		break;
	
	case 'challenge':
		define('PAGETITLE', settitle($_language->module['challenge']));
		break;
	
	case 'clanwars':
		if($action=="stats") {
			define('PAGETITLE', settitle($_language->module['clanwars'].'&nbsp; &raquo; &nbsp;'.$_language->module['stats']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['clanwars']));
		}
		break;
	
	case 'clanwars_details':
		if(isset($_GET['cwID'])) $cwID = (int)$_GET['cwID'];
		else $cwID = '';
		$get=mysql_fetch_array(safe_query("SELECT opponent FROM `".PREFIX."clanwars` WHERE cwID='$cwID'"));
		define('PAGETITLE', settitle($_language->module['clanwars'].'&nbsp; &raquo; &nbsp;'.$_language->module['clanwars_details'].'&nbsp;'.$get['opponent']));
		break;
	
	case 'contact':
		define('PAGETITLE', settitle($_language->module['contact_us']));
		break;
	
	case 'counter_stats':
		define('PAGETITLE', settitle($_language->module['stats']));
		break;
	
	case 'demos':
		if(isset($_GET['demoID'])) $demoID = (int)$_GET['demoID'];
		else $demoID = '';
		if($action=="showdemo") {
			$get=mysql_fetch_array(safe_query("SELECT game, clan1, clan2 FROM `".PREFIX."demos` WHERE demoID='$demoID'"));
			define('PAGETITLE', settitle($_language->module['demos'].'&nbsp; &raquo; &nbsp;'.$get['game'].' '.$_language->module['demo'].': '.$get['clan1'].' '.$_language->module['versus'].' '.$get['clan2']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['demos']));
		}
		break;
	
	case 'faq':
		if(isset($_GET['faqcatID'])) $faqcatID = (int)$_GET['faqcatID'];
		else $faqcatID = '';
		if(isset($_GET['faqID'])) $faqID = (int)$_GET['faqID'];
		else $faqID = '';
		$get=mysql_fetch_array(safe_query("SELECT faqcatname FROM `".PREFIX."faq_categories` WHERE faqcatID='$faqcatID'"));
		$get2=mysql_fetch_array(safe_query("SELECT question FROM `".PREFIX."faq` WHERE faqID='$faqID'"));
		if($action=="faqcat") {
			define('PAGETITLE', settitle($_language->module['faq'].'&nbsp; &raquo; &nbsp;'.$get['faqcatname']));
		}
		elseif($action=="faq") {
			define('PAGETITLE', settitle($_language->module['faq'].'&nbsp; &raquo; &nbsp;'.$get['faqcatname'].'&nbsp; &raquo; &nbsp;'.$get2['question']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['faq']));
		}
		break;
	
	case 'files':
		if(isset($_GET['cat'])) $cat = (int)$_GET['cat'];
		else $cat = '';
		if(isset($_GET['file'])) $file = (int)$_GET['file'];
		else $file = '';
		if(isset($_GET['cat'])) {
			$cat = mysql_fetch_array(safe_query("SELECT filecatID, name FROM ".PREFIX."files_categorys WHERE filecatID='".$cat."'"));
			define('PAGETITLE', settitle($_language->module['files'].'&nbsp; &raquo; &nbsp;'.$cat['name']));
		}
		elseif(isset($_GET['file'])) {
			$file = mysql_fetch_array(safe_query("SELECT fileID, filecatID, filename FROM ".PREFIX."files WHERE fileID='".$file."'"));
			$catname = mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."files_categorys WHERE filecatID='".$file['filecatID']."'"));
			define('PAGETITLE', settitle($_language->module['files'].'&nbsp; &raquo; &nbsp;'.$catname['name'].'&nbsp; &raquo; &nbsp;'.$file['filename']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['files']));
		}
		break;
	
	case 'forum':
		if(isset($_GET['board'])) $board = (int)$_GET['board'];
		else $board = '';		
		if(isset($_GET['board'])) {
			$board = mysql_fetch_array(safe_query("SELECT boardID, name FROM ".PREFIX."forum_boards WHERE boardID='".$board."'"));
			define('PAGETITLE', settitle($_language->module['forum'].'&nbsp; &raquo; &nbsp;'.$board['name']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['forum']));
		}
		break;
	
	case 'forum_topic':
		if(isset($_GET['topic'])) $topic = (int)$_GET['topic'];
		else $topic = '';
		if(isset($_GET['topic'])) {
			$topic = mysql_fetch_array(safe_query("SELECT topicID, boardID, topic FROM ".PREFIX."forum_topics WHERE topicID='".$topic."'"));
			$boardname = mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."forum_boards WHERE boardID='".$topic['boardID']."'"));
			define('PAGETITLE', settitle($_language->module['forum'].'&nbsp; &raquo; &nbsp;'.$boardname['name'].'&nbsp; &raquo; &nbsp;'.$topic['topic']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['forum']));
		}
		break;
	
	case 'gallery':
		if(isset($_GET['groupID'])) $groupID = (int)$_GET['groupID'];
		else $groupID = '';
		if(isset($_GET['galleryID'])) $galleryID = (int)$_GET['galleryID'];
		else $galleryID = '';
		if(isset($_GET['picID'])) $picID = (int)$_GET['picID'];
		else $picID = '';
		if(isset($_GET['groupID'])) {
			$groupID = mysql_fetch_array(safe_query("SELECT groupID, name FROM ".PREFIX."gallery_groups WHERE groupID='".$groupID."'"));
			define('PAGETITLE', settitle($_language->module['gallery'].'&nbsp; &raquo; &nbsp;'.$groupID['name']));
		}
		elseif(isset($_GET['galleryID'])) {
			$galleryID = mysql_fetch_array(safe_query("SELECT galleryID, name, groupID FROM ".PREFIX."gallery WHERE galleryID='".$galleryID."'"));
			$groupname = mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."gallery_groups WHERE groupID='".$galleryID['groupID']."'"));
			if($groupname['name'] == "") $groupname['name'] = $_language->module['usergallery'];
			define('PAGETITLE', settitle($groupname['name'].' » '.$galleryID['name']));
		}
		elseif(isset($_GET['picID'])) {
			$getgalleryname = mysql_fetch_array(safe_query("SELECT gal.groupID, gal.galleryID, gal.name FROM ".PREFIX."gallery_pictures as pic, ".PREFIX."gallery as gal WHERE pic.picID='".$_GET['picID']."' AND gal.galleryID=pic.galleryID"));
			$getgroupname = mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."gallery_groups WHERE groupID='".$getgalleryname['groupID']."'"));
			if($getgroupname['name'] == "") $getgroupname['name'] = $_language->module['usergallery'];
			$picID = mysql_fetch_array(safe_query("SELECT picID, galleryID, name FROM ".PREFIX."gallery_pictures WHERE picID='".$picID."'"));
			define('PAGETITLE', settitle($_language->module['gallery'].'&nbsp; &raquo; &nbsp;'.$getgroupname['name'].'&nbsp; &raquo; &nbsp;'.$getgalleryname['name'].'&nbsp; &raquo; &nbsp;'.$picID['name']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['gallery']));
		}
		break;
	
	case 'guestbook':
		define('PAGETITLE', settitle($_language->module['guestbook']));
		break;
	
	case 'history':
		define('PAGETITLE', settitle($_language->module['history']));
		break;
	
	case 'imprint':
		define('PAGETITLE', settitle($_language->module['imprint']));
		break;
	
	case 'joinus':
		define('PAGETITLE', settitle($_language->module['joinus']));
		break;
	
	case 'links':
		if(isset($_GET['linkcatID'])) $linkcatID = (int)$_GET['linkcatID'];
		else $linkcatID = '';
		if($action=="show") {
			$get=mysql_fetch_array(safe_query("SELECT name FROM `".PREFIX."links_categorys` WHERE linkcatID='$linkcatID'"));
			define('PAGETITLE', settitle($_language->module['links'].'&nbsp; &raquo; &nbsp;'.$get['name']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['links']));
		}
		break;
	
	case 'linkus':
		define('PAGETITLE', settitle($_language->module['linkus']));
		break;
	
	case 'login':
		define('PAGETITLE', settitle($_language->module['login']));
		break;
	
	case 'loginoverview':
		define('PAGETITLE', settitle($_language->module['loginoverview']));
		break;
	
	case 'lostpassword':
		define('PAGETITLE', settitle($_language->module['lostpassword']));
		break;
	
	case 'members':
		if(isset($_GET['squadID'])) $squadID = (int)$_GET['squadID'];
		else $squadID = '';
		if($action=="show") {
			$get=mysql_fetch_array(safe_query("SELECT name FROM `".PREFIX."squads` WHERE squadID='$squadID'"));
			define('PAGETITLE', settitle($_language->module['members'].'&nbsp; &raquo; &nbsp;'.$get['name']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['members']));
		}
		break;
	
	case 'messenger':
		define('PAGETITLE', settitle($_language->module['messenger']));
		break;
	
	case 'myprofile':
		define('PAGETITLE', settitle($_language->module['edit_account']));
		break;
	
	case 'news':
		if($action=="archive") {
			define('PAGETITLE', settitle(''.$_language->module['news'].' » '.$_language->module['archive']));
		}
		elseif($cat=="general") {
			define('PAGETITLE', settitle(''.$_language->module['news'].' » Noticias generales'));
		}
		elseif($cat=="events") {
			define('PAGETITLE', settitle(''.$_language->module['news'].' » Eventos'));
		}
		elseif($cat=="blogs") {
			define('PAGETITLE', settitle(''.$_language->module['news'].' » Blogs'));
		}
		elseif($cat=="interviews") {
			define('PAGETITLE', settitle(''.$_language->module['news'].' » Entrevistas'));
		}
		else {
			define('PAGETITLE', settitle(''.$_language->module['news'].''));
			$breadcrumb = array(array('link' => 'index.php?site=news', 'text' => 'News'));
				breadcrumb($breadcrumb);
		}
		break; 
	
	case 'article': 
		if(isset($_GET['newsID'])) $newsID = (int)$_GET['newsID'];
		else $newsID = '';
		
		$message_array = array(); 
		$query=safe_query("SELECT n.* FROM ".PREFIX."news_contents n  WHERE n.newsID='".$newsID."'");
		while($qs = mysql_fetch_array($query)) {
			$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline']);
		}
		if(isset($_GET['lang'])) $showlang = getlanguageid($_GET['lang'], $message_array);
		else $showlang = select_language($message_array);
		
		$headline=$message_array[$showlang]['headline'];
		
		define('PAGETITLE', settitle(''.$_language->module['news'].' » '.$headline));
		$breadcrumb = array(array('link' => 'index.php?site=news', 'text' => $_language->module['news']),
							array('link' => 'index.php?site=article&newsID='.$newsID, 'text' => $headline));
		breadcrumb($breadcrumb);
		break;
	
	case 'newsletter':
		define('PAGETITLE', settitle($_language->module['newsletter']));
		$breadcrumb = array(array('link' => 'index.php?site=newsletter', 'text' => $_language->module['newsletter']));
		breadcrumb($breadcrumb);
		break;
		
	case 'funarea':
		define('PAGETITLE', settitle('Fun Area'));
		$breadcrumb = array(array('link' => 'index.php?site=funarea', 'text' => 'Fun Area'));
		breadcrumb($breadcrumb);
		break;
		
	case 'blog':	
		define('PAGETITLE', settitle('Blogs'));
		$breadcrumb = array(array('link' => 'index.php?site=blog', 'text' => 'Blogs'));
		breadcrumb($breadcrumb);
		break;
	
	case 'stories':	
		define('PAGETITLE', settitle('Prefab Stories'));
		$breadcrumb = array(array('link' => 'index.php?site=stories', 'text' => 'Prefab Stories'));
		breadcrumb($breadcrumb);
		break;
	
	case 'partners':
		define('PAGETITLE', settitle($_language->module['partners']));
		$breadcrumb = array(array('link' => 'index.php?site=partners', 'text' => 'Partners'));
		breadcrumb($breadcrumb);
		break;
	
	case 'partner':
	
		if(isset($_GET['partnerID'])) $partnerID = (int)$_GET['partnerID'];
		else $partnerID = '';
		
		$get=mysql_fetch_array(safe_query("SELECT name FROM `".PREFIX."partners` WHERE partnerID='$partnerID'"));
		define('PAGETITLE', settitle($_language->module['partners']));
		$breadcrumb = array(array('link' => 'index.php?site=partners', 'text' => 'Partners'),
							array('link' => 'index.php?site=partner&partnerID='.$partnerID, 'text' => $get['name']));
		breadcrumb($breadcrumb);
		break;
	
	case 'polls':
		if(isset($_GET['vote'])) $vote = (int)$_GET['vote'];
		else $vote = '';
		if(isset($_GET['pollID'])) $pollID = (int)$_GET['pollID'];
		else $pollID = '';
		if(isset($_GET['vote'])) {
			$vote = mysql_fetch_array(safe_query("SELECT titel FROM ".PREFIX."poll WHERE pollID='".$vote."'"));
			define('PAGETITLE', settitle($_language->module['polls'].'&nbsp; &raquo; &nbsp;'.$vote['titel']));
		}
		elseif(isset($_GET['pollID'])) {
			$pollID = mysql_fetch_array(safe_query("SELECT titel FROM ".PREFIX."poll WHERE pollID='".$pollID."'"));
			define('PAGETITLE', settitle($_language->module['polls'].'&nbsp; &raquo; &nbsp;'.$pollID['titel']));
		}
		else {
			define('PAGETITLE', settitle($_language->module['polls']));
		}
		break;
	
	case 'user': 
		if(isset($_GET['id'])) $id = (int)$_GET['id']; 
		else $id=''; 
		define('PAGETITLE', settitle('Perfil de '.getnickname($id))); 
		break; 
	
	case 'register':
		define('PAGETITLE', settitle($_language->module['register']));
		break;
	
	case 'registered_users':
		define('PAGETITLE', settitle($_language->module['registered_users']));
		break;
	
	case 'search':
		define('PAGETITLE', settitle($_language->module['search']));
		$breadcrumb = array(array('link' => 'index.php?site=search&news=true&movies=true&order=1&r=50&site=search&text=', 'text' => $_language->module['search']));
		breadcrumb($breadcrumb);
		break;
		
	case 'server':
		define('PAGETITLE', settitle($_language->module['server']));
		break;
		
	case 'shoutbox':
		define('PAGETITLE', settitle($_language->module['shoutbox']));
		break;
	
	case 'sponsors':
		define('PAGETITLE', settitle($_language->module['sponsors']));
		break;
	
	case 'teams':
		define('PAGETITLE', settitle($_language->module['teams'])); 
		break; 
	
	case 'team':
		if(isset($_GET['id'])) $teamID = (int)$_GET['id']; 
		else $teamID = ''; 
			$get=mysql_fetch_array(safe_query("SELECT name FROM `".PREFIX."songs` WHERE id='$teamID'")); 
			define('PAGETITLE', settitle(''.$_language->module['team'].' » '.$get['name'])); 
		
		break; 
	
	case 'static':
		if(isset($_GET['staticID'])) $staticID = (int)$_GET['staticID'];
		else $staticID = '';
		$get=mysql_fetch_array(safe_query("SELECT name FROM `".PREFIX."static` WHERE staticID='$staticID'"));
		define('PAGETITLE', settitle($get['name']));
		break;
	
	case 'usergallery':
		define('PAGETITLE', settitle($_language->module['usergallery']));
		break;
	
	case 'whoisonline':
		define('PAGETITLE', settitle($_language->module['whoisonline']));
		break;

	case 'media':
		define('PAGETITLE', settitle('Media'));
		break;

	case 'comments':
		define('PAGETITLE', settitle($_language->module['comments']));
		break;

	case 'crew':
if(isset($_GET['squadID'])) $squadID = (int)$_GET['squadID']; 
		else $squadID = ''; 
			$get=mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."squads` WHERE squadID='$squadID'")); 

		if($action=="show") {
                        if($squadID=="7") {
		             define('PAGETITLE', settitle('Staff'));
		        }
                        elseif($squadID=="8") {
		             define('PAGETITLE', settitle('Admin'));
		        }
		}
		else {
		        define('PAGETITLE', settitle('Crew'));
		}
		break;

	case 'archive':
		define('PAGETITLE', settitle('Archivo'));
		break;

    case 'videos':
		$id=$_GET['id'];
		$movcata=$_GET['movcatID'];
		
	$movcat=mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."movies` WHERE movID='$id'"));
	$movcatid=mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."movies` WHERE movcatID='$movcata'"));
	$movcatID = $movcat[movcatID];
	$movcatIDA = $movcata[movcatID];
	
	$linkpageheadline = $movcat[movheadline];

		if($action=="show") {
		        define('PAGETITLE', settitle('Videos » '.$movcat['movheadline']));
				$breadcrumb = array(array('link' => 'index.php?site=videos', 'text' => 'Videos'),
							  array('link' => 'index.php?site=videos&action=category&movcatID='.$movcatID, 'text' => getmovcat($movcatID)),
							  array('link' => 'index.php?site=videos&action=show&id='.$id, 'text' => $movcat['movheadline']));
				breadcrumb($breadcrumb);
		}
		elseif($action=="category") {
		        define('PAGETITLE', settitle('Videos » '.getmovcat($movcatIDA)));
				$breadcrumb = array(array('link' => 'index.php?site=videos', 'text' => 'Videos'),
							  array('link' => 'index.php?site=videos&action=category&movcatID='.$movcatIDA, 'text' => getmovcat($movcatIDA)));
				breadcrumb($breadcrumb);
		}
		else {
			define('PAGETITLE', settitle('Videos'));
			$breadcrumb = array(array('link' => 'index.php?site=videos', 'text' => 'Videos'));
			breadcrumb($breadcrumb);
		}
		break;

	case 'streams':
		if(isset($_GET['streamID'])) $streamID = (int)$_GET['streamID']; 
		else $streamID = ''; 
		
		if($streamID) {
			$get=mysql_fetch_array(safe_query("SELECT title FROM `".PREFIX."streams` WHERE streamID='$streamID'")); 
			define('PAGETITLE', settitle('Stream » '.$get['title'])); 
		}
		else {
			define('PAGETITLE', settitle('Streams')); 
		}
		break; 

	case 'matches':
		if(isset($_GET['upID'])) $upID = (int)$_GET['upID']; 
		else $upID = ''; 
			$get=mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."upcoming` WHERE upID='$upID'")); 

                if($action=="detalhes") {
		        define('PAGETITLE', settitle('Partido » '.getteamname($get['short']).' vs '.getteamname($get['opponent']).''));
		}
                else {
			define('PAGETITLE', settitle('Partidos')); 
                }
		break; 
		
		case 'match':
		if(isset($_GET['upID'])) $upID = (int)$_GET['upID']; 
		else $upID = ''; 
			$get=mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."upcoming` WHERE upID='$upID'")); 

		        define('PAGETITLE', settitle('Partido » '.getteamname($get['short']).' vs '.getteamname($get['opponent']).''));
                
		break; 

case 'rankings':
		if(isset($_GET['id'])) $id = (int)$_GET['id']; 
		else $id = ''; 
			$get=mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."songs` WHERE id='$id'")); 

                if($action=="team") {
		        define('PAGETITLE', settitle(''.$_language->module['team'].' » '.$get['name']));
		}
                elseif($action=="dota2") {
		        define('PAGETITLE', settitle('Rankings » Dota 2'));
		}
                elseif($action=="csgo") {
		        define('PAGETITLE', settitle('Rankings » Counter Strike Global Offensive'));
		}
                elseif($action=="heartstone") {
		        define('PAGETITLE', settitle('Rankings » Heartstone'));
		}
                elseif($action=="LoL") {
		        define('PAGETITLE', settitle('Rankings » League of Legends'));
		}
                else {
			define('PAGETITLE', settitle('Rankings')); 
                }
		break; 

case 'coverage':
		if(isset($_GET['id'])) $id = (int)$_GET['id']; 
		else $id = ''; 
			$get=mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."leagues` WHERE id='".$id."'")); 
                if($action=="event") {
					
						if($block=="matches") {
							define('PAGETITLE', settitle('Cobertura » '.getleaguename($get['id']).' » Partidos'));
						}
						elseif($block=="teams") {
							define('PAGETITLE', settitle('Cobertura » '.getleaguename($get['id']).' » Equipos'));
						}
						elseif($block=="brackets") {
							define('PAGETITLE', settitle('Cobertura » '.getleaguename($get['id']).' » Brackets'));
						}
						elseif($block=="groups") {
							define('PAGETITLE', settitle('Cobertura » '.getleaguename($get['id']).' » Grupos'));
						}
						else define('PAGETITLE', settitle('Cobertura » '.getleaguename($get['id']).''));
					
					
				}
				elseif($action=="terminado") {
					define('PAGETITLE', settitle('Cobertura Terminadas'));
				}
                
                else {
					define('PAGETITLE', settitle('Cobertura')); 
                }
		break; 
	
	default:
		define('PAGETITLE', settitle('Home'));
		break;
}
?>