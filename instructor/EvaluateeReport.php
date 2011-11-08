<?php //do NOT put anything above this line!
    $_GET['page']='Evaluatee Report'; //Variable to set up the page title - feeds header.php
    include('../includes/header.php');//this include file has all the paths for the stylsheets and javascript in it.
?>

<BODY>
<h1>Evaluatee Report</h1>

<form action="ACTION GOES HERE">
<table>
<tr>
	<td>Project ID:</td>
	<td>
	<select name="projectID" id="projectID">
		<option>Choose one...</option>
		<?php
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
                    echo"<option value='".$row['PID']."'>".$row['pname']."</option>";
                }
		?>
	</select>
	</td>
</tr>
<tr>
	<td>Choose a Student:</td>
	<td>
	<select name="student" id="students">
	<option>Choose one...</option>
	</select>
	</td>
</tr>
<tr>
	<td>Grade:</td>
	<td><input type="number" name="grade" value="Grade as text field?"/></td>
</tr>

</table>

<hr>
<h2>Mean Scores Recieved by Evaluatee</h2>
<table width=600><tr>
<td>Pie chart here</td>
<td>Legend for chart here</td>
</tr></table>
<hr>

<h2>Behavior 1</h2>

<?php
$numOfEvals=3;
$i=1;
while($i<=$numOfEvals){
	echo "<h3>Evaluatee # ". $i ."</h3>
	<textarea rows='5' cols='70'>Student ".$i." comments here</textarea><br>	
	<textarea rows='5' cols='70'>Instructor comments for student ".$i." here</textarea>";
	$i++;
}
?>
<p>Evaluatee names and text field are printed via php loop since group sizes vary</p>
<h2>Behavior 2</h2>
<p>didnt make a loop for behaviors but will need one if number of behavior varries as well</p>
<hr>

<h2>Additional Comments</h2>
<textarea rows='5' cols='70'>comments here...</textarea>
<br>

<button type="button" value='save' id='save'>Save Changes</button>
<button type="button" value='send' id='send'>Send to Student</button>
<button type="reset"  value='reset' id='reset'>Reset</button>
<script type='text/Javascript'> //Whee-jQuery!
 $(document).ready(function(){ 
    $("input:submit, button, #reset").button();
	
	$("#projectID").change(function(){
            var value=$(this).val();
            $.ajax({  
                type: "POST",  
                url: "../jx/project-student.php?v="+jQuery.Guid.New(),  
                data: "projectID="+value,  
                success: function(data){
                    $("#students").html(data);
                }  
            });
        }); 
});
	</script>
</BODY>
</HTML>
