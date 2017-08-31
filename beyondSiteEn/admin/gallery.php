<?php

$_language->read_module('gallery');

if(!isgalleryadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

$galclass = new Gallery;

if(isset($_GET['part'])) $part = $_GET['part'];
else $part = '';
if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

if($part=="groups") {

	if(isset($_POST['save'])) {
		$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
			if(checkforempty(Array('name'))) safe_query("INSERT INTO ".PREFIX."gallery_groups ( name, sort ) values( '".$_POST['name']."', '1' ) ");
			else echo $_language->module['information_incomplete'];
		} else echo $_language->module['transaction_invalid'];
	}
  
	elseif(isset($_POST['saveedit'])) {
	 	$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
			if(checkforempty(Array('name'))) safe_query("UPDATE ".PREFIX."gallery_groups SET name='".$_POST['name']."' WHERE groupID='".$_POST['groupID']."'");
			else echo $_language->module['information_incomplete'];
		} else echo $_language->module['transaction_invalid'];
	}
  
	elseif(isset($_POST['sort'])) {
	 	$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
			if(isset($_POST['sortlist'])){
				if(is_array($_POST['sortlist'])) {
					foreach($_POST['sortlist'] as $sortstring) {
						$sorter=explode("-", $sortstring);
						safe_query("UPDATE ".PREFIX."gallery_groups SET sort='$sorter[1]' WHERE groupID='$sorter[0]' ");
					}
				}
			}
		} else echo $_language->module['transaction_invalid'];
	}
  
	elseif(isset($_GET['delete'])) {
	 	$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
			$db_result=safe_query("SELECT * FROM ".PREFIX."gallery WHERE groupID='".$_GET['groupID']."'");
			$any=mysql_num_rows($db_result);
			if($any){
				echo $_language->module['galleries_available'].'<br /><br />';
			}
			else{
				safe_query("DELETE FROM ".PREFIX."gallery_groups WHERE groupID='".$_GET['groupID']."'");
			}
		} else echo $_language->module['transaction_invalid'];
	}

	if($action=="add") {
    $CAPCLASS = new Captcha;
    $CAPCLASS->create_transaction();
    $hash = $CAPCLASS->get_hash();
        
    echo'<form method="post" action="admincenter.php?site=gallery&amp;part=groups">
    <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['add_group'].'</td>
    </tr>
      <tr>
        <td width="15%"><b>'.$_language->module['group_name'].'</b></td>
        <td width="85%"><input type="text" name="name" size="60" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
        <td><input type="submit" name="save" value="'.$_language->module['add_group'].'" /></td>
      </tr>
    </table>
    </form>';
	}
  
	elseif($action=="edit") {
    $CAPCLASS = new Captcha;
    $CAPCLASS->create_transaction();
    $hash = $CAPCLASS->get_hash();
		$ergebnis=safe_query("SELECT * FROM ".PREFIX."gallery_groups WHERE groupID='".$_GET['groupID']."'");
		$ds=mysql_fetch_array($ergebnis);
    
    echo'<form method="post" action="admincenter.php?site=gallery&amp;part=groups">
    <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['edit_group'].'</td>
    </tr>
      <tr>
        <td width="15%"><b>'.$_language->module['group_name'].'</b></td>
        <td><input type="text" name="name" size="60" value="'.getinput($ds['name']).'" /></td>
      </tr>
      <tr>
        <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="groupID" value="'.$ds['groupID'].'" /></td>
        <td><input type="submit" name="saveedit" value="'.$_language->module['edit_group'].'" /></td>
      </tr>
    </table>
    </form>';
	}
  
	else {

    echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=gallery&amp;part=groups&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['new_group'].'" /><br /><br />';

		$ergebnis=safe_query("SELECT * FROM ".PREFIX."gallery_groups ORDER BY sort");
		
    echo'<form method="post" name="ws_gallery" action="admincenter.php?site=gallery&amp;part=groups">
    <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
      <tr>
        <td width="70%" class="title"><b>'.$_language->module['group_name'].'</b></td>
        <td width="20%" class="title"><b>'.$_language->module['actions'].'</b></td>
        <td width="10%" class="title"><b>'.$_language->module['sort'].'</b></td>
      </tr>';
      
		$n=1;
		$CAPCLASS = new Captcha;
    $CAPCLASS->create_transaction();
    $hash = $CAPCLASS->get_hash();
    
    while($ds=mysql_fetch_array($ergebnis)) {
      if($n%2) { $td='td1'; }
			else { $td='td2'; }
			
			$list = '<select name="sortlist[]">';
			for($i=1;$i<=mysql_num_rows($ergebnis);$i++) {
				$list.='<option value="'.$ds['groupID'].'-'.$i.'">'.$i.'</option>';
			}
			$list .= '</select>';
			$list = str_replace('value="'.$ds['groupID'].'-'.$ds['sort'].'"','value="'.$ds['groupID'].'-'.$ds['sort'].'" selected="selected"',$list);

			echo'<tr>
        <td class="'.$td.'">'.$ds['name'].'</td>
        <td class="'.$td.'" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=gallery&amp;part=groups&amp;action=edit&amp;groupID='.$ds['groupID'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
        <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete_group'].'\', \'admincenter.php?site=gallery&amp;part=groups&amp;delete=true&amp;groupID='.$ds['groupID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_language->module['delete'].'" /></td>
        <td class="'.$td.'" align="center">'.$list.'</td>
		 	</tr>';
      $n++;
		}
		echo'<tr>
      <td class="td_head" colspan="3" align="right"><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="submit" name="sort" value="'.$_language->module['to_sort'].'" /></td>
      </tr>
    </table>
    </form>';
	}
}

