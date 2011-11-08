
<div class='roundall' style='width:50em;margin:auto auto;'>
<?php
    echo "<h2>Welcome ".$session->realname."!</h2>";
    echo "You last visited: ".$session->userinfo['timestamp'];
    if($session->isInstructor()||$session->isAdmin()){//allows admin to be an instructor.

        try{  
            $sth = $database->connection->prepare("SELECT CLID, cname FROM Classes WHERE instructor =:uid");
            $sth->bindParam(':uid', $session->UID, PDO::PARAM_STR);   
            $sth->execute();
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                $classIDs[]=$row['CLID'];
                $classNames[]=$row['cname'];
            }       
            $clen=count($classIDs);
            $cplural=($clen>1)? "s" : "";
            if ($classIDs[0]!=''){
                echo "<h3 style='margin-bottom:.25em'>You currently have $clen classe$cplural:</h3>";
                echo"<form method='POST' action='instructor/activity.php' id='go2form' style='display:inline'>"
                ."<select id='classsel' name='classsel'>";
                for($i=0;$i<$clen;$i++){
                    $cid=$classIDs[$i];
                    $cnam=$classNames[$i];
                    echo"<option value='$cid'>$cnam</option>";
                }
                echo"</select>&nbsp;&nbsp; <input type='submit' id='go2class' name='go2class' value='go to class page' disabled='disabled'/></form>"
                ."<span style='font-size:1.6em;'>&nbsp;<strong> or, ";
            }else{
                echo"<span style='font-size:1.6em;'>&nbsp;<strong>You have no current classes, ";
            }
            echo"start a &nbsp;&nbsp;</strong></span>"
            ."<form method='POST' action='instructor/add_class.php' id='newcform' style='display:inline'>"
            ."<input type='submit' id='newclass' name='newclass' value='new class'/></form>";
        }catch(Exception $e){
            //handles database errors.
            echo DB_ERR;
        }

        try{  
            $sth = $database->connection->prepare("SELECT PID, pname FROM Projects WHERE instructor =:uid");
            $sth->bindParam(':uid', $session->UID, PDO::PARAM_STR);   
            $sth->execute();
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                $projectIDs[]=$row['PID'];
                $projectNames[]=$row['pname'];
            }
            $plen=count($projectIDs);
            $pplural=($plen>1)? "s" : "";
            if ($projectIDs[0]!=''){
                echo "<h3 style='margin-bottom:.25em'>You currently have $plen project$pplural:</h3>";
                echo"<form method='POST' action='instructor/activity.php' id='go2form' style='display:inline;'>"
                ."<select id='projsel' name='projsel'>";
                for($i=0;$i<$plen;$i++){
                    $pid=$projectIDs[$i];
                    $pnam=$projectNames[$i];
                    echo"<option value='$pid'>$pnam</option>";
                }
                echo"</select>&nbsp;&nbsp; <input type='submit' id='go2proj' name='go2proj' value='go to project' disabled='disabled'/></form>"
                ."<span style='font-size:1.6em;'>&nbsp;<strong> or, ";
            }else{
                echo"<span style='font-size:1.6em;'>&nbsp;<strong>You have no current projects, ";
            }
            echo"start a &nbsp;&nbsp;</strong></span>"
            ."<form method='POST' action='instructor/project.php' id='newpform' style='display:inline'>"
            ."<input type='submit' id='newproj' name='newproj' value='new project'/></form>";
        }catch(Exception $e){
            //handles database errors.
            echo DB_ERR;
        }

        echo"<br/><h3>Future Link to <a href='instructor/activity.php'>Activity Page</a></h3>";
        if($session->isAdmin()){//link to admin panel only visible to admins.
            echo"<h3>Go to <a href='admin/admin.php'>Admin panel</a></h3>";
        }
    }else{//user is student, present appropriate stuff.
        try{  
            $sth = $database->connection->prepare("SELECT CLID, cname FROM Classes WHERE CLID IN (SELECT class FROM Enrollment WHERE user =:uid)");
            $sth->bindParam(':uid', $session->UID, PDO::PARAM_STR);   
            $sth->execute();
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                $classIDs[]=$row['CLID'];
                $classNames[]=$row['cname'];
            }       
            $clen=count($classIDs);
            $cplural=($clen>1)? "s" : "";
            if ($classIDs[0]!=''){
                echo "<h3 style='margin-bottom:.25em'>You are currently enrolled in $clen classe$cplural:</h3>";
                echo"<form method='POST' action='student/studentInput.php' id='go2cform' style='display:inline'>"
                ."<select id='classsel' name='classsel'>";
                for($i=0;$i<$clen;$i++){
                    $cid=$classIDs[$i];
                    $cnam=$classNames[$i];
                    echo"<option value='$cid'>$cnam</option>";
                }
                echo"</select>&nbsp;&nbsp; <input type='submit' id='go2class' name='go2class' value='go to class page' disabled='disabled'/></form>";
            }else{
                echo"<span style='font-size:1.6em;'>&nbsp;<strong>You are not currently enrolled in any classes.";
            }
            echo"</form>";
        }catch(Exception $e){
            //handles database errors.
            echo DB_ERR;
        }

        try{  
            $sth = $database->connection->prepare("SELECT PID, pname FROM Projects WHERE class IN(SELECT class FROM Enrollment WHERE user =:uid)");
            $sth->bindParam(':uid', $session->UID, PDO::PARAM_STR);   
            $sth->execute();
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                $projectIDs[]=$row['PID'];
                $projectNames[]=$row['pname'];
            }
            $plen=count($projectIDs);
            $pplural=($plen>1)? "s" : "";
            if ($projectIDs[0]!=''){
                echo "<h3 style='margin-bottom:.25em'>You currently have $plen project$pplural:</h3>";
                echo"<form method='POST' action='student/studentInput.php' id='go2pform' style='display:inline;'>"
                ."<select id='projsel' name='projsel'>";
                for($i=0;$i<$plen;$i++){
                    $pid=$projectIDs[$i];
                    $pnam=$projectNames[$i];
                    echo"<option value='$pid'>$pnam</option>";
                }
                echo"</select>&nbsp;&nbsp; <input type='submit' id='go2proj' name='go2proj' value='go to project' disabled='disabled'/></form>";
            }else{
                echo"<span style='font-size:1.6em;'>&nbsp;<strong>You have no current projects.";
            }
        }catch(Exception $e){
            //handles database errors.
            echo DB_ERR;
        }

        echo"<br/><h3>Future Link to <a href='student/activity.php'>Activity Page</a></h3>";
    }
    $sth=null;//clear/kill connection.
    echo"</div>";
?>
<script>
    $(document).ready(function(){
        $("input:submit, button, #reset").button(); 
    });
</script>

