<?php
    include('includes/header.php');
    /* User has already logged in */ 
    if($session->logged_in){
        include('content.php');
    }else{ 
        include('includes/login.php');  
}?>
</body>
</html>