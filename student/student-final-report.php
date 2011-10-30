<?php
    include('../includes/database.php'); //includes file with the database funtions so we can use them here
    if(isset($_POST['IID'])){$user=htmlentities($_POST["IID"],ENT_QUOTES,'iso-8859-1');}else{$user="";}
    try{//this is a PDO connection to the database
        $sth = $database->connection->prepare("SELECT fname, lname FROM Users WHERE UID=:uid");//prepare the query
        $sth->bindParam(':uid', $user, PDO::PARAM_STR); //binds the user variable to the query so PDO can format it correctly
        $sth->execute(); //runs the query
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)){ //loop through the results
            $uname=$row['fname']." ".$row['lname']; //associate the results with a php variable
        }
    }catch(Exception $e){//error handling
        echo $e;
    }
    $classes=$database->getClasses($user);//function from the database.php file - returns an array of all classes for the provided instructor ($user)
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Student Final Report</title>
        <!-- css stylesheets -->
        <link href='../css/styles.css' rel='stylesheet'/>
        <link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/redmond/jquery-ui.css' rel='stylesheet'/>
        <!-- javascript files -->
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>

    </head>
    <body>
        <h1>Rate Your Mate</h1>
        <form action="Insert_PHP" method="post">

            <select name="Project ID">
                <option value="0">Choose one...</option>
                <?php
                    /*for given student, get all projects they are in and loop:
                    * $projects = array();
                    * foreach ($projects as $project){
                    *   echo" <option value='$project['id']'>$project['name']</option>"
                    * }
                    */

                ?>
                <option value="Project 1">Project 1</option>
                <option value="Project 2">Project 2</option>
                <option value="Project 3">Project 3</option>
                <option value="Project 4">Project 4</option>
        </select> </form>

        <h2>Mean Score:</h2>
        <div id='pie-chart' style='border: 1px solid #000;height:10em;width:10em;'>this is where the image will go</div>
        <h2>Grade:<span id='grade'>76%</span></h2>
        <!-- get behaviors from database (based on project and group) and loop through them, adding appropriate student comments. --> 
        <?php           
            /*
            * grab behaviors 
            */        
        ?>
        <h2 style="border: 1px solid #000;border-bottom:1px solid #FFF;width:10em;margin-bottom:-20px;">Behavior 1</h2>
        <div style="border:1px solid #000;">
            <p><h3>Student Comments:</h3>
                Comments go here!
            </p>
            <p><h3>Instructor Comments:</h3>
                Comments go here!
            </p>
        </div>

        <button value="OK">OK</button>
        <script>
            $(document).ready(function(){
                $("input:submit, button").button();
            });
        </script>
    </body>
</html>
