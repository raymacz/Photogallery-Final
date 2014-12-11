<?php

//require_once('configz.php');
//require_once( '../includes/initialize.php');

class MySQL_DB  {
  
  private $db_connection;
  public $last_query;
  protected  $magic_quotes_active, $real_escape_string_exists;

  public function __construct() {
    $this->DBConnect();
    $this->magic_quotes_active = get_magic_quotes_gpc();
    $this->real_escape_string_exists= function_exists('mysql_real_escape_string');
  }
  
  public function DBConnect () {
   //db connection
    $this->db_connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
    if (!$this->db_connection) {
      die("Database connect failed: ".mysql_error());
    } else {
      $db_select =  mysql_select_db(DB_NAME, $this->db_connection) ;
      if (!$db_select) {
        die("Database selection failed: ".mysql_error());
      }
    }
  }
  
 public function DBQuery  ($sql) {
      //db to query
      $this->last_query = $sql;
      $result = mysql_query($sql, $this->db_connection);
      $this->DBConfirm($result);
      return $result;
  }    
  
  public function DBFetch ($result) {
      //db returned data
     //  return mysql_fetch_array($result);
       $x = mysql_fetch_array($result);
       return $x;
  }    
  
  public function DBClose () {
      //db close connection
    if (isset($db_connection)){
      mysql_close($db_connection);
      unset($db_connection);
    }
  }    
  
  public function DBConfirm ($value) {
        if (!$value) {
        die ($this->last_query."<br />"."Database query failed: ".mysql_error());
      }
  }
  
  public  function escape_value ($value) {
    if ($this->real_escape_string_exists) { //PHP v4.3.0 or higher
      //undo any magic quote effects to mysql_real_escape_string can do the work
      if ($this->magic_quotes_active) { $value = stripslashes($value); }
      $value = mysql_real_escape_string($value);
    } else { // before  PHP V4.3.0
      //if magic quotes aren't already on then add slashes manually
      if (!$this->magic_quotes_active) { $value = addslashes($value); }
      //if magic quotes are active, then the slashes already exist.
    }
    return $value;
  }
  
  public function num_rows($result) {     // # of rows
    return mysql_num_rows($result);
  }
  
  public function affected_rows() {    //rows affected by the query
    return mysql_affected_rows($this->db_connection);
  }
  
  public function insert_id() {    //  id info  on the  lastest query
    return mysql_insert_id($this->db_connection);
   }
  
 
}
 $Database = new MySQL_DB();
$DB =& $Database;
?>
