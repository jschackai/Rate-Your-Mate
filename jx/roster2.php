<?php
if(!isset($_GET['v'])||!isset($_GET['class'])){
    die;
}else{ //Enrollment (class,user)
    include('../includes/database.php');
    $roster=$database->getRoster($_GET['class']);
    $classlist="<ul>";    
    foreach($roster as $student){
      $classlist.="<li id='".$student['id']."'>".$student['lname'].", ".$student['fname']."</li>";
    }
    $classlist.="</ul>";
   //echo"<pre>";print_r($roster);echo"</pre>";
   echo $classlist;
   }
    
?>
