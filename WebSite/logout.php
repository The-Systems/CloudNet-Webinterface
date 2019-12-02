<?php
include "config.php";
session_start();
 
 
if (isset($_SESSION['Logged'])) {
   session_destroy();
   setcookie("loginname","1",time()-1);
   setcookie("loginpass","1",time()-1);
   header('Location: '.$domain.'/index.php?error=logout');

} else {
   echo "Error";
}
?>

