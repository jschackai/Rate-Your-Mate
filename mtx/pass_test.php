<?php 
    include("includes/session.php");

    $username='sjpage';
    $newpass='aVj6LA86'; 
    // Create a 256 bit (64 characters) long random salt Let's add 'something random' and the username to the salt as well for added security
    $salt=hash('sha256',uniqid(mt_rand(),true).'something random'.strtolower($username)); 
    // Prefix the password with the salt
    $hash=$salt.$newpass; 
    // Hash the salted password a bunch of times
    for($i=0;$i<10000;$i++){$hash=hash('sha256',$hash);} 
    // Prefix the hash with the salt so we can find it back later
    $hash=$salt.$hash;
    echo $hash."<br/>";



    //store in database:
    try{  
        $sth = $database->connection->prepare("UPDATE ".TBL_USERS." SET password=:hash WHERE username=:uname");
        $sth->bindParam(':uname', $username, PDO::PARAM_STR);
        $sth->bindParam(':hash', $hash, PDO::PARAM_STR);
        $sth->execute();
    }catch(Exception $e){
        echo $dbErrMssg;
    }


    //validate: 


    try{  
        $sth = $database->connection->prepare("SELECT password FROM ".TBL_USERS." WHERE username=:uname");
        $sth->bindParam(':uname', $username, PDO::PARAM_STR);
        $sth->execute();
        $dbarray = $sth->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        echo $dbErrMssg;
    }
    $hasher=$dbarray['password'];
    // The first 64 characters of the hash is the salt
    $salt=substr($hasher,0,64); 
    $hash2=$salt.$newpass; 
    // Hash the password as we did before
    for($i=0;$i<10000;$i++){$hash2=hash('sha256', $hash2);} 
    $hash2=$salt.$hash2; 
    if($hash==$hasher){
        echo"<br/>Ok!";
    }else{
        echo"<br/>Problem!";
        echo "<br/>".$hasher;
    }

?>