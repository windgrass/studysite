<?php

class fc_slider {

	static function get_setting($name = '') {
		if($name) {
			$res = mysql_fetch_array(safe_query("SELECT $name FROM ".PREFIX."songs_set LIMIT 0,1"));
			return count($res) == 1 ? $res[$name] : $res;
		}
	}

	// ADMINCENTER

	static function move_image_home($imgsrc,$pre) {
		if(is_uploaded_file($imgsrc['tmp_name'])) {
			$imgname = $pre.time()."_".$imgsrc["name"];
			if($move = move_uploaded_file($imgsrc['tmp_name'], '../images/leagues/'.$imgname)) {
				return $imgname;
			}
			else return false;
		}
		else {
			return false;
		}
	}
}
?>