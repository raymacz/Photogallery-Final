
<?php
//============== admin index =======================
require_once( '../../includes/initialize.php'); 
    if (!$Ses->is_logged_in()) {  redirect_to("login.php");}
?>

<html>

    <?php
    include_layout_template("admin_header.php"); 
    ?>
    <?php output_message($message); ?>
     <h2>Menu</h2>
           <ul>
                <li> <a href="list_photos.php">List Photos</a> </li>
                <li> <a href="logfile.php">View Log file</a> </li>
                <li> <a href="logout.php">Logout</a> </li>
        </ul>
     </div>
    <?php  include_layout_template("admin_footer.php"); 
    $x=0;
    ?>

</html>