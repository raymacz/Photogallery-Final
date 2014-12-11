
<?php
//============== photogallery project=======================
//  user, photograph, comment, database, session, pagination
//require_once (LIB_PATH.DS."initialize.php");
require_once( '../../includes/initialize.php'); 
  $message="";

  
  
 if (isset($_POST['submit'])) {
   $username = trim($_POST['username']);
   $password = trim($_POST['password']);
   $found_user = User::authenticate($username, $password);
   if ($found_user) {
       //session
       $Ses->login($found_user);
       //log_action
     redirect_to('index.php');
   } else {
     $message = "Username & Password does not match!";
   }
 } else {
  $username ="";
  $password= "";
 }
?>

<html>
  <head>
    <title>Photo Gallery </title>
    <link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" /> 
</head>
   <body>
     <div id="header">
       <h1>Photo Gallery</h1>
     </div>
     <div id="main">
       
       <h2>Staff Login</h2>
       <?php echo output_message($message); ?>
       
       <form action="login.php" method="post">
         <table>
           <tr>
             <td>Username:</td>
             <td>
               <input type="text" name="username" maxlenght="30" value="<?php echo htmlentities($username); //applicable chars converts to html entries?>" /> 
             </td>
           </tr>
           <tr>
              <td>Password:</td>
             <td>
               <input type="password" name="password" maxlenght="30" value="<?php echo htmlentities($password); ?>" />
             </td>
           </tr>
           <tr>
             <td colspan="2">
               <input type="submit" name="submit" value="Login" />
             </td>
           </tr>
         </table>
       </form>
    </div>
            <div id='footer'>Copyright <?php echo date("Y, time()"); ?>, Raymacz Industries </div>
   </body>
</html>
<?php if (isset($database)) {$database->close_connection(); } ?>


