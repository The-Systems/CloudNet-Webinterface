<?php
session_start();

if(isset($_SESSION['Logged'])) {
        header('Location: '.$domain.'/logged');
        //erfolg
    } else {
		header('Location: '.$domain.'/index.php?error=403');
//error
    
}