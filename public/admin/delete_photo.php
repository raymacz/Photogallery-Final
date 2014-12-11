<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$Ses->is_logged_in()) { redirect_to("login.php"); } ?>
<?php

// must have an ID
//check get message if not found ID
if (isset($_GET['id'])) {
    //find id
    $photo=photograph::find_by_id($_GET['id']);
    if ($photo && $photo->destroy_p()) {
        $Ses->message="Photo {$photo->filename} Deleted!";
    } else {
        $Ses->message="Photo could not be deleted...";
    }
     redirect_to("list_photos.php");
} else {
    $Ses->message="No Photo ID was provided...";
     redirect_to("index.php");
}



// if photo delete  / message redirect
//else delete / message redirect

?>
<?php if(isset($DB)) { $database->close_connection(); } ?>
