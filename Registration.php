<!-- 

	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The Registration page in Cabsonline is used to register customers and admin. 
	The registration page will take required details from the user make entry into the Custo-
	mer table. The email address will be checked with other email address in the customer table.
	If the email address is already present error message will be shown or entry will be made in
	the customer table.
 -->

<!DOCTYPE html>

<head>
	<title>CabsOnline - Registration</title>
	<meta charset="utf-8">
	<meta name="author" content="Sonali Chauhan">

</head>

<body>
	<center>
<form method="POST" action="">
	<center>	
		<h1>Register to CabsOnline</h1><br/>
		<h3>Please fill the fields below to complete your registration</h3></center>

		Name: <input type="text" name="customer_name" placeholder="Enter your Name here." required /><br/>
		Email: <input type="email" name="email_id" placeholder="Enter your Email Address here." required /><br/>
		Password: <input type="password" name="password" placeholder="Enter your Password here." required /><br/>
		Confirm Password: <input type="password" name="cpassword" placeholder="Re-enter your password here." required /><br/>
		Phone: <input type="text" name="contact_number" placeholder="Enter your Phone Number here." required /><br/>
		<input type="submit" name="register" value="register" /><br/>

		Already registered? <a href="Login.php">Login Here</a>

	
</form>	
</center>
</body>

</html>

<?php
include "Database.php";
// this will check if the submit button was clicked or not.
if (isset($_POST['register'])) {

$customer_name = trim($_POST['customer_name']);
$email_id = trim($_POST['email_id']);
$password = md5(trim($_POST['password']));
$cpassword = md5(trim($_POST['cpassword']));
$contact_number = trim($_POST['contact_number']);

if (empty($customer_name) || empty($email_id) || empty($password) || empty($cpassword) || empty($contact_number)) 
{
	echo "<center><h3> Please fill all the fields. </h3></center>";
}
else
{
	// this will check if email address exists or not. 
	$sql1 = "SELECT email_id FROM Customer where email_id = '$email_id'";
	$query1 = mysqli_query($conn, $sql1);
	//this will check if password is matching confirm password.		
	if ($password != $cpassword ) 
	{
		echo " <center><h3>  Your passwords don't match. Please try again.</h3></center>";
	}
	elseif (mysqli_num_rows($query1) > 0 ) 
	{
			echo " <center><h3> Sorry email id already exists </h3></center>";
	}
	else
	{
		//insert query to insert data into customer table.
		$sql = "INSERT INTO Customer (customer_name, email_id, password, contact_number) VALUES ('$customer_name', '$email_id', '$password', '$contact_number')";
		if (mysqli_query($conn, $sql)) 
		{	
			echo "<center><h3> Thanks for registering. </h3></center>";
		}
		else
		{
			echo "<center><h3> Not registered. Please try again.</h3></center>" . mysqli_error($conn);
		}
	}
}


}

mysqli_close($conn);
?>