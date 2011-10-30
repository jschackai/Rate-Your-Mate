<!-- Class Creation created by Jon Linden 
	This will access the 
		

-->
<?php
    include('../includes/database.php'); //includes file witht he database funtions so we can use them here
    if(isset($_POST['IID'])){$user=htmlentities($_POST["IID"],ENT_QUOTES,'iso-8859-1');}else{$user="";}
	$classes=$database->getClasses($user);//function from the database.php file - returns an array of all classes for the provided instructor ($user)
?>
<html>
	<head>
		<!-- css stylesheets -->
        <link href='../css/styles.css' rel='stylesheet'/>
        <link href='../css/ui.spinner.css' rel='stylesheet'/>
        <link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/redmond/jquery-ui.css' rel='stylesheet'/>
        <!-- javascript files -->
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
        <script type="text/javascript" src="../js/ui.spinner.min.js"></script>
	</head>
	<body>
		Rate Your Mate - Override Form
		<title> Override Form | Rate Your Mate </title>
		<form name = "className" action = "link" method = "get"> 
			<!-- This will be pulled from database -->
			Class Name:
			<select>
				<option value="c1">Class 1</option>
				<option value="c2">Class 2</option>
				<option value="c3">Class 3</option>
				<option value="c4">Class 4</option>
			</select>
			<br>
			<!-- this is dependent on class and will be updated after class is selected -->
			Student Name: 

			<select>
				<option value="s1">Joe</option>
				<option value="s2">Jon</option>
				<option value="s3">Jeff</option>
				<option value="s4">Jen</option>
			</select>
			<br>
			
			Old Date and Time:
			<label for="oldDate"> October 26, 2011</label>
			<br>
			<!-- Pull in old date from data base and put in label -->
			New Date and Time:
			<!-- use fancy java script that Steven is using on the orginal creation page -->
			<br>
			<input type = "submit" value = "Update" />
			
			
			
			
			
		</form>
	</body>
</html>