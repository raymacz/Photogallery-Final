<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$Ses->is_logged_in()) { redirect_to("login.php"); } ?>
<?php   ///UNFINISHED

  //logfile path of logtext.php
 $logfile=R_PATH.DS."log.txt";

   //clear log file passed ?clear=TRUE
   if (isset($_GET['clear'])=="TRUE") {
      //file_put_contents  php5 
      file_put_contents($logfile, ""); 
      $user_id= $_SESSION['user_id'];
      //log_action("Logs Cleared ", $user_id);
      if (!log_action("| Logs Cleared "," : by User ID# {$user_id}.")) {
           $this->message("Could not open log file...");
       }
      //function log_action "Logs Cleared",User_id // indicate the user who cleared the logs
      //redirect_to "logfile.php"
       redirect_to('logfile.php');
   }



?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a><br />
<br />

<h2>Log File</h2>

<p><a href="logfile.php?clear=true">Clear log file</a><p>

<?php 
// to display each content line of the  file.. start
$entries= NULL;
if(file_exists($logfile) && is_readable($logfile) && $handle= fopen($logfile, 'r')) { //read
 echo "<ul class=\"log-entries\">"; 
  while(!feof($handle)) { //test for end-of-file filepointer
      $entries = fgets($handle); //gets line from filepointer  
      $entries = trim($entries);
      if (!empty($entries)) {
       echo "<li>{$entries}</li>";
       } 
  } 
  fclose($handle);
  echo "</ul>";
} else {
    // if logfile exist & is_readable & fopen then read entry else msg "could not read logfile..."   //  echo "<ul class=\"log-entries\">";   // echo "<li>{$entry}</li>"; //  echo "</ul>";
    $Ses->message("File is not readable or does not exist.");
}

$pause=0;
// 



?>

<?php include_layout_template('admin_footer.php'); ?>
