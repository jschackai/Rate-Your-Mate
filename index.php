<?php //do NOT put anything above this line!
    $_GET['page']=($session->logged_in)? 'Welcome':''; //Variable to set up the page title - feeds header.php
    include('includes/header.php');
    $page=($session->logged_in)? 'content.php':'login.php'; 
    include("includes/$page");
?>
</body>
</html>