<?php
    include('../includes/database.php'); //includes file witht he database funtions so we can use them here
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
<!DOCTYPE html>
<html>
    <head>
        <title>Rate Your Mate | Instructor Setup</title>
        <!-- css stylesheets -->
        <link href='../css/styles.css' rel='stylesheet'/>
        <link href='../css/ui.spinner.css' rel='stylesheet'/>
        <link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/redmond/jquery-ui.css' rel='stylesheet'/>
        <!-- javascript files -->
        <script type="text/javascript" src="../js/modernizer.js"></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
		<script type="text/javascript" src="../js/jquery-ui-timepicker.js"></script>
        <script type="text/javascript" src="../js/jquery.guid.js"></script>
        <script type="text/javascript" src="../js/ui.spinner.min.js"></script>
    </head>
    <body>
        <div class='right'>You are logged in as <?php echo $uname;?> <a href='../logout.php'>Logout</a></div>
        <div class='left half'>
        <!-- start the form! -->
            <form id='newproj'  method='post' action='procnew.php' class='m-b-1em'>
                <h1>Instructor Setup<img src='../img/help.png' title='help'/></h1>
                <div class='m-b-1em'>
                    Class: <select name='class' id='class'>
                        <option selected='selected'>Choose one...</option>
                        <?php
                            foreach($classes as $class){
                                $id=$class['id'];
                                $name=$class['name'];
                                echo"<option value='$id'>$name</option>";
                            }
                        ?>            
                    </select>
                </div>
                <div class='m-b-1em'>
                    <label for='pid'>Project ID</label>: <input id='pid' name='pid' placeholder='Insert project name.' />
                </div>
                <div class='m-b-1em'>
                    <label for='numgroups'>Number of Groups</label>: <input id='numgroups' name='numgroups' type="number" value="2" size='4' min='2' />
                </div>
                <div class='whole clear m-b-1em'>
                    <div id='groups' class='roundall'> <!-- this div contains the tabs -->
                        <ul id='grouptabs'>
                            <li><a href="#groups-1">Group 1</a></li>
                            <li><a href="#groups-2">Group 2</a></li>
                        </ul>
                        <div id="groups-1">
                            <ul style='list-style: none;'>
                                <li></li>
                            </ul>
                        </div>
                        <div id="groups-2">
                            <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
                        </div>
                    </div>
                </div>
                <div >
                    Who is creating the contract? (instructor always has override privileges)
                    <div style='padding-left:1em;' class='buttonset' id='radioset1'>
                        <input type="radio" name="contract" id='contract1' value="student" checked='checked' /> <label for='contract1'>Students</label>
                        <input type="radio" name="contract" id='contract2' value="instructor" /> <label for='contract2'>Instructor</label>
                    </div>
                </div>
            </form>
            <!-- close the form and start another - necessary due to the damn spinners, but I'll have a work-around -->
            <form id='newproj2' method='post' action='procnew.php'>
                <div>
                    Submit grades for (choose one):
                    <div style='padding-left:1em;' class='buttonset m-b-1em' id='radioset2'>
                        <input type="radio" name="grades" id='grades1' value="subject" /> <label for='grades1'>Evaluatee only</label>
                        <input type="radio" name="grades" id='grades2' value="judge" /> <label for='grades2'>Evaluator only</label>
                        <input type="radio" name="grades" id='grades3' value="both" checked='checked' /> <label for='grades3'>Both</label>
                        <input type="radio" name="grades" id='grades4' value="none" /> <label for='grades4'>None</label>
                    </div>
                </div>
                <div  class='m-b-1em'>
                    <label for='numeval'>How many evaluations? </label><input id='numeval' name='numeval' type="number" value="2" size='4' min='0' style='display:inline'>
                </div>
                <div class='m-b-1em'>
                    <label for='points'>How many points to distribute per evaluation? </label><input id='points' name='points' type="number" value="2" size='4' min='0' style='display:inline'><br />
                    <span class='hidden' style='font-style: italic;'>(For your average group size, we recommend <span id='recpnt'>X</span>.)</span>
                </div>
				<div class='m-b-1em'>
				<label for="oDate">Open Date:</label><input type="date" name="oDate" id="oDate"><br />
				<label for="">Close Date:</label><input type="date" name="cDate" id="cDate"><br />
				<label for="">Prevent Late Submissions:</label><input type="radio" name="late" id="lateyes" value="yes"/>Yes <input type="radio" name="late" id="lateno" value="no"/>No
				</div>
                <input type='submit' name='createproj' id='createproj' value='Create project'>
            </form>
        </div>
        <div id='studentlist' class='right half roundall' style='margin-top:256px;'>
            student list goes here
        </div>
    </body>
    <script type='text/Javascript'>
    //Whee-jquery!
 
        var spinner = $( "#numgroups" ).spinner();
        $(document).ready(function(){
            $("input:submit, button").button();
            $("#radioset1", "#radioset2").buttonset();
            $("#class").change(function(){
                var value=$(this).val();
                $.ajax({  
                    type: "POST",  
                    url: "../jx/roster.php?v="+jQuery.Guid.New(),  
                    data: "class="+value,  
                    success: function(data){
                        if(data!="<ul style='list-style:none'></ul>"){
                            var insert=data;
                        }else{
                            var insert="There are no students enrolled in this class!";
                        }
                        $("#studentlist").html(insert);
                    }  
                });
            });
            $( "#groups" ).tabs();
             //$("#numgroups").change(function(){alert($("#numgroups").val());}); 
			
			$('#oDate', '#cDate').datetimepicker({
				ampm: true
			});

			$("#studentlist li").draggable({
				appendTo: "body",
				helper: "clone"
			});
			$("groups ul").live().droppable({
				activeClass: "ui-state-highlight",
				hoverClass: "ui-state-hover",
				accept: ":not(.ui-sortable-helper)",
				drop: function(event,ui){
					$(this).find( ".placeholder" ).remove();
					$("<li class='ui-state-highlight' style='font-weight:bold;margin-bottom:.2em;list-style:none;'>"+ui.draggable.html()+"&nbsp;<a href='#'>[x]</a></li>").appendTo(this);
				}
			});
			
            $("form#newproj2").submit(function(){
                $.ajax({  
                    type: "POST",  
                    url: "jx/project.php?v="+jQuery.Guid.New(),  
                    data: $("#newproj").serialize()+$("#newproj2").serialize()+"&sid="+jQuery.Guid.New(),  
                    success: function(){

                    }  
                });  
                return false;  
            });
        });      


        //if(!Modernizr.inputtypes.number){$(document).ready(initSpinner);}; 
    </script>
</html>
