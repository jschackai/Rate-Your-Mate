<!-- User Addition created by Jon Linden 
	This will access the user table and add a user to Users Table
		UID, uname, ulevel
		

-->
<html>
	<head></head>
	<body>
		Rate Your Mate - User Addition
		<title> User Addition | Rate Your Mate </title>
		
		<!-- Actually implement this -->
		<br> 
		<div class='m-b-1em'>
			<label for='numAddStudents'>Number of Students to add:</label> <input id='numAddStudents' name='numAddStudents' type="number" value="1" size='1' min='1' />
			<input type = "submit" value = "Update" />
		</div>
		
		
		<form name = "userAddition" action = "link" method = "get">
			<!-- input -->
			Last Name: <input type="text">
			First Name: <input type="text">
			Level: <input type="text">
			Student ID: <input type="text">
			<!--add student button
				a warning pop up should be integrated in case a user already exists and or ID-->
			<br>
			<input type = "submit" value = "Add Student(s) And Continue" />
		</form>
	</body>
</html>
			