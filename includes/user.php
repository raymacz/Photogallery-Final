<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author owner
 */
//require_once ("configz.php");
//require_once ("database.php");
//require_once( '../includes/initialize.php');
require_once (L_PATH.DS."database.php");

class User extends Database_O {
  
  
  protected static $table_name = "users";
  public $id, $username, $first_name, $last_name, $password, $fullname;
  
  
  public function full_name() { // so u can pass variables between functions inside a class..
     //echo $this->record_set['first_name']." ". $this->record_set['last_name']."<br />";
     echo $this->first_name." ".$this->last_name."<br />";
  }
  
   public static function authenticate($username="", $password="") {
     $sql = "SELECT * from ".static::$table_name." WHERE username = '{$username}' AND ";
     $sql .= "password = '{$password}' LIMIT 1";
     
     $result_array = static::find_by_sql($sql);
     return !empty($result_array) ? array_shift($result_array) : FALSE;
   }

}

// $user_1 = new User();
//$u1 =& $user_1;
?>
