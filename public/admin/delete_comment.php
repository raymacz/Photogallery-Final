<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$Ses->is_logged_in()) { redirect_to("login.php"); } ?>
<?php
	// must have an ID //no Comment ID was provided
$pause = 0; 
if (!isset($_GET['id'])) { // use bracket [] on isset  // or   if(empty($_GET['id'])) {
     $Ses->message('No comment ID was provided');
     redirect_to('index.php');
}
 //find comment by id

//  if(empty($_GET['id'])) {
//  	$session->message("No comment ID was provided.");
//    redirect_to('index.php');
//  }
$com_obj=  comment::find_by_id($_GET['id']);

if (!empty($com_obj) && $com_obj->delete_check()) { // or  if($comment && $comment->delete()) {
    $Ses->message('Comment was deleted');
    redirect_to("comments.php?id= {$com_obj->photograph_id}"); // photo id for all the photo related ocmments...
} else {
      $Ses->message('The comment could not be deleted');  
      redirect_to('list_photos.php');
}


?>
<?php if(isset($DB)) { $DB->close_connection(); } ?>
