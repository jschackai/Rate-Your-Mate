<?php

if(!isset($_GET['v'])||!isset($_POST['courseid'])||!isset($_POST['students'])){
    die;
}else{
    include('../includes/database.php');
    $course=$_POST['courseid'];
    $students=$_POST['students'];
    foreach( $students as $student){
        try{
            $sth = $database->connection->prepare("INSERT INTO Enrollment (class,user) VALUES (:class,:user)");
            $sth->bindParam(':class', $course, PDO::PARAM_STR);   
            $sth->bindParam(':user', $student, PDO::PARAM_STR);   
            $sth->execute();
        }catch(Exception $e){
            echo $e;
        } 
    }
}
