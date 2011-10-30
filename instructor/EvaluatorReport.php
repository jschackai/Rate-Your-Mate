<HTML>
<HEAD>
<TITLE>Evaluator Report</TITLE>
</HEAD>

<BODY>
<h1>Rate Your Mate</h1>
<h2>Evaluator Report</h2>

<form action="ACTION GOES HERE">
<table>
<tr>
        <td>Project ID:</td>
        <td><select name="projectID"><option value="pId">Project list here...</option></td>
</tr>
<tr>
        <td>Choose a Student:</td>
        <td><select name="projectID"><option value="student">Student list here...</option></td>
</tr>
<tr>
        <td>Grade:</td>
        <td><input type="int" name="grade" value="Grade as text field?"/></td>
</tr>
<tr>
        <td>Grade:</td>
        <td><select name="grade"><option value="grade">Or as a drop-down?</option></td>
</tr>
</table>

<hr>
<h2>Scores Given by Evaluator</h2>
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
        <textarea rows='5' cols='70'>Instructor comment for student ".$i." here</textarea>";
        $i++;
}
?>
<p>Each evaluator's name and text field is printed via php loop since group sizes vary</p>
<h2>Behavior 2</h2>
<p>didnt make a  loop for behaviors but will need one if number of behavior varries as well</p>
<hr>

<button type="button">Confirm</button>
<button type="button">Cancel</button>

</BODY>
</HTML>
