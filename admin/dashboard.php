<?php

    ob_start();

    session_start();

  // if the session saved go dircet not to log form first 
     if (isset($_SESSION['Username'])) { 
 	   $PageTitle='dashboard';

 	   include  'init.php';

     
        

        
 	   /*include $tpl .'footer.php'; */

    } else {
    	
    	header('location: index.php');

    	exit();
    }

    ob_end_flush();
 ?>   