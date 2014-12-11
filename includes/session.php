<?php

/*
 * a class to help work with sessions
 * In our case, primarily to manage logging users in and out
 * 
 * keep in mind when working with sessions that it is generally
 * inadvisable to store DB-related  objects in  sessions
 */

Class Session {
   
  protected $user_id;
  public $is_logged;
  public $message;

    Function __construct() {
     session_start() ;
     $this->check_login();
     $this->check_msg();
     if ($this->is_logged_in()) {
       //===
     } else {
       //====
     }
   } 

   Public Function is_logged_in()  {
      return $this->is_logged;
    }

    Public Function login($usr)  {
       $this->is_logged = TRUE;
       $this->user_id=$_SESSION['user_id']=  $usr->id;
       if (!log_action("| Login : ","user ID# {$this->user_id} logged in.")) {
           $this->message("Could not open file log file...");
       } 
       //$this->message = "Login Success...";
       $this->message("Login Sucess..."); // store msg to session
    }

    
    Public Function logout()  {
      unset($_SESSION['user_id']);
      unset($this->user_id);
      $this->is_logged = FALSE;
             if (!log_action("| Logout : ","user ID# {$this->user_id} logged out.")) {
           $this->message("Could not open file log file...");
       } 
    }

    Public Function check_login()  {
      if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->is_logged = TRUE;
     } else {
         unset($this->user_id);
       $this->is_logged= FALSE;
     }
    }
    
    Public function check_msg() { //initialize message
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
           unset($_SESSION['message']); //unset session to avoid repetitive message every browser refresh.. NOTE: session is reset upon browser closing..
        } else {
           $this->message = "";
        }
    }
        
   Public function message($msg="") {
       if (!empty($msg)) { 
           $_SESSION['message'] = $msg;
       } else {
           return $this->message;
       }
   }

}

$Ses = new Session;
$message = $Ses->message();
?>
