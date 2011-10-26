<?php
    include('../includes/database.php');
    if(isset($_POST['IID'])){$user=htmlentities($_POST["IID"],ENT_QUOTES,'iso-8859-1');}else{$user="";}

    $students=$database->getStudents();
    $stulen=count($students);
    $courses=$database->getClasses($user);
    $crslen=count($courses);
?>
<html>
    <head>
        <link href='../css/styles.css' rel='stylesheet'>
        <link href='../css/ui.spinner.css' rel='stylesheet'>
        <link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css' rel='stylesheet'/>

        <script type="text/javascript" src="../js/modernizer.js"></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
        <script type="text/javascript" src="../js/jquery.guid.js"></script>
        <script type="text/javascript" src="../js/ui.spinner.min.js"></script>

    </head>
    <body>
        <?php 
            //include("../includes/logout.php?IID=$user");
        ?>
        <form method='post' id='enrollmentForm'>
            <div>
                <select name='courseid' id='courseid'>
                    <?php
                        for($i=0;$i<$crslen;$i++){
                            $id=$courses[$i]['id'];
                            $name=$courses[$i]['name'];
                            echo"<option name='course' value='$id'>$name </option>";
                        }
                    ?>
                </select><br /><br />
            </div>
            <div id='roster'>
                <?php
                    for($i=0;$i<$stulen;$i++){
                        $id=$students[$i]['id'];
                        $fname=$students[$i]['fname'];
                        $lname=$students[$i]['lname'];
                        echo"<input type='checkbox' name='students[]' id='$id' value='$id'><label for='$id'>$lname, $fname</label><br/>";
                    }
                ?>
            </div>
            <br /><br />
            <input type='submit' value='Enroll!'> 
        </form>
        <div id='messagebox' style='color:red'>
        </div>
    </body>
    <script type='text/Javascript'>
        $(document).ready(function() {
            $("input:submit, button").button();
            $("form#enrollmentForm").submit(function(){
            $.ajax({  
                type: "POST",  
                url: "../jx/enroll.php?v="+jQuery.Guid.New(),  
                data: $(this).serialize()+"&sid="+jQuery.Guid.New(),  
                success: function(){
                    $("#messagebox").html("Students successfully enrolled!");
                }  
            });  
            return false;  
        });
        });
    </script>
</html>