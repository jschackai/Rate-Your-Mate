<?php
	error_reporting(-1);
	$sid=htmlentities($_POST["sid"],ENT_QUOTES,'iso-8859-1');
    if(!isset($_GET['v'])&&$sid=NULL){die;}//tests for dummy data added for security
    include("../includes/database.php");
	//create contract in database
	try{
        $sth = $database->connection->prepare("INSERT INTO Contract (CID, GID, name, goals, comments) VALUES (:pid, :gid, :name, :goals, :comm) ON DUPLICATE KEY UPDATE;");
		$cGUID= (isset($_POST['cid'])? $_POST['cid'] : getGuid();
        $sth->execute(array(":cid"=>$cGUID, ":gid"=>$_POST['gid'], ":name"=>$_POST['name'], ":goals"=>$_POST['goals'], ":comm"=>$_POST['comments']));
    }catch(Exception $e){
        echo $e;
    }
	
	//insert behaviors in database
	foreach($_POST['behaviors'] as $behave){
	try{
        $sth = $database->connection->prepare("INSERT INTO Behaviors (BID, CID, notes) VALUES (:bid, :cid, :notes) ON DUPLICATE KEY UPDATE;");
        $bGUID= (isset($behave['bid'])? $behave['bid'] : getGuid();
        $sth->execute(array(":bid"=>$bGUID, ":cid"=>$cGUID, ":notes"=>$behave['notes']));
    }catch(Exception $e){
        echo $e;
    }
	}
?>