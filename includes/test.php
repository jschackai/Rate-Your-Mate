<?php //do NOT put anything above this line!
    $_GET['page']=$page='Test'; //Variable to set up the page title - feeds header.php
    include('../includes/header.php');//this include file has all the paths for the stylsheets and javascript in it.
	
	echo"<pre>".print_r($database->getUserInfo($session->username))."</pre>";
?>