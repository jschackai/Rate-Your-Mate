<?php
    if(isset($_GET['IID'])){$user=htmlentities($_POST["IID"],ENT_QUOTES,'iso-8859-1');}else{$user="";}
    include('../includes/database.php');
    try{
        $sth = $database->connection->prepare("SELECT fname, lname FROM Users WHERE UID=:uid");
        $sth->bindParam(':uid', $user, PDO::PARAM_STR);   
        $sth->execute();
        $uname = $sth->fetchColumn();
    }catch(Exception $e){
        echo $e;
    }
    
?>
<div class='right'>You are logged in as <?php echo "$lname $fname";?> <a href='../logout.php'>Logout</a></div>