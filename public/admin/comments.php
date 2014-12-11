<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$Ses->is_logged_in()) { redirect_to("login.php"); } ?>
<?php

	// check get ?id=
          if (isset($_GET['id'])) { 
              // find  by id in photograph class in database
              $photo = photograph::find_by_id($_GET['id']);
              if ($photo && $photo->id) {
                   // if found load photo object 
                   $comments = $photo->photo_comments();
              } else {
                  $Ses->message("Photo not found!");
                  redirect_to("index.php");
              }
          } else {
              $Ses->message("Photo ID not provided");
          }
                  $message=$Ses->message;
                 
                  // // if not found, message, redirect to index
                  
                  //  else  found message load comments via photo_obj  (bcoz of related id in group comments)  from comment_obj table
               

?>
<?php include_layout_template('admin_header.php'); ?>

<a href="list_photos.php">&laquo; Back &raquo</a><br /> <!--back buton &laquo means << -->
<br />

<h2>Comments on <?php echo $photo->filename;//filename of photo; ?></h2>
<?php echo output_message($message); ?>

<div id="comments">
  <?php foreach($comments as $comment): //load comments to comment individual ?>
    <div class="comment" style="margin-bottom: 2em;">
	    <div class="author">
	      <?php echo $comment->author; ?> wrote:
	    </div>
      <div class="body">
				<?php echo strip_tags($comment->body, "<strong><em><p>");//strong em p strip html from body; ?>
			</div> 
	    <div class="meta-info" style="font-size: 0.8em;">
	      <?php echo $comment->created; //date to text created time; ?>
	    </div>
			<div class="actions" style="font-size: 0.8em;">
				<a href="delete_comment.php?id=<?php echo $comment->id;// object->id  to delete ?>">Delete Comment</a>
			</div>
    </div>
  <?php endforeach; ?>
  <?php //if comments is none message no comments?>
</div>

<?php include_layout_template('admin_footer.php'); ?>