//part: gallerys

elseif($part=="gallerys") {

	if(isset($_POST['save'])) {
	 	$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
			if(checkforempty(Array('name'))) {
				safe_query("INSERT INTO ".PREFIX."gallery ( name, link1, thumb, date, groupID ) values( '".$_POST['name']."', '".$_POST['link1']."', '".$_POST['thumb']."', '".time()."', '".$_POST['group']."' ) ");
				$id = mysql_insert_id();
			} else echo $_language->module['information_incomplete'];
		} else echo $_language->module['transaction_invalid'];
	}
  
	elseif(isset($_POST['saveedit'])) {
	 	$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
			if(checkforempty(Array('name'))) {
				if(!isset($_POST['group'])) {
					$_POST['group'] = 0;
				}
				safe_query("UPDATE ".PREFIX."gallery SET name='".$_POST['name']."', link1='".$_POST['link1']."', thumb='".$_POST['thumb']."', groupID='".$_POST['group']."' WHERE galleryID='".$_POST['galleryID']."'");
			} else echo $_language->module['information_incomplete'];
		} else echo $_language->module['transaction_invalid'];
	}
  
	elseif(isset($_POST['saveftp'])) {

		$dir = '../images/gallery/';
		$pictures = array();
		if(isset($_POST['comment'])) $comment = $_POST['comment'];
		if(isset($_POST['name'])) $name = $_POST['name'];
    	if(isset($_POST['pictures'])) $pictures = $_POST['pictures'];
		$i=0;
		$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		    foreach($pictures as $picture) {
					$typ = getimagesize($dir.$picture);
					switch ($typ[2]) {
						case 1: $typ = '.gif'; break;
						case 2: $typ = '.jpg'; break;
						case 3: $typ = '.png'; break;
					}
		
					if($name[$i]) $insertname = $name[$i];
					else $insertname = $picture;
					safe_query("INSERT INTO ".PREFIX."gallery_pictures ( galleryID, name, comment, comments) VALUES ('".$_POST['galleryID']."', '".$insertname."', '".$comment[$i]."', '".$_POST['comments']."' )");
					$insertid = mysql_insert_id();
					copy($dir.$picture, $dir.'large/'.$insertid.$typ);
					$galclass->savethumb($dir.'large/'.$insertid.$typ, $dir.'thumb/'.$insertid.'.jpg');
					@unlink($dir.$picture);
					$i++;
				}
		} else echo $_language->module['transaction_invalid'];
	}
	elseif(isset($_POST['saveform'])) {

		$dir = '../images/gallery/';
		$picture = $_FILES['picture'];
		$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
			if($picture['name'] != "") {
				if($_POST['name']) $insertname = $_POST['name'];
				else $insertname = $picture['name'];
				safe_query("INSERT INTO ".PREFIX."gallery_pictures ( galleryID, name, comment, comments) VALUES ('".$_POST['galleryID']."', '".$insertname."', '".$_POST['comment']."', '".$_POST['comments']."' )");
				$insertid = mysql_insert_id();
	
				$typ = getimagesize($picture['tmp_name']);
				switch ($typ[2]) {
					case 1: $typ = '.gif'; break;
					case 2: $typ = '.jpg'; break;
					case 3: $typ = '.png'; break;
				}
	
				move_uploaded_file($picture['tmp_name'], $dir.'large/'.$insertid.$typ);
				$galclass->savethumb($dir.'large/'.$insertid.$typ, $dir.'thumb/'.$insertid.'.jpg');
			}
		} else echo $_language->module['transaction_invalid'];
	}
  
	elseif(isset($_GET['delete'])) {
		//SQL
		$CAPCLASS = new Captcha;
		if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
			if(safe_query("DELETE FROM ".PREFIX."gallery WHERE galleryID='".$_GET['galleryID']."'")) {
				//FILES

				$ergebnis=safe_query("SELECT picID FROM ".PREFIX."gallery_pictures WHERE galleryID='".$_GET['galleryID']."'");
				while($ds=mysql_fetch_array($ergebnis)) {
					@unlink('../images/gallery/thumb/'.$ds['picID'].'.jpg'); //thumbnails
	
					$path = '../images/gallery/large/';
					if(file_exists($path.$ds['picID'].'.jpg')) $path = $path.$ds['picID'].'.jpg';
					elseif(file_exists($path.$ds['picID'].'.png')) $path = $path.$ds['picID'].'.png';
					else $path = $path.$ds['picID'].'.gif';
					@unlink($path); //large
					safe_query("DELETE FROM ".PREFIX."comments WHERE parentID='".$ds['picID']."' AND type='ga'");
				}
				safe_query("DELETE FROM ".PREFIX."gallery_pictures WHERE galleryID='".$_GET['galleryID']."'");
			}
		} else echo $_language->module['transaction_invalid'];
	}
  
	if($action=="add") {
    $ergebnis=safe_query("SELECT * FROM ".PREFIX."gallery_groups");
		$any=mysql_num_rows($ergebnis);
		if($any){
			$groups = '<select name="group">';
			while($ds=mysql_fetch_array($ergebnis)) {
				$groups.='<option value="'.$ds['groupID'].'">'.getinput($ds['name']).'</option>';
			}
			$groups.='</select>';
	    $CAPCLASS = new Captcha;
	    $CAPCLASS->create_transaction();
	    $hash = $CAPCLASS->get_hash();
	    	    
	    echo'<form method="post" action="admincenter.php?site=gallery&amp;part=gallerys&amp;action=upload">
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['add_gallery'].'</td>
    </tr>
	      <tr>
	        <td width="15%"><b>'.$_language->module['gallery_name'].'</b></td>
	        <td width="85%"><input type="text" name="name" size="60" /></td>
	      </tr>
	      <tr>
	        <td width="15%"><b>Link</b></td>
	        <td width="85%"><input type="text" name="link1" size="60" /> (with http:// in the beginning. Example: http://www.facebook.com)</td>
	      </tr>
	      <tr>
	        <td width="15%"><b>Thumbnail Link</b></td>
	        <td width="85%"><input type="text" name="thumb" size="60" /> (with http:// in the beginning. Example: http://www.facebook.com)</td>
	      </tr>
	      <tr>
	        <td><b>'.$_language->module['group'].'</b></td>
	        <td>'.$groups.'</td>
	      </tr>
	      <tr>
	        <td><b>'.$_language->module['pic_upload'].'</b></td>
	        <td><select name="upload">
	          <option value="ftp">'.$_language->module['ftp'].'</option>
	          <option value="form">'.$_language->module['formular'].'</option>
	        </select></td>
	      </tr>
	      <tr>
	        <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
	        <td><input type="submit" name="save" value="'.$_language->module['add_gallery'].'" /></td>
	      </tr>
	    </table>
	    </form>
	    <br /><small>'.$_language->module['ftp_info'].' "http://'.$hp_url.'/images/gallery"</small>';
	  }
	  else{
	  	echo '<br>'.$_language->module['need_group'];
	  }
	}
  
	elseif($action=="edit") {
    $CAPCLASS = new Captcha;
    $CAPCLASS->create_transaction();
    $hash = $CAPCLASS->get_hash();
		$ergebnis=safe_query("SELECT * FROM ".PREFIX."gallery_groups");
		$groups = '<select name="group">';
		while($ds=mysql_fetch_array($ergebnis)) {
			$groups.='<option value="'.$ds['groupID'].'">'.getinput($ds['name']).'</option>';
		}
		$groups.='</select>';

		$ergebnis=safe_query("SELECT * FROM ".PREFIX."gallery WHERE galleryID='".$_GET['galleryID']."'");
		$ds=mysql_fetch_array($ergebnis);

		$groups = str_replace('value="'.$ds['groupID'].'"','value="'.$ds['groupID'].'" selected="selected"',$groups);
    
    echo'<form method="post" action="admincenter.php?site=gallery&amp;part=gallerys">
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['edit_gallery'].'</td>
    </tr>
      <tr>
        <td width="15%"><b>'.$_language->module['gallery_name'].'</b></td>
        <td width="85%"><input type="text" name="name" value="'.getinput($ds['name']).'" /></td>
      </tr>
<tr>
	        <td width="15%"><b>Link</b></td>
	        <td width="85%"><input type="text" name="link1" value="'.getinput($ds['link1']).'" size="60" /> (with http:// in the beginning. Example: http://www.facebook.com)</td>
	      </tr>
	      <tr>
	        <td width="15%"><b>Thumbnail Link</b></td>
	        <td width="85%"><input type="text" name="thumb" value="'.getinput($ds['thumb']).'" size="60" /> (with http:// in the beginning. Example: http://www.facebook.com)</td>
	      </tr>';
      
		if($ds['userID'] != 0) echo '
      <tr>
        <td><b>'.$_language->module['usergallery_of'].'</b></td>
        <td><a href="../index.php?site=profile&amp;id='.$userID.'" target="_blank">'.getnickname($ds['userID']).'</a></td>
      </tr>';
		else echo '<tr>
        <td><b>'.$_language->module['group'].'</b></td>
        <td>'.$groups.'</td>
      </tr>';
		echo'<tr>
        <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="galleryID" value="'.$ds['galleryID'].'" /></td>
        <td><input type="submit" name="saveedit" value="'.$_language->module['edit_gallery'].'" /></td>
      </tr>
    </table>
    </form>';
	}
  
	elseif($action=="upload") {
  
		$dir = '../images/gallery/';
    	if(isset($_POST['upload'])) $upload_type = $_POST['upload'];
    	elseif(isset($_GET['upload'])) $upload_type = $_GET['upload'];
    	else $upload_type = null;
		if(isset($_GET['galleryID'])) $id=$_GET['galleryID'];
    	
		if($upload_type == "ftp") {
      		$CAPCLASS = new Captcha;
      		$CAPCLASS->create_transaction();
      		$hash = $CAPCLASS->get_hash();
			
      		echo'<form method="post" action="admincenter.php?site=gallery&amp;part=gallerys">
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="4" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['upload'].'</td>
    </tr>
		        <tr>
		          ';
		
			$pics = Array();
			$picdir = opendir($dir);
			while (false !== ($file = readdir($picdir))) {
				if ($file != "." && $file != "..") {
					if(is_file($dir.$file)) {
						if($info = getimagesize($dir.$file)) {
							if($info[2]==1 OR $info[2]==2 || $info[2]==3) $pics[] = $file;
						}
					}
				}
			}
			closedir($picdir);
			natcasesort ($pics);
			reset ($pics);
					
		    echo '<td></td>
		          <td><b>'.$_language->module['filename'].'</b></td>
		          <td><b>'.$_language->module['name'].'</b></td>
		          <td><b>'.$_language->module['comment'].'</b></td>
		        </tr>';
		
			foreach($pics as $val) {
				if(is_file($dir.$val)) {
							
					echo '<tr>
		            <td><input type="checkbox" value="'.$val.'" name="pictures[]" checked="checked" /></td>
		            <td><a href="'.$dir.$val.'" target="_blank">'.$val.'</a></td>
		            <td><input type="text" name="name[]" size="40" /></td>
		            <td><input type="text" name="comment[]" size="40" /></td>
		          </tr>';
		
				}
			}

			echo '
		          <tr>
		            <td colspan="4"><br /><b>'.$_language->module['visitor_comments'].'</b> &nbsp;
		            <select name="comments">
		              <option value="0">'.$_language->module['disable_comments'].'</option>
		              <option value="1">'.$_language->module['enable_user_comments'].'</option>
		            </select></td>
		          </tr>
		          <tr>
		            <td colspan="4"><br /><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="galleryID" value="'.$id.'" />
		            <input type="submit" name="saveftp" value="'.$_language->module['upload'].'" /></td>
		          </tr>
		        </table>
		        </form>';
        
		} elseif($upload_type == "form") {
    
      		$CAPCLASS = new Captcha;
      		$CAPCLASS->create_transaction();
      		$hash = $CAPCLASS->get_hash();

			echo'<form method="post" action="admincenter.php?site=gallery&amp;part=gallerys" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Picture Details</td>
    </tr>
        <tr>
          <td width="15%"><b>'.$_language->module['name'].'</b></td>
          <td width="85%"><input type="text" name="name" size="60" /></td>
        </tr>
        <tr>
          <td><b>'.$_language->module['comment'].'</b></td>
          <td><input type="text" name="comment" size="60" maxlength="255" /></td>
        </tr>
        <tr>
          <td><b>'.$_language->module['visitor_comments'].'</b></td>
          <td><select name="comments">
            <option value="0">'.$_language->module['disable_comments'].'</option>
            <option value="1">'.$_language->module['enable_user_comments'].'</option>
          </select></td>
        </tr>
        <tr>
          <td><b>'.$_language->module['picture'].'</b></td>
          <td><input name="picture" type="file" size="40" /></td>
        </tr>
        <tr>
          <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="galleryID" value="'.$id.'" /></td>
          <td><input type="submit" name="saveform" value="'.$_language->module['upload'].'" /></td>
        </tr>
      </table>
      </form>';
		}
	}
  
	else {
    
    echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=gallery&amp;part=gallerys&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['new_gallery'].'" /><br /><br />';

		echo'<form method="post" name="ws_gallery" action="admincenter.php?site=gallery&amp;part=gallerys">
		<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
      <tr>
        <td width="50%" class="title"><b>'.$_language->module['gallery_name'].'</b></td>
        <td width="50%" class="title" colspan="2"><b>'.$_language->module['actions'].'</b></td>
      </tr>';

		$ergebnis=safe_query("SELECT * FROM ".PREFIX."gallery_groups ORDER BY sort");
    
    while($ds=mysql_fetch_array($ergebnis)) {
		
    echo'<tr>
      <td class="td_head" colspan="3"><b>'.getinput($ds['name']).'</b></td>
    </tr>';		 

		$galleries=safe_query("SELECT * FROM ".PREFIX."gallery WHERE groupID='$ds[groupID]' AND userID='0' ORDER BY date");
    
    $CAPCLASS = new Captcha;
    $CAPCLASS->create_transaction();
    $hash = $CAPCLASS->get_hash();
    $i=1;
		
      while($db=mysql_fetch_array($galleries)) {
			  if($i%2) { $td='td1'; }
			  else { $td='td2'; }
      
        echo'<tr>
          <td class="'.$td.'" width="50%"><a href="../index.php?site=gallery&amp;galleryID='.$db['galleryID'].'" target="_blank">'.getinput($db['name']).'</a></td>
          <td class="'.$td.'" width="30%" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=gallery&amp;part=gallerys&amp;action=upload&amp;upload=form&amp;galleryID='.$db['galleryID'].'\');return document.MM_returnValue" value="'.$_language->module['add_img'].' ('.$_language->module['per_form'].')" style="margin:1px;" /> <input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=gallery&amp;part=gallerys&amp;action=upload&amp;upload=ftp&amp;galleryID='.$db['galleryID'].'\');return document.MM_returnValue" value="'.$_language->module['add_img'].' ('.$_language->module['per_ftp'].')" style="margin:1px;" /></td>
          <td class="'.$td.'" width="20%" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=gallery&amp;part=gallerys&amp;action=edit&amp;galleryID='.$db['galleryID'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
          <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete_gallery'].'\', \'admincenter.php?site=gallery&amp;part=gallerys&amp;delete=true&amp;galleryID='.$db['galleryID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_language->module['delete'].'" /></td>
        </tr>';
      
      $i++;
		  }
    }
		echo'</table></form><br /><br />';
    
		$ergebnis=safe_query("SELECT * FROM ".PREFIX."gallery WHERE userID!='0'");
		     
    $CAPCLASS = new Captcha;
    $CAPCLASS->create_transaction();
    $hash = $CAPCLASS->get_hash();
    
		$i=1;
   
	}
}
?>