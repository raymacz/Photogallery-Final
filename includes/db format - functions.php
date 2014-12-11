<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../configz.php';

//db connection

$db_connection = mysql_connect(DB_SERVER, DB_NAME, DB_PASS);
if ($db_connection) {
  die("Database connect failed: ".mysql_error());
}

//db to use
$db_select =  mysql_select_db(DB_NAME, $db_connection) ;
if ($db_select) {
  die("Database selection failed: ".mysql_error());
}

//db to query

$sql = "SELECT * FROM users";
$result = mysql_query($sql);
if ($result) {
  die ("Database query failed: ".mysql_error());
}

//db returned data
while ($row = mysql_fetch_array($result)) {
  //output
}


//db close connection
if (isset($db_connection)){
  mysql_close($db_connection);
  unset($db_connection);
}


