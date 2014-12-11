<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// this must be in-order for it to work

PHP_OS == "Windows" || PHP_OS == "WINNT" ? define("DSO", "/") : define("DSO", "\\"); ; // reversed OS path
//defined("DS") ? NULL : define("DS", DIRECTORY_SEPARATOR);
defined("S_ROOT") ? NULL : define("S_ROOT", "C:".DS."xampp".DS."htdocs".DS."practice_prg".DS."photo_g1"); //regular  OS path
defined("S_ROOTO") ? NULL : define("S_ROOTO", "C:".DSO."xampp".DSO."htdocs".DSO."practice_prg".DSO."photo_g1"); // reversed OS path
defined("L_PATH") ? NULL : define("L_PATH", S_ROOT.DS."includes");
defined("P_PATH") ? NULL : define("P_PATH", S_ROOTO.DSO."public");
defined("R_PATH") ? NULL : define("R_PATH", S_ROOTO.DS."logs");

require_once(L_PATH.DS.'functions.php');

//require_once '../includes/configz.php';
require_once(L_PATH.DS."configz.php");
//require_once( '../includes/database.php');
require_once(L_PATH.DS."database.php");
//require_once( '../includes/database_obj.php');
require_once(L_PATH.DS."database_obj.php");  // must be loaded first before user bcoz of extends
////require_once( '../includes/session.php');
require_once(L_PATH.DS."session.php");
//require_once( '../includes/user.php');
require_once(L_PATH.DS."user.php");
//require_once( '../includes/photograph.php');
require_once(L_PATH.DS."photograph.php");
//require_once( '../includes/comment.php');
require_once(L_PATH.DS."comment.php");
//require_once( '../includes/pagination.php');
require_once(L_PATH.DS."pagination.php");
//require_once( '../includes/PHPMailer.php');
require_once L_PATH.DS.'PHPMailer'.DS.'class.phpmailer.php';
require_once L_PATH.DS.'PHPMailer'.DS.'class.smtp.php';
require_once L_PATH.DS.'PHPMailer'.DS.'language'.DS.'phpmailer.lang-en.php';


?>
