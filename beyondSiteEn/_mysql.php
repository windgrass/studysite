<?php
	 $host = "localhost:3306";
	 $user = "root";
	 $pwd = "toor";
	 $db = "bysite";
	 define("PREFIX", 'ns_');

// *************** PHP7 START ***************
// resolve mysql_* functions  compatibility
$dbhost = $host;
$dbport = 3306;
$dbuser = $user;
$dbpass = $pwd;
$dbname = $db;
if(!function_exists('mysql_pconnect')){
    $mysqli = mysqli_connect("$dbhost:$dbport", $dbuser, $dbpass, $dbname);
    function mysql_pconnect($dbhost, $dbuser, $dbpass){
        global $dbport;
        global $dbname;
        global $mysqli;
        $mysqli = mysqli_connect("$dbhost:$dbport", $dbuser, $dbpass, $dbname);
        return $mysqli;
    }
    function mysql_select_db($dbname){
        global $mysqli;
        return mysqli_select_db($mysqli,$dbname);
    }
    function mysql_fetch_array($result){
        return mysqli_fetch_array($result);
    }
    function mysql_fetch_assoc($result){
        return mysqli_fetch_assoc($result);
    }
    function mysql_fetch_row($result){
        return mysqli_fetch_row($result);
    }
    function mysql_query($query){
        global $mysqli;
        return mysqli_query($mysqli,$query);
    }
    function mysql_escape_string($data){
        global $mysqli;
        return mysqli_real_escape_string($mysqli, $data);
        //return addslashes(trim($data));
    }
    function mysql_real_escape_string($data){
        global $mysqli;
        return mysqli_real_escape_string($mysqli, $data);
    }
    function mysql_close(){
        global $mysqli;
        return mysqli_close($mysqli);
    }
    function mysql_errno(){
        global $mysqli;
        return mysqli_errno($mysqli);
    }
    function mysql_error(){
        global $mysqli;
        return mysqli_error($mysqli);
    }
    function mysql_num_rows($result)
    {
        return mysqli_num_rows($result);
    }
}
?>