<?php
    error_reporting(-1);
    $sid=htmlentities($_POST["sid"],ENT_QUOTES,'iso-8859-1');
    if(!isset($_GET['v'])&&$sid=NULL){die;}//tests for dummy data added for security
    include("../includes/database.php");
    include("../includes/functions.php");
    //grab $_post variables except for group lists  (we'll deal with them separately) and create a project

    try{
        $sth = $database->connection->prepare("INSERT INTO Projects (PID, pname, odate, cdate, instructor, late, groups, evals, contract, grades, class) VALUES (:pid, :pname, :odate, :cdate, :instructor, :late, :groups, :evals, :contract, :grades, :class);");
        $pGUID=getGuid();
        $oDate=$_POST['oDate'];
        $cDate=$_POST['cDate'];
        $sth->execute(array(":pid"=>$pGUID, ":pname"=>$_POST['pid'], ":odate"=>$oDate, ":cdate"=>$cDate, ":instructor"=>$_POST['inst'], ":late"=>$_POST['late'], ":groups"=>$_POST['numgroups'], ":evals"=>$_POST['numeval'], ":contract"=>$_POST['contract'], ":grades"=>$_POST['grades'], ":class"=>$_POST['class']));
    }catch(Exception $e){
        echo $e;
    }
    //assuming no errors above, we now create the groups:
    
    $gCount = 1; //group counter
    foreach($_POST['group'] as $group){
        $gname="Group-$gCount";
        $gGUID=getGuid();
        foreach($group as $student){
            try{
                $sth = $database->connection->prepare("INSERT INTO Groups (GID, UID, PID, name) VALUES (:gid, :uid, :pid, :name);");
                $sth->execute(array(":gid"=>$gGUID, ":uid"=>$student, ":pid"=>$pGUID, ":name"=>$gname));
            }catch(Exception $e){
                echo $e;
            }
        }
        $gCount++;
    }
    $sth=null;
?>