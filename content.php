
<div class='roundall' style='width:20em;margin:auto auto;'>
    <p>
        Welcome to the webspace for PSU Web Programming Rate-Your-Mate Team 4.<br />
        <br/>
        -Stephen Page
    </p>
    <?php
        try{  
            $sth = $database->connection->prepare("SELECT * FROM Users LEFT JOIN Projects ON instructor=UID WHERE UID =:uid");
            $sth->bindParam(':uid', $session->UID, PDO::PARAM_STR);   
            $sth->execute();
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                $uname=$row['fname']." ".$row['lname'];
                $projectIDs[]=$row['PID'];
                $projectNames[]=$row['pname'];
            }
            echo "Welcome ".$session->realname."!<br /><br />";        
            $plen=count($projectIDs);
            if ($projectIDs[0]!=''){
                echo "You currently have $plen projects:<br /><br />";
                echo"<form method='POST' action='instructor/activity.php' id='go2form' name='go2form'>"
                ."<select id='projsel' name='projsel'>";
                for($i=0;$i<$plen;$i++){
                    $pid=$projectIDs[$i];
                    $pnam=$projectNames[$i];
                    echo"<option value='$pid'>$pnam</option>";
                }
                echo"</select> <input type='submit' id='go2proj' name='go2proj' value='go to project'/><br/><i>(doesn't work yet!)</i></form>"
                ."<br />or, ";
            }else{
			echo"You have no current projects running. <br/>";
			}
            echo"start a "
            ."<form method='POST' action='instructor/project.php' id='newpform' name='newpform' style='display:inline'>"
            ."<input type='submit' id='newproj' name='newproj' value='new project'/></form>";
        }catch(Exception $e){
            //handles database errors
            echo DB_ERR;
        }
        $sth=null;//clear/kill connection
    ?>
</div>
</body>
<script type='text/Javascript'>
    $(document).ready(function() {
    });
    </script>
</html>
