<?php
$link = mysql_connect("DBURL", "DBUSERNAME", "DBPASSWORD") or die("Couldn't make connection.");
$db = mysql_select_db("DBNAME", $link) or die("Couldn't select database");
?>
