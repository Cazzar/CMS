<?php
 header("Refresh: 3; url=\"index.php\"");
 //session_start();
 session_unset();  
 session_destroy();
 echo "Logged out successfully<br/>";
 echo "You will be redirected to in 3 seconds..."
?> 
