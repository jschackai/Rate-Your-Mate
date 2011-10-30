<?php
if(!isset($_GET['v'])||!isset($_POST['class'])){
    die;
}else{ //Enrollment (class,user)
    include('../includes/database.php');
    $roster=$database->getRoster($_POST['class']);
    if($roster!=null){
        $classlist="<i>Drag names to the group tabs to add students to a group.</i><ul id='studentlist' style='list-style:none'>";    
    foreach($roster as $student){
      $classlist.="<li id='".$student['id']."'>".$student['lname'].", ".$student['fname']."</li>";
    }
    $classlist.="</ul>";
    }else{
        $classlist="There are no students in that class!";
    }
    
   //echo"<pre>";print_r($roster);echo"</pre>";
   echo $classlist;
   }
    
?>
