<?php

chdir('../');
include("_mysql.php");
include("_settings.php");
include("_functions.php");
chdir('admin');

$_language->read_module('admincenter');
$_lang_acb = new Language;
$_lang_acb -> set_language($_language->language);
$_lang_acb -> read_module('a_cash_box_admincenter'); 

if(isset($_GET['site'])) $site = $_GET['site'];
else
if(isset($site)) unset($site);

$admin=isanyadmin($userID);
if(!$loggedin) die($_language->module['not_logged_in']);
if(!$admin) die($_language->module['access_denied']);

if(!isset($_SERVER['REQUEST_URI'])) {
	$arr = explode("/", $_SERVER['PHP_SELF']);
	$_SERVER['REQUEST_URI'] = "/" . $arr[count($arr)-1];
	if ($_SERVER['argv'][0]!="")
	$_SERVER['REQUEST_URI'] .= "?" . $_SERVER['argv'][0];
}

if(!isanyadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

$username=''.getnickname($userID).'';
$lastlogin = date('d.m.Y, H:i',$_SESSION['ws_lastlogin']);
$firstname=''.getfirstname($userID).'';
$lastname=''.getlastname($userID).'';
$avatar=''.getavatar($userID).'';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $myclanname; ?> Admincenter</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $myclanname; ?> Admincenter">
    <meta name="author" content="http://www.nuno-silva.pt">

    <link rel="stylesheet" href="assets/css/styles.css?=121">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
     
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link href='assets/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 

    <script language="JavaScript" type="text/JavaScript"> var calledfrom='admin'; </script>
    <script src="../assets/js/bbcode.js" language="JavaScript" type="text/javascript"></script>
	<script type="text/javascript" src="../assets/js/jscolor/jscolor.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/jquery.bracket.min.css" />
    <script type="text/javascript" src="../js/jquery.bracket.min.js"></script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
  </style>
  
  <script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $( "#combobox" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#combobox" ).toggle();
    });
  });
  </script>

</head>

