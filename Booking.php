<!-- 

	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The booking page is used to book a cab. The user/customer can book
	a cab by entering the details as required. The user have to input time in 24 hours
	format HH:MM. The cab can be booked after 40 mins of the current time. After booking
	a cab a message will be displayed to the user about registration confirmation and 
	sending a mail. The mail will be send to the user with time and reference number.
	it also has logout functionality which will redirect to login page.
 -->

<?php
session_start();

if (!$_SESSION['email_id']) 
{
	header('Location: Login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Booking Cabs</title>
</head>
<body>
<form method="post" action="">
	<center>
		<table>
		<h2>Booking a Cab</h2>
		<h2>Welcome, <?php echo $_GET['email'] ;?> .</h2>
		<p>Please fill the fields below to book a Taxi.</p>
		<tr><td>Passenger Name: </td><td><input type="text" name="pass_name" placeholder="Enter your name here." required /></td></tr>
		<tr><td>Contact Person of the passenger:</td><td> <input type="text" name="pass_contact" placeholder="Contact number 0456123789." required /></td></tr>
		<tr><td>Pickup Address: </td><td>Unit Number : <input type="text" name="unit_number"  /></td></tr>
			<tr></td><td><td>Street Number :<input type="text" name="street_number" required /></td></tr>
			<tr></td><td><td>Street Name: <input type="text" name="street_name" required /></td></tr>
			<tr></td><td><td>Suburb: <input type="text" name="suburb" required /></td></tr>
		<tr><td>Destination suburb: </td><td> <input type="text" name="des_suburb" required /></td></tr>
		<tr><td>Pickup Time: </td><td><input type="text" name="pickup_time" placeholder="HH:MM" required /></td></tr>
		<tr><td>Pickup Date: </td><td><input type="date" name="pickup_date" required /></td></tr>
		<tr><td><input type="submit" name="book" value="book" required /></td></tr>
		<a href="Login.php">LOGIN PAGE</a><a href="Logout.php">SIGN OUT</a>
		</table>
	</center>
</form>
</body>
</html>

<?php
include "Database.php";
// to check if the submit button was clicked.
if (isset($_POST["book"])) {
 	
 	$booking_number = rand(10, 100);
 	//echo $email_id;
 	$pass_name = trim($_POST["pass_name"]);
 	$email_id = trim($_GET['email']);
 	$pass_contact = trim($_POST["pass_contact"]);
 	$unit_number = trim($_POST["unit_number"]);
 	$street_number = trim($_POST["street_number"]);
 	$street_name = trim($_POST["street_name"]);
 	$suburb = trim($_POST["suburb"]);
 	$des_suburb = trim($_POST["des_suburb"]);
 	$pickup_time = trim($_POST["pickup_time"]);
 	$pickup_date = trim($_POST["pickup_date"]);
 	$timestamp_pickup = date('Y/m/d H:i:s', strtotime("$pickup_date $pickup_time"));
 	//echo $booking_number;
	date_default_timezone_set("Australia/Sydney");
 	$booking_datetime = date("Y/m/d H:i:s", time())."<br />";
 	$status = "unassigned";
 	//echo $pickup_time. "<br />";
 	//will check if the time format entered is in 24 hour format.
 	function correcttime($pickup_time)
 	{
 		$time_pattern = "/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";
 		$time = preg_match($time_pattern, $pickup_time);

 		if ($time != 1) 
 		{
 			echo "please enter valid time as shown in the format";
 			exit();
 		}
 		else
 		{
 			//echo "correct time format";
 			return true;
 			//echo $pickup_time;
 		}
 	}

	date_default_timezone_set("Australia/Sydney");
 	$booking_datetime = date("Y/m/d H:i:s", time())."<br />";
 	
 	//to compare time and date with 40 minutes after current time.
    function comparedatetime($pickup_date, $pickup_time)
    {
    	$time = $pickup_date.":".$pickup_time;
    	
    	$date = date('Y/m/d H:i:s', strtotime("$pickup_date $pickup_time")); echo "<br />";
    	if (date_format( new datetime($date), 'Y/m/d:H:i') > date('Y/m/d:H:i', strtotime('+40 minute'))) 
    	{
    		//echo "You can book the cab";
    		return true;
    	}
    	else
    	{
    		
    		return false;
    	}
    }
    //insert the data functionality.
   function insertData($booking_number,$pass_name,$email_id, $pass_contact, $unit_number, $street_number, $street_name,$suburb,$des_suburb, $pickup_time,$pickup_date, $booking_datetime,$status)
   {
   		include "Database.php";
   		$timestamp_pickup = date('Y/m/d H:i:s', strtotime("$pickup_date $pickup_time"));
		date_default_timezone_set("Australia/Sydney");
	 	$booking_datetime = date("Y/m/d H:i:s", time())."<br />";
	 	$status = "unassigned";

	 	$sql = "INSERT INTO booking(booking_number, passenger_name, email_id, contact_number, unit_number, street_number, street_name, suburb, destination, pickup_date, booking_datetime, status) VALUES('$booking_number','$pass_name','$email_id', '$pass_contact', '$unit_number', '$street_number', '$street_name','$suburb','$des_suburb', '$pickup_date', '$pickup_time', '$booking_datetime','$status')";
	 	// mail() functionality.
 		if (mysqli_query($conn, $sql)) 
 		{	
			echo "<h2><center> Thank You! Your booking reference number is ". $booking_number .". We will pick up the passengers in front of your provided address at ".$pickup_time . " on ".$pickup_date . "</center></h2>";
	 		
			//$to = "sonali261295@gmail.com";
			$to = $_GET['email'];
			//echo $to; 
			//$email_id = trim($_GET['email']);
			$subject = "Your booking is request with CabsOnline!";
			$message = "Dear ".$pass_name. ", Thanks for booking with CabsOnline! Your booking reference number is ".$booking_number. ". We will pick up the passengers in front of your provided address at ".$pickup_time." on ".$pickup_date.".";
			$header = "From: booking@cabsonline.com.au";
			$ok = mail($to, $subject, $message, $header);
				if ($ok) 
				{
					echo "<center><h3> mail sent successfully</h3></center>";
				}
				else
				{
					$to = "sonali261295@gmail.com";
					$subject = "Email not sent CabsOnline";
					$message = "The cab was not booked for customer named ".$pass_name. " with booking number ".$booking_number. ". The pickup date/time was ".$pickup_time." on ".$pickup_date.".";
					//echo "email not sent";
					$header = "From: booking@cabsonline.com.au";
					mail($to, $subject, $message, $header);
				}

				exit();
		}
		else
		{	
			echo "Not inserted. Please try again" . mysqli_error($conn);
		}

   }





 	if (empty($pass_name) || empty($pass_contact) || empty($street_number) || empty($street_name) || empty($suburb) || empty($des_suburb) || empty($pickup_time) || empty($pickup_date)) 
 	{
 		# code...
 		echo "please enter all the required fields";
 		exit();
 	}
 	else
 	{
 		correcttime($pickup_time);
 		if(comparedatetime($pickup_date, $pickup_time))
 		{
 			insertData($booking_number,$pass_name,$email_id, $pass_contact, $unit_number, $street_number, $street_name,$suburb,$des_suburb, $pickup_time,$pickup_date, $booking_datetime,$status);
 		}
 		else
 		{
 			    $currenttime = date_format(new datetime($timestamp_pickup), 'Y/m/d:H:i');
    			$changetime = date('H:i',strtotime('+40 minute'));
    			echo "<center> Your booking time is ".$currenttime." . You cannot book the cab after ". $pickup_date." and before ". $changetime."</center>";
 		}
 		
	}
}
mysqli_close($conn);
?>