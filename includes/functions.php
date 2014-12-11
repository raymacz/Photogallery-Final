<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once '../configz.php';
//require_once( '../includes/initialize.php');


function strip_zeros_from_date( $marked_string="")  {
$marked_string  = str_replace('0*',"", $marked_string ); 
$cleaned_string  = str_replace('*',"", $marked_string ); 
return $cleaned_string;
}

function redirect_to($location=NULL) {
  if ($location!=NULL) {
 // header("{$location}"); // doesnt work w/o Location:
  header("Location: {$location}"); //  http://php.net/manual/en/function.header.php  -- use" Location:" to 
  exit();
  }
}

function output_message($message="") {
  if (!empty($message)) {
  echo "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function __autoload($class_name) {
  $class_name = strtolower($class_name);
  $path = L_PATH.DS."{$class_name}.php";
  if (file_exists($path)) {
  require_once($path);
  } else {
   die("file  not found");
  }
}

function include_layout_template($template="") {
  $template= S_ROOT.DS."public".DS."layouts".DS.$template;
 // $template= S_ROOTO.DSO."public".DSO."layouts".DSO.$template;
  //C:\xampp\htdocs\practice_prg\photo_g1\public\layouts
  //C:\xampp\htdocs\photogal\public\layouts
 include $template;
}

//function log_action "Logs Cleared",User_id // indicate the user who cleared the logs
function log_action($action, $message="")
{
    $mode='a';
    $content="";
     $logfile=R_PATH.DS."log.txt";
if($handle = fopen($logfile, $mode)) {
    //2014-08-29 08:21:38 | Logs Cleared : by User ID 2 
    //no appends since it is  to clear the logs
     $content =  strftime("%B %d, %Y at %I:%M %p",(time()));
     $content .= $action;
     $content .= $message."\r\n";
     fwrite($handle, $content);
     //file_put_contents($logfile, $content); //file_put_contents: shortcut for  fopen/fwrite/fclose
 // fwrite($handle, 'abc...Hello World'); // return number of bytes written or  false;
  fclose($handle);
  return TRUE;
} else {
   return FALSE;
}

 
//overwrites existing file by default (so be CAREFUL)
//$content = "111\r222\n333"; \r &  \n does not work in windows it should be both \r\n & not \n\r
$pause=0;
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}