<body class="">

    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>

        <div class="navbar-header pull-left">
            <a class="navbar-brand" style="font-family: Source Sans Pro; font-size: 14px" href="admincenter.php"><?php echo "" . date("Y/m/d - H:i") . " (CET)"; ?></a>
        </div>

        <ul class="nav navbar-nav pull-right toolbar">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle username" data-toggle="dropdown"><span class="hidden-xs"><?php echo ''.$username.''; ?> <i class="fa fa-caret-down"></i></span><img src="<?php echo '../images/avatars/'.$avatar.''; ?>" /></a>
                <ul class="dropdown-menu userinfo arrow">
                    <li class="username">
                        <a href="#">
                            <div class="pull-left"><img class="userimg" src="<?php echo '../images/avatars/'.$avatar.''; ?>" /></div>
                            <div class="pull-right"><h5>Howdy, <?php echo $username; ?>!</h5><small>Last login: <span><?php echo $lastlogin; ?></span></small></div>
                        </a>
                    </li>
                    <li class="userlinks">
                        <ul class="dropdown-menu">
                            <li><a href="../index.php">Go to Frontpage</a></li>
                            <li class="divider"></li>
                            <li><a href="../logout.php" class="text-right">Sign Out</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </header>

    <div id="page-container">
        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
            <ul class="acc-menu" id="sidebar">
                <li><a href="admincenter.php?site=overview"><i class="fa fa-home"></i> <span>Overview</span></a></li>
                <li class="divider"></li>
    <?php if(isuseradmin($userID)) { ?>    
                <li><a href="javascript:;"><i class="fa fa-list-ol"></i> <span>User Administration</span></a>
                    <ul class='acc-menu'>
                        <li><a href="admincenter.php?site=users">Registered Users</a></li>
                        <!-- <li><a href="admincenter.php?site=squads">Teams / Non-Teams</a></li>
                        <li><a href="admincenter.php?site=members">Members</a></li>-->
						<li><a href="admincenter.php?site=contact">Contacts</a></li>
                        <li><a href="admincenter.php?site=newsletter">Subscribers</a></li>
                    </ul>
                </li> 
                <li class="divider"></li>
<?php } if(isnewsadmin($userID) || isnewswriter($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-pencil"></i> <span>News Options</span></a>
                    <ul class="acc-menu">
      <?php } if(isnewswriter($userID)) { ?>
                        <li><a onclick="MM_openBrWindow('../_news.php?action=new','News','toolbar=no,status=no,scrollbars=yes,width=800,height=600')" href="#">Post New Article</a></li>
      <?php } if(isnewsadmin($userID)) { ?>
                        <li><a href="admincenter.php?site=news">View Published Articles</a></li>
                        <li><a href="admincenter.php?site=news&action=unpublished">View Unpublished Articles</a></li>
                        <li><a href="admincenter.php?site=rubrics">News Categories</a></li>
                    </ul>
                </li>
                <!--<li class="divider"></li>
<?php } if(isnewsadmin($userID) || isnewswriter($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-smile-o"></i> <span>Fun</span></a>
                    <ul class="acc-menu">
      <?php } if(isnewswriter($userID)) { ?>
                        <li><a onclick="MM_openBrWindow('../_fun.php?action=new','News','toolbar=no,status=no,scrollbars=yes,width=800,height=600')" href="#">Post Fun</a></li>
      <?php } if(isnewsadmin($userID)) { ?>
                        <li><a href="admincenter.php?site=fun">View Fun</a></li>
                        <li><a href="admincenter.php?site=fun&action=unpublished">View Unpublished Fun</a></li>
                        <li><a href="admincenter.php?site=fun_rubrics">Fun Categories</a></li>
                    </ul>
                </li>-->
                <li class="divider"></li>
<?php } if(issuperadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-tasks"></i> <span>Content Options</span></a>
                    <ul class="acc-menu">
						<li><a href="admincenter.php?site=featuredcont">Background Image</a></li>
                        <li><a href="admincenter.php?site=features">FrontPage Features</a></li>
						<li><a href="admincenter.php?site=bannerrotation4">FrontPage Boxes</a></li>
                        <li><a href="admincenter.php?site=static"><?php echo $_language->module['static_pages']; ?></a></li>
                        <!--<li><a href="admincenter.php?site=partners">Partners</a></li>
						<li><a href="admincenter.php?site=partners_cat">Partners Categories</a></li>-->
                        <li><a href="admincenter.php?site=sponsors"><?php echo $_language->module['sponsors']; ?></a></li>
						<li><a href="admincenter.php?site=products">Products</a></li>						
						<li><a href="admincenter.php?site=products_cat">Products Categories</a></li>
                        <li><a href="admincenter.php?site=about">About Us</a></li>
                    </ul>
                </li>
                <!--<li class="divider"></li>    
                <li><a href="javascript:;"><i class="fa fa-bug"></i> <span>Anti-Spam Options</span></a>
                    <ul class="acc-menu">
                        <li><a href="admincenter.php?site=badmail">Forbidden Email Endings</a></li>
                        <li><a href="admincenter.php?site=badword">Badwords</a></li>
                    </ul>
                </li>-->
				<li class="divider"></li>    
                <li><a href="javascript:;"><i class="fa fa-table"></i> <span>Settings</span></a>
                    <ul class="acc-menu">
                        <li><a href="admincenter.php?site=lock">Page Lock</a></li>
                        <li><a href="admincenter.php?site=settings">Global Settings</a></li>
                        <li><a href="admincenter.php?site=countries">Country Flags</a></li>
                        <li><a href="admincenter.php?site=smileys">Smile Icons</a></li>
                        <li><a href="admincenter.php?site=database">Database</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
<!-- <?php } if(iscoverageadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-rss"></i> <span>Coverage</span></a>
                    <ul class="acc-menu">
                       <li><a href="admincenter.php?site=cobertura">Coverage Overview</a></li>
                       <li><a href="admincenter.php?site=cobertura&action=new">New Coverage</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
<?php } if(isleaguesadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-sitemap"></i> <span>Leagues</span></a>
                    <ul class="acc-menu">
                       <li><a href="admincenter.php?site=leagues">Leagues Overview</a></li>
                       <li><a href="admincenter.php?site=leagues&action=new">New League</a></li>
                       <li><a href="javascript:;">Groups</a>
                              <ul class="acc-menu">
                                   <li><a href="admincenter.php?site=groups&action=newgroup">Add New Group</a></li>
                                   <li><a href="admincenter.php?site=groups&action=newteamgroup">Add Team to Group</a></li>
                              </ul>
                       </li>
                    </ul>
                </li>
                <li class="divider"></li>
<?php } if(isteamsadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-trophy"></i> <span>Rankings</span></a>
                    <ul class="acc-menu">
                       <li><a href="admincenter.php?site=rankings">Rankings Overview</a></li>
                       <li><a href="admincenter.php?site=rankings&action=new">New Team</a></li>
                    </ul>
                </li>
                <li class="divider"></li> 
<?php } if(isgalleryadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-camera"></i> <span>Gallery</span> </a>
                    <ul class="acc-menu">
                       <li><a href="admincenter.php?site=gallery&amp;part=gallerys"><?php echo $_language->module['manage_galleries']; ?></a></li>
                       <li><a href="admincenter.php?site=galleries&groupID=1">Manage Pictures</a></li>
                    </ul>
                </li>
                <li class="divider"></li>  -->
<!-- 
<?php } if(ismatchesadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-gamepad"></i> <span>Matches</span></a>
                    <ul class="acc-menu">
                       <li><a href="admincenter.php?site=calendar">Matches Overview</a></li>
                       <li><a href="admincenter.php?site=calendar&action=adddate">New Match</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
<?php } if(isstreamsadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-video-camera"></i> <span>Streams</span></a>
                    <ul class="acc-menu">
                       <li><a href="admincenter.php?site=streams">Existing Streams</a></li>
                       <li><a href="admincenter.php?site=streams&action=add">New Stream</a></li>
                    </ul>
                </li>
                <li class="divider"></li> -->
<?php } if(isvideosadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-film"></i> <span>Videos</span> </a>
                    <ul class="acc-menu">
                       <li><a href="admincenter.php?site=movies">Existing Videos</a></li>
                       <li><a href="admincenter.php?site=movies&action=add">New Video</a></li>
                       <li><a href="javascript:;">Video Categories</a>
                          <ul class="acc-menu">
                            <li><a href="admincenter.php?site=movcat">Video Categories</a>
                            <li><a href="admincenter.php?site=movcat&action=add">Add Video Category</a>
                          </ul>
                       </li>
                    </ul>
                </li>
                <li class="divider"></li>
				<?php } if(isshopadmin($userID)) { ?>
				<!-- <li><a href="javascript:;"><i class="fa fa-shopping-cart"></i> <span>Shop</span> </a>
					 <ul class="acc-menu">
						<li><a href="admincenter.php?site=shop_settings"><?php echo $_language->module['shop_settings']; ?></a></li>
						<li><a href="admincenter.php?site=shopcategories"><?php echo $_language->module['shop_cat']; ?></a></li>
						<li><a href="admincenter.php?site=invoice"><?php echo $_language->module['invoices']; ?></a></li>
						<li><a href="admincenter.php?site=orders"><?php echo $_language->module['orders']; ?></a></li>
						<li><a href="admincenter.php?site=shoptemplates"><?php echo $_language->module['shoptemp']; ?></a></li>
						<li><a href="admincenter.php?site=support"><?php echo $_language->module['support']; ?></a></li>
					</ul>
				</li>
				<li class="divider"></li>  
				<?php } if(isforumadmin($userID)) { ?>
                <li><a href="javascript:;"><i class="fa fa-bullhorn"></i> <span>Forum</span> </a>
                    <ul class="acc-menu">
						<li><a href="admincenter.php?site=boards">Boards</a></li>
						<li><a href="admincenter.php?site=fgroups">Groups</a></li>
						<li><a href="admincenter.php?site=forumico">Forum Icons</a></li>
						<li><a href="admincenter.php?site=ranks">Ranks</a></li>
						<li><a href="admincenter.php?site=group-users">Manage Group users</a></li>
                    </ul>
                </li>
				<li class="divider"></li> -->
            </ul>
    <?php } ?>
            <!-- END SIDEBAR MENU -->
        </nav>

<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <?php if($site=="") echo '<li class="active"><a href="admincenter.php?site=overview">Overview</a></li>'; ?>
                <?php if($site=="overview") echo '<li class="active"><a href="admincenter.php?site=overview">Overview</a></li>'; ?>
                <?php if($site=="users") echo '<li>User Administration</li><li class="active"><a href="admincenter.php?site=users">Registered Users</a></li>'; ?>
                <?php if($site=="squads") echo '<li>User Administration</li><li class="active"><a href="admincenter.php?site=squads">Teams</a></li>'; ?>
                <?php if($site=="members") echo '<li>User Administration</li><li class="active"><a href="admincenter.php?site=members">Members</a></li>'; ?>
                <?php if($site=="contact") echo '<li>User Administration</li><li class="active"><a href="admincenter.php?site=contact">Contacts</a></li>'; ?>
                <?php if($site=="newsletter") echo '<li>User Administration</li><li class="active"><a href="admincenter.php?site=newsletter">Subscribers</a></li>'; ?>

                <?php if($site=="news") echo '<li>News Options</li><li class="active"><a href="admincenter.php?site=news">News</a></li>'; ?>
                <?php if($site=="rubrics") echo '<li>News Options</li><li class="active"><a href="admincenter.php?site=rubrics">News Categories</a></li>'; ?>
				<?php if($site=="fun") echo '<li>Fun Options</li><li class="active"><a href="admincenter.php?site=fun">Fun Posts</a></li>'; ?>
                <?php if($site=="fun_rubrics") echo '<li>Fun Options</li><li class="active"><a href="admincenter.php?site=fun_rubrics">Fun Categories</a></li>'; ?>
				
				<?php if($site=="featured_story") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=featured_story">Top Static Image</a></li>'; ?>
                <?php if($site=="features") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=features">Frontpage Features</a></li>'; ?>
				<?php if($site=="featuredcont") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=featuredcont">Background Image</a></li>'; ?>
                <?php if($site=="static") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=static">Static Pages</a></li>'; ?>
				<?php if($site=="products") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=products">Products</a></li>'; ?>
				<?php if($site=="products_cat") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=products_cat">Products Categories</a></li>'; ?>
                <?php if($site=="partners") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=partners">Partners</a></li>'; ?>
				<?php if($site=="partners_cat") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=partners_cat">Partners Categories</a></li>'; ?>
                <?php if($site=="about") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=about">About Us</a></li>'; ?>
                <?php if($site=="bannerrotation") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=bannerrotation">Streams Banner</a></li>'; ?>
                <?php if($site=="bannerrotation4") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=bannerrotation4">FrontPage Boxes</a></li>'; ?>
                <?php if($site=="bannerrotation3") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=bannerrotation3">Right Side Banner</a></li>'; ?>
                <?php if($site=="awards") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=awards">Awards</a></li>'; ?>
				<?php if($site=="scrolltext") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=scrolltext">Scrolltext</a></li>'; ?>
				<?php if($site=="maps") echo '<li>Content Options</li><li class="active"><a href="admincenter.php?site=maps">Maps</a></li>'; ?>

                <?php if($site=="clanwars") echo '<li>Results</li><li class="active"><a href="admincenter.php?site=clanwars">All Results</a></li>'; ?>
                <?php if($site=="clanwar_logos") echo '<li>Results</li><li class="active"><a href="admincenter.php?site=clanwar_logos">Logos</a></li>'; ?>
                <?php if($site=="clanwars_details") echo '<li>Results</li><li class="active"><a href="admincenter.php?site=clanwars_details">Result Details</a></li>'; ?>

                <?php if($site=="badmail") echo '<li>Anti-Spam Options</li><li class="active"><a href="admincenter.php?site=badmail">Forbidden Email Endings</a></li>'; ?>
                <?php if($site=="badword") echo '<li>Anti-Spam Options</li><li class="active"><a href="admincenter.php?site=badword">Badwords</a></li>'; ?>

                <?php if($site=="lock") echo '<li>Settings</li><li class="active"><a href="admincenter.php?site=lock">Page Lock</a></li>'; ?>
                <?php if($site=="settings") echo '<li>Settings</li><li class="active"><a href="admincenter.php?site=settings">Global Settings</a></li>'; ?>
                <?php if($site=="countries") echo '<li>Settings</li><li class="active"><a href="admincenter.php?site=countries">Country Icons</a></li>'; ?>
                <?php if($site=="games") echo '<li>Settings</li><li class="active"><a href="admincenter.php?site=games">Game Icons</a></li>'; ?>
                <?php if($site=="smileys") echo '<li>Settings</li><li class="active"><a href="admincenter.php?site=smileys">Smile Icons</a></li>'; ?>
				<?php if($site=="gameaccounts") echo '<li>Settings</li><li class="active"><a href="admincenter.php?site=gameaccounts">Game Accounts</a></li>'; ?>
                <?php if($site=="database") echo '<li>Settings</li><li class="active"><a href="admincenter.php?site=database">Database</a></li>'; ?>
				
				<?php if($site=="calendar") echo '<li class="active"><a href="admincenter.php?site=calendar">Matches</a></li>'; ?>

                <?php if($site=="rankings") echo '<li class="active"><a href="admincenter.php?site=rankings">Rankings</a></li>'; ?>

                <?php if($site=="leagues") echo '<li class="active"><a href="admincenter.php?site=leagues">Leagues</a></li>'; ?>

                <?php if($site=="groups") echo '<li class="active"><a href="#">Groups</a></li>'; ?>

                <?php if($site=="cobertura") echo '<li class="active"><a href="admincenter.php?site=cobertura">Coverage</a></li>'; ?>

                <?php if($site=="gallery") echo '<li>Gallery</li><li class="active"><a href="admincenter.php?site=gallery&part=gallerys">Manage Galleries</a></li>'; ?>
                <?php if($site=="galleries") echo '<li>Gallery</li><li class="active"><a href="admincenter.php?site=galleries">Manage Pictures</a></li>'; ?>
                <?php if($site=="streams") echo '<li class="active"><a href="admincenter.php?site=streams">Streams</a></li>'; ?>

                <?php if($site=="movies") echo '<li class="active"><a href="admincenter.php?site=movies">Videos</a></li>'; ?>
                <?php if($site=="movcat") echo '<li>Movies</li><li class="active"><a href="admincenter.php?site=movcat">Video Categories</a></li>'; ?>
				
				<?php if($site=="boards") echo '<li>Forum</li><li class="active"><a href="admincenter.php?site=boards">Boards</a></li>'; ?>
				<?php if($site=="fgroups") echo '<li>Forum</li><li class="active"><a href="admincenter.php?site=fgroups">Forum Groups</a></li>'; ?>
				<?php if($site=="group-users") echo '<li>Forum</li><li class="active"><a href="admincenter.php?site=group-users">Mange Group Users</a></li>'; ?>
				<?php if($site=="ranks") echo '<li>Forum</li><li class="active"><a href="admincenter.php?site=ranks">Ranks</a></li>'; ?>
				<?php if($site=="forumico") echo '<li>Forum</li><li class="active"><a href="admincenter.php?site=forumico">Forum Icons</a></li>'; ?>

				<?php if($site=="shop_settings") echo '<li>Shop</li><li class="active"><a href="admincenter.php?site=shop_settings">Shop Settings</a></li>'; ?>
				<?php if($site=="shopcategories") echo '<li>Shop</li><li class="active"><a href="admincenter.php?site=shopcategories">Shop Categories</a></li>'; ?>
				<?php if($site=="invoice") echo '<li>Shop</li><li class="active"><a href="admincenter.php?site=invoice">Invoices</a></li>'; ?>
				<?php if($site=="orders") echo '<li>Shop</li><li class="active"><a href="admincenter.php?site=orders">Orders</a></li>'; ?>
				<?php if($site=="shoptemplates") echo '<li>Shop</li><li class="active"><a href="admincenter.php?site=shoptemplates">Shop Templates</a></li>'; ?>
				<?php if($site=="support") echo '<li>Shop</li><li class="active"><a href="admincenter.php?site=support">Support</a></li>'; ?>

            </ol>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">

<?php if($site=="") echo '<div class="panel-heading"><h4>Overview</h4></div>'; ?>
<?php if($site=="overview") echo '<div class="panel-heading"><h4>Overview</h4></div>'; ?>
<?php if($site=="users") echo '<div class="panel-heading"><h4>Registered Users</h4></div>'; ?>
<?php if($site=="squads") echo '<div class="panel-heading"><h4>Teams</h4></div>'; ?>
<?php if($site=="members") echo '<div class="panel-heading"><h4>Members</h4></div>'; ?>
<?php if($site=="contact") echo '<div class="panel-heading"><h4>Contacts</h4></div>'; ?>
<?php if($site=="newsletter") echo '<div class="panel-heading"><h4>Subscribers</h4></div>'; ?>

<?php if($site=="featured_story") echo '<div class="panel-heading"><h4>Top Static Image</h4></div>'; ?>
<?php if($site=="news") echo '<div class="panel-heading"><h4>News Articles</h4></div>'; ?>
<?php if($site=="rubrics") echo '<div class="panel-heading"><h4>News Categories</h4></div>'; ?>

<?php if($site=="fun") echo '<div class="panel-heading"><h4>Fun Posts</h4></div>'; ?>
<?php if($site=="fun_rubrics") echo '<div class="panel-heading"><h4>Fun Categories</h4></div>'; ?>

<?php if($site=="features") echo '<div class="panel-heading"><h4>Frontpage Features</h4></div>'; ?>
<?php if($site=="featuredcont") echo '<div class="panel-heading"><h4>Background Image</h4></div>'; ?>
<?php if($site=="static") echo '<div class="panel-heading"><h4>Static Pages</h4></div>'; ?>
<?php if($site=="products") echo '<div class="panel-heading"><h4>Products</h4></div>'; ?>
<?php if($site=="products_cat") echo '<div class="panel-heading"><h4>Products Categories</h4></div>'; ?>
<?php if($site=="partners") echo '<div class="panel-heading"><h4>Partners</h4></div>'; ?>
<?php if($site=="partners_cat") echo '<div class="panel-heading"><h4>Partners Categories</h4></div>'; ?>
<?php if($site=="awards") echo '<div class="panel-heading"><h4>Awards</h4></div>'; ?>
<?php if($site=="scrolltext") echo '<div class="panel-heading"><h4>Scrolltext</h4></div>'; ?>
<?php if($site=="about") echo '<div class="panel-heading"><h4>About Us</h4></div>'; ?>
<?php if($site=="bannerrotation") echo '<div class="panel-heading"><h4>Streams Banner</h4></div>'; ?>
<?php if($site=="bannerrotation4") echo '<div class="panel-heading"><h4>FrontPage Boxes</h4></div>'; ?>
<?php if($site=="bannerrotation3") echo '<div class="panel-heading"><h4>Right Side Banner</h4></div>'; ?>

<?php if($site=="clanwars") echo '<div class="panel-heading"><h4>All Results</h4></div>'; ?>
<?php if($site=="clanwar_logos") echo '<div class="panel-heading"><h4>Logos</h4></div>'; ?>
<?php if($site=="maps") echo '<div class="panel-heading"><h4>Maps</h4></div>'; ?>
<?php if($site=="clanwars_details") echo '<div class="panel-heading"><h4>Result Details</h4></div>'; ?>

<?php if($site=="badmail") echo '<div class="panel-heading"><h4>Forbidden Email Endings</h4></div>'; ?>
<?php if($site=="badword") echo '<div class="panel-heading"><h4>Badwords</h4></div>'; ?>

<?php if($site=="lock") echo '<div class="panel-heading"><h4>Page Lock</h4></div>'; ?>
<?php if($site=="settings") echo '<div class="panel-heading"><h4>Global Settings</h4></div>'; ?>
<?php if($site=="countries") echo '<div class="panel-heading"><h4>Country Icons</h4></div>'; ?>
<?php if($site=="games") echo '<div class="panel-heading"><h4>Game Icons</h4></div>'; ?>
<?php if($site=="smileys") echo '<div class="panel-heading"><h4>Smile Icons</h4></div>'; ?>
<?php if($site=="gameaccounts") echo '<div class="panel-heading"><h4>Game Accounts</h4></div>'; ?>
<?php if($site=="database") echo '<div class="panel-heading"><h4>Database</h4></div>'; ?>

<?php if($site=="calendar") echo '<div class="panel-heading"><h4>Matches</h4></div>'; ?>

<?php if($site=="rankings") echo '<div class="panel-heading"><h4>Rankings</h4></div>'; ?>

<?php if($site=="leagues") echo '<div class="panel-heading"><h4>Leagues</h4></div>'; ?>

<?php if($site=="cobertura") echo '<div class="panel-heading"><h4>Coverage</h4></div>'; ?>

<?php if($site=="gallery") echo '<div class="panel-heading"><h4>Manage Galleries</h4></div>'; ?>
<?php if($site=="galleries") echo '<div class="panel-heading"><h4>Manage Pictures</h4></div>'; ?>

<?php if($site=="streams") echo '<div class="panel-heading"><h4>Streams</h4></div>'; ?>

<?php if($site=="movies") echo '<div class="panel-heading"><h4>Video</h4></div>'; ?>
<?php if($site=="movcat") echo '<div class="panel-heading"><h4>Video Categories</h4></div>'; ?>

<?php if($site=="boards") echo '<div class="panel-heading"><h4>Boards</h4></div>'; ?>
<?php if($site=="groups") echo '<div class="panel-heading"><h4>Groups</h4></div>'; ?>
<?php if($site=="fgroups") echo '<div class="panel-heading"><h4>Forum Groups</h4></div>'; ?>
<?php if($site=="group-users") echo '<div class="panel-heading"><h4>Manage Group Users</h4></div>'; ?>
<?php if($site=="ranks") echo '<div class="panel-heading"><h4>Ranks</h4></div>'; ?>
<?php if($site=="forumico") echo '<div class="panel-heading"><h4>Forum Icons</h4></div>'; ?>

<?php if($site=="shop_settings") echo '<div class="panel-heading"><h4>Shop Settings</h4></div>'; ?>
<?php if($site=="shopcategories") echo '<div class="panel-heading"><h4>Shop Categories</h4></div>'; ?>
<?php if($site=="invoice") echo '<div class="panel-heading"><h4>Invoices</h4></div>'; ?>
<?php if($site=="orders") echo '<div class="panel-heading"><h4>Orders</h4></div>'; ?>
<?php if($site=="shoptemplates") echo '<div class="panel-heading"><h4>Shop Templates</h4></div>'; ?>
<?php if($site=="support") echo '<div class="panel-heading"><h4>Support</h4></div>'; ?>

                      <div class="panel-body">
                            <?php
   if(isset($site)){
   $invalide = array('\\','/','//',':','.');
   $site = str_replace($invalide,' ',$site);
   	if(file_exists($site.'.php')) include($site.'.php');
   	else include('overview.php');
   }
   else include('overview.php');
   ?>
                      </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!--wrap -->
</div> <!-- page-content -->

    <footer role="contentinfo">
        <div class="clearfix">
            <ul class="list-unstyled list-inline pull-left">
                <li><?php echo $myclanname; ?> &copy; 2017</li>
                <li> // </li>
                <li>Developed by <a href="http://www.nuno-silva.pt">Nuno Silva</a></li>
            </ul>
            <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
        </div>
    </footer>

</div> <!-- page-container -->

<script type='text/javascript' src='assets/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='assets/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='assets/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='assets/js/enquire.js'></script> 
<script type='text/javascript' src='assets/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='assets/js/jquery.nicescroll.min.js'></script> 
<script type='text/javascript' src='assets/plugins/codeprettifier/prettify.js'></script> 
<script type='text/javascript' src='assets/plugins/easypiechart/jquery.easypiechart.min.js'></script> 
<script type='text/javascript' src='assets/plugins/sparklines/jquery.sparklines.min.js'></script> 
<script type='text/javascript' src='assets/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='assets/js/placeholdr.js'></script> 
<script type='text/javascript' src='assets/js/application.js'></script> 
<script type='text/javascript' src='assets/demo/demo.js'></script> 

</body>
</html>