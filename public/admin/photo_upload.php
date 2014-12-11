<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$Ses->is_logged_in()) { redirect_to("login.php"); } ?>
<?php
// check submit
$max_filesize = 1048576;
if (isset($_POST['submit'])) {
    // if submit then save  //instance & attach
    $Photo_c1 = new photograph();
     $Photo_c1->caption = $_POST['caption'];
       //need caption to check max chars allowed
    $Photo_c1->attach_file($_FILES['file_upload']);
    if ($Photo_c1->save_p()) {
        $message = "Uploaded Successfully.";
        //needs to be in session after redirect
        $Ses->message = "Uploaded Successfully.";
        redirect_to('list_photos.php');
    } else {
        $message=$Photo_c1->errors[0];
    }
}

// if save then message success redirect to list_photos.php else message fail display error

//---UNFINISHED
?>
<?php include_layout_template('admin_header.php'); ?>

<h2>Photo Upload</h2>

<?php output_message($message); //display message  ?>
<form enctype="multipart/form-data" method="POST" action="photo_upload.php">
       <input type="hidden" value=<?php echo $max_filesize; ?> name="MAX_FILE_SIZE">
        <p> <input type="file" name="file_upload">  </p>
        <p> Caption:  <input type="text" value="" name="caption">   </p>
        <input type="submit" value="Upload" name="submit">
</form>
<br />

<?php include_layout_template('admin_footer.php'); ?>
