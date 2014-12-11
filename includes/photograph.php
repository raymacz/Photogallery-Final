<?php
require_once (L_PATH.DS."database.php");//initialize.php to database.php
require_once (L_PATH.DS."user.php");//initialize.php to database.php

class photograph extends Database_O {
    
  protected static $table_name = "photographs";
  public $id, $filename, $type, $caption,$size;
  
  protected static $upload_dir = "images";
  protected $from_path;
  public $errors = array();
  
  protected $upload_errors = array (
	UPLOAD_ERR_OK					    => 	"No error",
	UPLOAD_ERR_INI_SIZE				=>   	"larger than upload_max_filesize",
	UPLOAD_ERR_FORM_SIZE			=> 	"larger than MAX_FILE_SIZE declared in the FORM",
	UPLOAD_ERR_PARTIAL				=>  	"Partial upload / file didnt finish",
	UPLOAD_ERR_NO_FILE				=> 	"No file was sent",
	UPLOAD_ERR_NO_TMP_DIR			=> 	"no temporary directory",
	UPLOAD_ERR_CANT_WRITE		=>  	"can't write to disk",
	UPLOAD_ERR_EXTENSION			=> 	"file upload  stopped by extension",
     ); //indexed array & not associative since UPLOAD_ERR_OK is not a string

   public function get_photo_table() {
       return photograph::$table_name;
   }
  
    public function attach_file($file) { //returns boolean & gets the file property
          // Perform error checking on  the form parameters.
        if (!$file || empty($file) || !is_array($file)) {
            // error: nothing uploaded or wrong argument usage     
            $this->errors[] = " No File was not be uploaded";
            return FALSE;
         } elseif ($file['error']!=0) {
             // error: report what PHP says went wrong
              $this->errors[] = $this->upload_errors[$file['error']];
              return FALSE;
          } else { // Set object attributes to the form parameters.
              $this->filename = basename($file['name']);
              $this->from_path = $file['tmp_name'];
              $this->type = $file['type'];
              $this->size = $file['size'];
               return TRUE;
                  // Don't  worry about saving anything to the database yet.
            }
         }
         
         
    public function save_p() { //return boolean if saved
    // A new record won't have an ID  yet
         if (isset($this->id)) {
             //Really just to  update the caption
             $this->update();
         } else {

             //Can't save if there are pre-existing errors
             if (!empty($this->errors)) { return FALSE; }
            // create new save & more error trapping aside from existing errors
                
           //Make sure the caption is not long for the DB
             if ($this->caption>255 ) { 
                 $this->errors[]="Caption must not be more than 255 characters..."; 
                 return FALSE; }
           //Can't save without filename and temp location
              if (empty($this->filename) || empty($this->from_path )) { 
                   $this->errors[]="Invalid Filename or Directory Path..."; 
                  return FALSE; }
           // Determine the target_path
              $target_file = P_PATH.DSO.self::$upload_dir.DSO.$this->filename;
                  //C:\xampp\htdocs\practice_prg\photo_g1\public\images\wood.jpg
           //Make sure  a file  doesn't  already  exist in the  target location // directory path &  filename
               if (file_exists($target_file) ) { 
                   $this->errors[]="Duplicate {$this->filename} already exists..."; 
                   return FALSE; }
           // Attempt to move the file
                if (move_uploaded_file($this->from_path, $target_file) ) { //source//destination + filename
                      //Success &  Save a corresponding entry to the database
                    $this->create();  
                      // we are done with temp_path, the file isn't there  anymore
                    UNSET($this->from_path);
                    return TRUE; 
                }
          

           

             // else File was not moved.

         }
    }

    public function destroy_p() { //destroy record of photo & returns boolean
       // first remove the database entry
        // then remove the file  
      if ($this->delete()) {
          // get target path 
          $target_file = P_PATH.DSO.$this->image_display();
          // return unlink()  boolean 
          return unlink($target_file)? TRUE : FALSE;
      } else {             
       //database delete failed
        $this->errors[] = "Delete on file {$this->filename} failed on Database...";
         return FALSE;  
      } 
    }

    public function image_display() { //display photo
       return self ::$upload_dir.DSO.$this->filename;
    }

   public function photo_comments() {
       return comment::find_comments_by_id($this->id);
   }
 
   
    public static function count_all() {
      global $DB;
        return count(self::find_all());
    }
}     
?>
