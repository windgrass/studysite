<?php

chdir('../');
include("_mysql.php");
include("_settings.php");
include("_functions.php");
chdir('admin');

    $key=$_GET['key'];
    $array = array();


    $query=mysql_query("select * from ns_songs where name LIKE '%{$key}%'");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['name'];
    }
    echo json_encode($array);
?>
