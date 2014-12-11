<?php
//require_once (L_PATH.DS."database.php");//initialize.php to database.php
//require_once("../../includes/initialize.php");
class Database_O{
      protected static $db_fields_pgraph = array('id','filename','type', 'caption', 'size'); //this is based on database fields
      protected static $db_fields_cmment = array('id','photograph_id','created', 'author', 'body'); //this is based on database fields

  // common methods
 public function size_as_text(){ // display bytes as kb
     if ($this->size <1024) {
          return " {$this->size} bytes";
        } elseif ($this->size < 1048576) {
         $size_kb = round( $this->size/1024);
         return "  {$size_kb} KB";
        } else {
         $size_mb = round( $this->size/1048576, 1);
        return "  {$size_mb} MB";
        }
  }    
      
  public static  function find_by_id($id_num=0) {  // needs to be sanitized bcoz the id value is passed thru the  web entry // id must be sanitized always
    //$sql = "SELECT * from {static::$table_name} WHERE id = {$id_num}";
        $sql = "SELECT * from ".static::$table_name." WHERE id = {$id_num}";
     $record = self::find_by_sql($sql);
    // return $record;
     $record= array_shift($record);
     return !empty($record) ? $record : FALSE;
     //$this->full_name();
 } 

  public static function find_all() {   
   $sql = "SELECT * FROM ".static::$table_name;
    $record = self::find_by_sql($sql);
  return $record;
  } 
  
  public static function find_by_sql($sql="") {
    global $DB;
    $record_set= array();
    $result_set=$DB->DBQuery($sql);
       while ($row = $DB->DBFetch($result_set)) {
         $record_set[] = static::instantiate($row);
       }
        return $record_set;
  }
  
  private static function instantiate($user) { //if the user from the database matches the the objects 
    $classname = get_called_class();
    $object_user = new $classname;
    foreach ($user as $attrib => $value) {
      if ($object_user->has_attribute($attrib)) {
       $object_user->$attrib = $value;
      }
    }
    return $object_user;
  }
  
  private function has_attribute($new_attrib) { // if the new attrib exists in the inherited class
    $object_nstatic_prop = $this->get_object_prop(); //get_object_vars($this);  // get_object_vars gets the non_static properties of an object  // this function replaces get_object_vars()
    return array_key_exists($new_attrib, $object_nstatic_prop);  //checks attrib if exist on property/array
  }
  
  //================ class photograph
  private function get_object_prop() { //gets object attrib & value ready to be sanitized & return the new attribute
      //property exist?
      //if object is comment use this loop
      if (static::$table_name=="comments") {
        foreach (static::$db_fields_cmment as $field) {
          if (property_exists($this, $field)) { // if the child object's attribute exists in the parent object
             $new_object[$field] = $this->$field; 
          } 
        }
      } else {
        foreach (static::$db_fields_pgraph as $field) {
          if (property_exists($this, $field)) { // if the child object's attribute exists in the parent object
             $new_object[$field] = $this->$field; 
          } 
        }
      }
return $new_object;
  }
  
  private function sanitized_attribute() {  // sanitize all new attributes & its value
            //check if property exist before submitting, escape value to clean
     global $DB;
         $new_objects= $this->get_object_prop();
         $clean_attrib = array();
         foreach ($new_objects as $key => $value):
              $clean_attrib[$key] = $DB->escape_value($value); 
          endforeach;
          return $clean_attrib;
      
  }
  
  protected  function create() {
      global $DB;
       //sanitize     
      $attrib=$this->sanitized_attribute();
        // - INSERT INTO table (key, key) VALUES ('value', 'value')
        // - escape all values to prevent SQL injection
        $sql ="INSERT INTO ". static::$table_name." ("; 
// photograph::$table_name." ".user::$table_name //u can use each to determine which static parent
        $sql .=join(", ", array_keys($attrib));//"key, key"; // join($glue, $pieces);
        $sql .=" ) VALUES ('";        
        $sql .=implode("', '", array_values($attrib));//"key, key"; // implode($glue, $pieces);
        $sql .="')";
         //query
        if ($DB->DBquery($sql)) {
              //insert
            $this->id = $DB->insert_id();
            return TRUE;
        } else {return FALSE;}
  }
  
  protected  function delete() {
    global $DB;
              // - escape all values to prevent SQL injection
         // Don't forget your SQL syntax and good habits:
         // -DELETE FROM table WHERE condition LIMIT 1
    $sql = "DELETE FROM ".static::$table_name." WHERE id=";
    $sql .= $DB->escape_value($this->id)." LIMIT 1";
    $DB->DBquery($sql); //has built-in error-trap
   return $DB->affected_rows()? TRUE : FALSE; 
         
  }
  
  protected  function update() {   // needs to be sanitized bcoz the id value is passed thru the  web entry
        global $DB;
            // - UPDATE table SET key='value', key='value' WHERE condition
          $attrib=$this->sanitized_attribute();  
        //sanitize & move
        //sql join
        $sql = "UPDATE table SET ";
        $sql .= "key='value', key='value' ";
        $sql .= "WHERE id=1";
        $DB->DBquery($sql); //has built-in error-trap  //query
        return $DB->affected_rows()? TRUE : FALSE; //affected rows
    
   

  }
  
  public function save() {// cannot be  protected function since its called directly from photo.php;
      $pause=0;
    return isset($this->id) ? $this->update() :  $this->create();
  }
  
//  public function test1() {
//  // put this test to call from anywhere & observe how the inheritance works with a common child between two classes    
////     $u1->test1();
////    $Photo_c1->test1();
////    $pause=0;   
//   //===========================================   
//      $test_table =  static::$table_name;
//       $test_table = photograph::$table_name;
//      $this->test2();
//          $pause=0;
//  }
//  
//    protected function test2() {
//      $test_table =  static::$table_name;
//       $test_table = User::$table_name;
//        $pause=0;
//  }

}
 
     
?>
