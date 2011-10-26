<?php
    include('includes/database.php');
    // variables needed to be passed in at start
    $user = '83af6624-f2e0-11e0-863b-003048965058';//user ID 
    //teacher2 (no projects assigned) is: 
    //$user = '6033e24c-f2ef-11e0-863b-003048965058';
    //note, the test IDs in the dtabase are the ones I put in here
    $students = array('83af630e-f2e0-11e0-863b-003048965058','aa6e4e22-f2e2-11e0-863b-003048965058', 'aa6e5192-f2e2-11e0-863b-003048965058','b8485cea-f2e2-11e0-863b-003048965058','b848601e-f2e2-11e0-863b-003048965058');//array of student IDs
    //check if instructor or student
    try{
        $sth = $database->connection->prepare("SELECT count(*) FROM Users WHERE UID=:uid AND ulevel=5");
        $sth->bindParam(':uid', $user, PDO::PARAM_STR);   
        $sth->execute();
        $numrows = $sth->fetchColumn();
        if($numrows!=1){
            header("Location: student/main.php");
        }
    }catch(Exception $e){
        echo $e;
    }
?>
<html>
    <head>
        <link href='css/styles.css' rel='stylesheet'>
        <link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css' rel='stylesheet'/>

        <script type="text/javascript" src="js/modernizer.js"></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>

    </head>
    <body>

        <div class='roundall' style='width:20em;margin:auto auto;'>
        <p>
            Welcome to the webspace for PSU Web Programming Rate-Your-Mate Team 4.<br />
            Please note: the script currently automatically logs you in as Prof. Roberson - a dummy account I created for testing.
            <br/>
            -Stephen Page
        </p>
            <?php
                try{  
                    $sth = $database->connection->prepare("SELECT * FROM Users LEFT JOIN Projects ON instructor=UID WHERE UID =:uid");
                    $sth->bindParam(':uid', $user, PDO::PARAM_STR);   
                    $sth->execute();
                    while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                        $ulevel=$row['ulevel'];
                        $uname=$row['fname']." ".$row['lname'];
                        $projectIDs[]=$row['PID'];
                        $projectNames[]=$row['pname'];
                    }
                    echo "Welcome $uname!<br /><br />";        
                    $plen=count($projectIDs);
                    if ($projectIDs[0]!=''){
                        echo "You currently have $plen projects:<br /><br />";
                        echo"<form method='POST' action='instructor/activity.php' id='go2form' name='go2form'>"
                        ."<input type='hidden' name='IID' value='$user'/>"
                        ."<select id='projsel' name='projsel'>";
                        for($i=0;$i<$plen;$i++){
                            $pid=$projectIDs[$i];
                            $pnam=$projectNames[$i];
                            echo"<option value='$pid'>$pnam</option>";
                        }
                        echo"</select> <input type='submit' id='go2proj' name='go2proj' value='go to project'/></form>"
                        ."<br />or, ";
                    }
                    echo"start a "
                    ."<form method='POST' action='instructor/newproj.php' id='newpform' name='newpform' style='display:inline'>"
                    ."<input type='hidden' name='IID' value='$user'/>"
                    ."<input type='submit' id='newproj' name='newproj' value='new project'/></form>";
                }catch(Exception $e){
                    //handles database errors
                    echo $e;
                }
                $sth=null;

                //check to see if projects have been set up, 
                //if no projects, then send directly to the instructor setup page if instructor, if student send to error page
                //if project, send user to project choice page  

            ?>
        </div>
    </body>
    <script type='text/Javascript'>
        $(document).ready(function() {
        });
    </script>
</html>