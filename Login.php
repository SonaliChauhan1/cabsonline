<!-- 

	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The Login page in CabsOnline is used to enter into the system.
	The email address and password is required to enter into the system. If the 
	user is customer they will be directed to Booking page and if the user is 
	admin they will be directed to admin page. The admin can only have access to 
	Admin page. If the admin wants to book a cab he will have to register as a 
	cutomer.
 -->


<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>CabsOnline - Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
<form method="POST" action="">
	<center>	
		<h1>Login to CabsOnline</h1><br/>
		<div class="form-group">Email: <input type="text" name="email_id" required /><br/></div>
		Password: <input type="password" name="password" required /><br/>
		<input type="submit" name="login" value="login" /><br/>

		New Member? <a href="Registration.php">Register Here</a>

	</center>

</form>	

</body>
</html>

<?php

include "Database.php";
// this will check if the submit button was clicked or not.
if (isset($_POST['login'])) {

	if(empty($_POST['email_id']) || empty($_POST['password']))
	{
		echo "<center> Please enter all fields </center>";
	}
	else
	{
		//to login into the system
		$email_id = trim($_POST['email_id']);
		$password = md5(trim($_POST['password']));
		$sql = "SELECT email_id, password FROM Customer WHERE email_id = '$email_id'and password = '$password'";
		//print_r($sql);	
		$query = mysqli_query($conn, $sql);
		//print_r($query);
		echo $result = mysqli_fetch_row($query);
		//Check if a user is customer or admin.
		if($result > 0)
		{
			if($email_id  == "admin@gmail.com")
			{
				$_SESSION['email_id'] = "admin@gmail.com";
				header("Location:Admin.php?email=".$email_id);
			}
			else
			{
				$_SESSION['email_id'] = $email_id  ;
				header("Location:Booking.php?email=".$email_id);
			}
		}
		else
		{
			echo "<center><h3> Email id does not exists OR You may have entered wrong Email ID. please register. </h3></center>";
		}


	}

}
mysqli_close($conn);
?>