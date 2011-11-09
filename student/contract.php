<?php //do NOT put anything above this line!
    $_GET['page']=$page='Student Input'; //Variable to set up the page title - feeds header.php
    include('../includes/header.php');//this include file has all the paths for the stylsheets and javascript in it.
    $project='0068F621-1BC9-477E-8DDB-50D637DB8884';//pass me a project
    $gid=$database->getGroupID($project,$session->UID);
    //$team=$database->groupRoster($gid,$session->UID);//get list of group members from database
    $behaviors=$database->getBehaviors($gid);
?>
<!-- Originally made by Reichard Frederick edited by Jon Linden
Css will take care of resizing textareas textarea{ resize:none;} -->

	<?php //echo count($behaviors); ?>
        <form name="input" action="" method="get">       
            <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em' style='width:650px;'>
                <div class='ui-corner-top ui-widget-header m-b-1em'><h2>Group Goals</h2></div>
				<textarea rows="10" cols="100" name="groupGoal" style='margin-left:.5em;'>I have not put this in the database yet...</textarea>
			</div>
			<?php if(count($behaviors>0)){
					foreach($behaviors as $behave){
						$title=$behave['title'];
						$bid=$behave['id'];
						$notes=$behave['notes'];
						echo"<div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em half'>"
						."<div class='ui-corner-top ui-widget-header m-b-05em'><input name='title-$bid' id='id-$bid' value='$title' style='width:18em'></div>"
						."<textarea rows='5' cols='50' name='notes-$bid' id='notes-$bid' style='width:99%'>$notes</textarea></div>";
					}
				}else{
				for($x=0;$x<3;$x++){
						echo"<div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em half'>"
						."<div class='ui-corner-top ui-widget-header m-b-05em'><input name='title-$x' id='id-$x' style='width:18em'></div>"
						."<textarea rows='5' cols='50' name='notes-$x' id='notes-$x' style='width:99%'></textarea></div>";
				
				}
				}
			?>
			<input type='submit' name='contract' id='contract' value='Submit Changes' style='color:#E17009;font-size:1.5em;'>
			<!-- need a php if against the session-isInstriuctor() to decide which button to show -->
			<?php if($session->isInstructor()||$session->isAdmin()){ ?>
			<input type='submit' name='finalize' id='finalize' value='Finalize' style='color:#E17009;font-size:1.5em;'>
			<?php }else{ ?>
			<input type='submit' name='accept' id='accept' value='Accept' style='color:#E17009;font-size:1.5em;'>
			<?php } ?>
			<input type='reset' name='reset' id='reset' value='Cancel' style='color:#E17009;font-size:1.5em;'>

        </form>

    </body>
</html>