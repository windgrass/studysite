<?php

$movies_per_row = 1;

$_language->read_module('movies');

$filepath = "../images/movies/";

if ($_GET['action'] == "category") {

    $movcatID = $_GET['movcatID'];
    $page = $_GET['page'];
    $sort = $_GET['sort'];
    $type = $_GET['type'];

    $gesamt = mysql_num_rows(safe_query("SELECT movID FROM " . PREFIX . "movies WHERE movcatID='" . $movcatID . "' AND activated='2'"));
    $pages = 1;
    if (!isset($page)) $page = 1;
    if (!isset($sort)) $sort = "date";
    if (!isset($type)) $type = "DESC";

    $max = 10;

    for ($n = $max; $n <= $gesamt; $n += $max) {
        if ($gesamt > $n) $pages++;
    }

    if ($pages > 1) $page_link = makepagelink("index.php?site=videos&action=category&movcatID=$movcatID&sort=$sort&type=$type", $page, $pages);

    if ($page == "1") {
        $ergebnis = safe_query("SELECT * FROM " . PREFIX . "movies WHERE movcatID='" . $movcatID . "' AND activated='2' ORDER BY $sort $type LIMIT 0,$max");
        if ($type == "DESC") $n = $gesamt;
        else $n = 1;
    } else {
        $start = $page * $max - $max;
        $ergebnis = safe_query("SELECT * FROM " . PREFIX . "movies WHERE movcatID='" . $movcatID . "' AND activated='2' ORDER BY $sort $type LIMIT $start,$max");
        if ($type == "DESC") $n = ($gesamt) - $page * $max + $max;
        else $n = ($gesamt + 1) - $page * $max + $max;
    }
    if ($gesamt) {
        /*if ($type == "ASC") $seiten = '<a style="float: right" href="index.php?site=videos&action=category&movcatID=' . $movcatID . '&page=' . $page . '&sort=' . $sort . '&type=DESC">' . $_language->module['sort'] . ':  Desc.</a> ' . $page_link . '';
        else $seiten = '<a style="float: right" href="index.php?site=videos&action=category&movcatID=' . $movcatID . '&page=' . $page . '&sort=' . $sort . '&type=ASC">' . $_language->module['sort'] . ': Asc. </a> ' . $page_link . '';*/

        echo '<div class="grid grid_12 percentage">
				<h1 class="subtitle violet">Videos Category: ' . getmovcat($movcatID) . ' ' . $seiten . '</h1>
				<div class="ns_space20"></div>
				<div class="ns_divider left big"><span class="ns_bg_violet ns_radius"></span></div>
				<div class="ns_space10"></div>
			</div>';

        $i = 1;
        while ($ar = mysql_fetch_array($ergebnis)) {

            $hits = $ar[hits];
            $votes = $ar[votes];
            $type = getmovcat($ar[movcatID]);
            $movheadline = $ar[movheadline];
            $movID = $ar[movID];
            $uploader = getnickname($ar[uploader]);

            if ($ar[rating]) $ratingpic = '<img src="images/rating' . $ar[rating] . '.png" width="103" height="31" title="' . $ar[rating] . ' of 10; ' . $ar[votes] . ' votes" />';
            else $ratingpic = '<img src="images/rating0.png" width="103" height="31" title="no votes yet" />';

            if ($ar[movscreenshot]) {
                $pic = 'images/movies/' . $ar[movscreenshot] . '';
            } else {
                $pic = '' . $ar[movfile] . '';
            }

            eval ("\$movies_content = \"" . gettemplate("movies_content_a") . "\";");
            echo $movies_content;

            $i++;
        }

    } else {
        echo 'no entries!';
    }

} elseif ($_GET['action'] == "show") {
    $id = $_GET['id'];

    echo '<div class="grid grid_12 percentage">
				<h1 class="subtitle violet">Video</h1>
				<div class="ns_space20"></div>
				<div class="ns_divider left big"><span class="ns_bg_violet ns_radius"></span></div>
				<div class="ns_space20"></div>
			</div>';

    $movcat = mysql_fetch_array(safe_query("SELECT * FROM " . PREFIX . "movies WHERE movID=" . $id . ""));
    $movcatID = $movcat[movcatID];
    $linkpageheadline = $movcat[movheadline];

    if (isset($id)) {
        $res = safe_query("SELECT * FROM " . PREFIX . "movies WHERE movID=$id");
        if (mysql_num_rows($res)) {
            $ar = mysql_fetch_array($res);
            safe_query("UPDATE " . PREFIX . "movies SET hits=hits+1 WHERE movID=$id");
            $date = date("d.m.Y", $ar['date']);
            $time = date("H:i", $ar['date']);
            $votes = $ar['votes'];
            $movcatID = $ar[movcatID];
            $movcat = getmovcat($ar[movcatID]);
            $uploader = getnickname($ar[uploader]);
            $ytvcode = $ar[ytvcode];

            $hpselect = mysql_fetch_array(safe_query("SELECT hpurl FROM " . PREFIX . "settings"));

            if (eregi('http://', $hpselect[hpurl])) $page_link = "" . $hpselect[hpurl] . "/index.php?site=movies&action=show&id=" . $id . "";
            else $video_page_link = 'http://' . $hpselect[hpurl] . '/index.php?site=movies&action=show&id=' . $id . '';

            if ($ar[movdescription]) $des = $ar[movdescription];
            else $des = 'No Description';

            eval ("\$detailsembed = \"" . gettemplate("movies_details_embed") . "\";");
            echo $detailsembed;

        } else echo 'No Movie with ID ' . $id . ' available.';
    }

} else {

    echo '<div class="grid grid_12 percentage">
			<h1 class="subtitle violet">Last Videos</h1>
			<div class="ns_space20"></div>
			<div class="ns_divider left big"><span class="ns_bg_violet ns_radius"></span></div>
			<div class="ns_space10"></div>
		</div>';

    include('sc_videos_last.php');

}

?>