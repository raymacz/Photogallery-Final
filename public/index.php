
<?php
//============== photogallery project=======================
//  user, photograph, comment, database, session, pagination

//notes: http://localhost/practice_prg/photo_g1/public/index.php   FILEPATH must be placed on URL 

//require_once( '../includes/database.php');
//require_once( '../includes/user.php');

require_once( '../includes/initialize.php');

$BR = "<BR />";
// 1. the current page number ($current page)

$current_page=(empty($_GET['page']))? 1 : $_GET['page'];
//page resets to 1 if empty. Also make sure (int) is the number passed
// 2. records per page ($per_page)
$per_page=2;
// 3. total  record count ($total_count)
$total_count= photograph::count_all();
//Find all photos
// use pagination instead

 //initialize class

//Need to add ?page=$page to all links we want to
//maintain the  current page (or store $page in $session)

//Instead of finding all 

//$photos = photograph::find_all();

$pag = new Pagination($current_page, $per_page, $total_count);
$photo= new photograph(); //o get table used by photo
$sql = "SELECT * FROM ".  $photo->get_photo_table() . " LIMIT " . $per_page . " OFFSET ".$pag->offset(); 
//iniitalize the pagination
$photos = photograph::find_by_sql($sql);
?>

  <?php  include_layout_template('header.php'); ?>

<?php foreach ($photos as $p) :?>
  <div style="float: left; margin-left: 20px; ">
      <a href="photo.php?id=<?php echo $p->id; ?>">
        <img src="<?php  echo $p->image_display();  ?>" width="200" />
      </a>
      <p><?php echo $p->caption; ?></p>
  </div>
  <?php endforeach; ?>

<div id="pagination" style="clear: both; ">
  <?php
  if ($pag->total_pages()>1) {
    if ($pag->has_prev_page()) {
    echo "<a href=\"index.php?page=".$pag->prev_page()."\">&laquo; Previous</a> ";
    }
    for ($i = 1; $i <= $pag->total_pages(); $i++) {      
      if ($current_page == $i) {
        echo " <span class=\"selected\">{$i}</span> ";
      } else {
         echo " <a href=\"index.php?page={$i}\">{$i}</a> ";
      }
      // " <span class=\"selected\">{$i}</span> "
      //" <a href=\"index.php?page={$i}\">{$i}</a> "
    }
    if ($pag->has_next_page()) {  
     echo " <a href=\"index.php?page=".$pag->next_page()."\"> Next &raquo</a> ";
    }
  }
   ?>
</div>

<?php  include_layout_template('footer.php'); ?>

