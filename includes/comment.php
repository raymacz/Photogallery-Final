<?php
require_once (L_PATH.DS."database.php");//initialize.php to database.php
require_once (L_PATH.DS."user.php");//initialize.php to database.php

class comment extends Database_O {
    
  protected static $table_name = "comments";
  //public $id, $p_id,$date_created, $author, $body;
  public $id, $photograph_id,$created, $author, $body;
  protected static $db_fields = array('id', 'photograph_id', 'created', 'author', 'body');
  public $errors = array();
  
            // else File was not moved.
     
   public  function delete_check() {
       return ($this->delete()) ? TRUE : FALSE;
   }
        
    public static function make_comments($p_id, $author, $body) {
        global $com_obj; //already created an instance in photo.php // but not advisable bco it can easi;y be forgotten
        // // can be done inside  this class  methods  to make it easier to remember... or  outisde the methods & 
        // // below this comment.php and called forth by require_once in initialize to make it global just like $DB;
        $pause=0;
//        $this->photograph_id=$p_id;  // this wouild not work  bcoz its being called by static
//        $this->author=$p_author;
//        $this->photograph_body=$body;
        $pause=0;
        $com_obj->photograph_id=(int)$p_id; //put(int) in variable 
        $com_obj->author=$author;
        $com_obj->body=$body;
        $com_obj->created = strftime("%Y-%m-%d %H:%M:%S", time());  //strftime("%Y", time());   //if  $Y ..  it doesn't show time
         return $com_obj;
    }

    public static function find_comments_by_id($photo_id) { //display photo
        global $DB;
        $sql = "SELECT * from ".static::$table_name." WHERE photograph_id = {$DB->escape_value($photo_id)} ORDER BY created ASC";
      //  $comments = static::find_by_sql($sql);
          $comments = comment::find_by_sql($sql);
            return $comments;
    }

    public function send_notification() {
        //declare $to_name,$to, $subject,$message
       $to_name= "Photo Gallery Admin";
       $to = "raymacz76@gmail.com";

       $subject = "New Photo Gallery Comment ".strftime("%T", time());
     //  $message = "A new comment has been received."; // A simple message
       
       $message =<<<EMAILBODY
           A new comment has been received in the Photo Gallery.
           
           At {$this->created}, {$this->author} wrote:
           
           {$this->body}
           
           
EMAILBODY;
        // <<<EMAILBODY EMAILBODY can be used for email bodies like tags in html...
       $message = wordwrap($message, 70);     
        $mail = new PHPMailer();
        $mail->IsSMTP();
       // $mail->SMTPDebug = 1; 
        $mail->Host = "smtp.gmail.com";
        $mail->Port =  465; //25 //587 //465
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = 'ssl';// tls /ssl
        $mail->Username = "invgamez@gmail.com";
        $mail->Password = "acezz4321";

        $mail->SetFrom("invgamez@gmail.com","Photo Gallery ");
        //('name@yourdomain.com', 'First Last')
        $mail->AddAddress($to, $to_name);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $result = $mail->Send();
        return $result;
     }     
}
?>
