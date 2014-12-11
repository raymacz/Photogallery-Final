
<?php
//============== photogallery project=======================
require_once( '../includes/initialize.php'); ?>

  <?php
  
  //check page passed variable id; else message no ID was found & redirect back to index.php
  if (empty($_GET['id'])) {
      $Ses->message('no photo ID  was found..');
      redirect_to('index.php');
  }
  //search photo by id, else msg photo could not be  found redirect to index.php
  $photo=photograph::find_by_id($_GET['id']);
       
  if ($photo && $photo->id) {
    // if found load photo object 
    $comments = $photo->photo_comments();
  } else {
    $Ses->message("Photo not found!");
    redirect_to("index.php");
  }    
  
 
  // if submit comment, trim author&body, method function make comment else initialize author;
  if (isset($_POST['submit'])) {
    ///  $author=trim(filter_input(INPUT_POST, $_POST['author']));
      /// $body=trim(filter_input(INPUT_POST, $_POST['body'])); 
      $author=trim( $_POST['author']); 
      $body=trim( $_POST['body']); 
      $com_obj = new comment();
      $new_comment = comment::make_comments($photo->id, $author, $body);
            // if comment has been made & saved, msg = send email, redirect to photo.php with id       // Send email
      if ($new_comment && $new_comment->save()) {
          // send email
           $new_comment->send_notification();
           redirect_to("photo.php?id={$photo->id}"); //use double quotes
      } else {
          // else msg "error that prevented  comment from being saved"
         $message = $Ses->message("An error occured that prevented comment from being saved.");
         redirect_to('index.php');
      }
      
  } else {
     $author= "";
     $body = "";
  }

  
  
  //note: page is reloaded, form will try to resubmit the new comment to be displayed with the photo
  

      //THIS WAS REVERSED BY RBTM
      //php behavior: !$new_comment->save() won't execute if placed with "!"     //comment saved

      //note: Important! you could just let the page render  from here. 
    //note: But then if the page is reloaded, the form will try to resubmit the comment. So use REDIRECT instead...
    


  // find all comments of the id photo
   
?>
 <?php  include_layout_template('header.php'); ?>

<a href="index.php">&laquo; Back </a><br /><br />

<div style="margin-left:  20px;">
    <img src="<?php  echo $photo->image_display(); //display photo?>" />
    <p><?php echo $photo->caption; //caption?></p> 
</div>


<!-- list comments -->
<div id="comments">
  <?php foreach ($comments as $comment) : //display comments?>
    <div class="comment" style="margin-bottom: 2em;">
	    <div class="author">
	      <?php echo htmlentities($comment->author); //make it safe for malicious entries?> wrote:
	    </div>
      <div class="body">
		<?php echo strip_tags($comment->body,'<strong><em><p>'); //strip html& php tags except these tags?> 
	</div>
	    <div class="meta-info" style="font-size: 0.8em;">
	      <?php echo htmlentities($comment->created);//display time created  ?>
	    </div>
    </div>
  <?php endforeach;?>
  <?php //if empty comments msg "empty comment"
               if (empty($comments)) { echo "comments empty...";}
  ?>
</div>

<div id="comment-form">
  <h3>New Comment</h3>
  <?php echo output_message($message); ?>
  <form action="photo.php?id=<?php echo $photo->id;//echo id to be passed ?>" method="post">
    <table>
      <tr>
        <td>Your name:</td>
        <td><input type="text" name="author" value="<?php echo $author;//display author even if empty ?>" /></td>
      </tr>
      <tr>
        <td>Your comment:</td>
        <td><textarea name="body" cols="40" rows="8"><?php echo $body;//display body even if empty  ?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value="Submit Comment" /></td>
      </tr>
    </table>
  </form>
</div>


<?php  include_layout_template('footer.php'); ?>



