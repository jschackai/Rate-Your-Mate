<?php //do NOT put anything above this line!
    $_GET['page']=$page='Test'; //Variable to set up the page title - feeds header.php
    include('../includes/header.php');//this include file has all the paths for the stylsheets and javascript in it.
	$eodate='11/12/2011 00:00:00';
    $test= strtotime($eodate);
	echo  $test;
    //date('Y-m-d H:i:s',$test);
?>