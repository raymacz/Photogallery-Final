<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$Ses->is_logged_in()) { redirect_to("login.php"); } ?>
<?php
  // Find all the photos
  $photos= photograph::find_all();
  $pause=0;
?>
<?php include_layout_template('admin_header.php'); ?>
<a href="index.php">&laquo; Back</a><br />
<br />

<h2>Photographs</h2>
<!--message-->
<?php output_message($Ses->message); ?>
<table class="bordered">
  <tr>
    <th>Image</th>
    <th>Filename</th>
    <th>Caption</th>
    <th>Size</th>
    <th>Type</th>
      <th>Comments</th>
    <th>&nbsp;</th>
  </tr>
<?php foreach ($photos as $p): ?>
  <tr>
      <td><img src="../<?php  echo $p->image_display(); ?>" width="100" /></td> 
      <!-- $p becomes an object after calling the static Photograph::find_all() -->
    <td><?php echo $p->filename; ?></td>
    <td><?php echo $p->caption;?></td>
     <td><?php echo$p->size_as_text();?></td>
    <td><?php  echo $p->type;?></td>
    <td><a href="comments.php?id=<?php echo $p->id;?>">
               <?php  echo count($p->photo_comments()); //count ?>
          </a>

    </td>
    <td><a href="delete_photo.php?id=<?php echo $p->id;?>">Delete<a/></td>
  </tr>
<?php endforeach; ?>
</table>
<br />
<a href="photo_upload.php">Upload Photograph</a>

<?php include_layout_template('admin_footer.php'); ?>
