<?php
if(!isset($_GET['v'])||!isset($_POST['class'])){
    die;
}else{ //Enrollment (class,user)
    include('../includes/database.php');
    $roster=$database->getRoster($_POST['class']);
    $classlist="<ul style='list-style:none'>";    
    foreach($roster as $student){
      $classlist.="<li id='".$student['id']."'>".$student['lname'].", ".$student['fname']."</li>";
    }
    $classlist.="</ul>";
   //echo"<pre>";print_r($roster);echo"</pre>";
   echo $classlist;
   }
    
?>
