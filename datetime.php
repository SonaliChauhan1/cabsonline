

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
	<title>Admin Access</title>
</head>
<body>
<a href="Logout.php">Sign Out</a>
<center>
	<h1>Admin Page of Cabs Online</h1>
	<h3>1. Click below button to search for all unassigned booking requests with a pick-up time within 3 hours.</h3>
	
	<form method="post">
		<input type="submit" name="list" value="List all" />
	</form>
	
		
<?php

include "Database.php";

	if (isset($_POST['list']) || isset($_POST['update'])) 
	{
		
		if (isset($_POST['number'])) 
		{
			
			$sqlbooking = "SELECT COUNT(*) FROM booking WHERE booking_number = '".$_POST['number']."'";
			$querybooking = mysqli_query($conn, $sqlbooking);
			$resultbooking = mysqli_fetch_row($querybooking);
			if ($resultbooking[0] > 0) 
			{
				$sql1 = "UPDATE booking SET status = 'assigned' WHERE booking_number= ".$_POST['number'];
				$query1 = mysqli_query($conn, $sql1);
				echo "<h3> The booking request ". $_POST['number'] . " has been assigned.</h3>";
				listbooking();
			}
			else
			{
				
				listbooking();
				echo "<h3> Please give valid reference booking number.</h3>";
				exit();
			}
		}
		else
		{
			listbooking();
		}
	}



	function listbooking()
	{
		echo "hey";
		include "Database.php";
		date_default_timezone_set("Australia/Sydney");
		$todaydate = date('Y-m-d');
		echo $todaydate;
		$timestart = date('H:i:s');
		echo $timestart;
		$timeend = date('H:i:s', strtotime('+180 minutes'));
		echo $timeend;
		//$datequery = " AND b.pickup_date = '$todaydate' AND b.pickup_time > '$timestart' AND b.pickup_time < '$timeend' ";
		$sql = "SELECT b.booking_number, c.customer_name, b.passenger_name, b.pass_contact_number, b.unit_number, b.street_number, b.street_name, b.suburb, b.destination, b.pickup_date, b.pickup_time FROM booking b, Customer c WHERE b.email_id = c.email_id AND b.status = 'unassigned' AND b.pickup_date = '$todaydate' AND b.pickup_time > '$timestart' AND b.pickup_time < '$timeend'";
		echo $sql;
		$query = mysqli_query($conn, $sql);
		$result = mysqli_fetch_row($query);
		if (count($result) > 0) 
		{
			echo "<center><table border='1'>";
			echo "<th> Reference# </th>";
			echo "<th> Customer Name </th>";
			echo "<th> Passenger Name </th>";
			echo "<th> Passenger Contact Name</th>";
			echo "<th> Pickup Address </th>";
			echo "<th> Destination Suburb </th>";
			echo "<th> Pick-time </th>";

			while ($result) 
			{
			 	echo " <tr>";
					echo "<td>". $result[0] ." </td>";
					echo "<td>". $result[1] ." </td>";
					echo "<td>". $result[2] ." </td>";
					echo "<td>". $result[3] ." </td>";
					if (empty($result[4])) 
					{
						$address = $result[5]." ".$result[6]. ", ".$result[7];
					}
					else
					{
						$address = $result[4]."/".$result[5]." ".$result[6]. ", ".$result[7];
					}
					echo "<td>". $address ." </td>";
					echo "<td>".$result[8]." </td>";
					echo "<td>". date('j n', strtotime($result[9])) ." " .$result[10] ." </td>";
					
				echo "</tr>";
				$result = mysqli_fetch_row($query);
			}

			echo "</table></center>";
			echo "<br /><br />";
			echo "<br /><br />";
			echo "<form method= \"post\" ><h3>2. Input a reference number below and click 'Update' button to assign a taxi to that respect."; 
			echo "</h3>";
			echo "<input type= \"text\" name=\"number\" />";
			echo "<input type = \"submit\" name = \"update\" value=\"update\" />";
			echo "</form>";
		}
		else
		{
			echo "<h3> There are no pending booking request within 3 hours for now. </h3>";
		}
	}
	
?>
<!-- <form method="post">
	<p><h3>2.Input a reference number below and click "Update" button to assign a taxi to that respect.</h3></p>
		<input type="text" name="number"  />
		<input type="submit" name="update" value="update" />
</form> -->
</body>
</center>

</html>





















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
 	function validTime($pickup_time)
 	{
 		$time_pattern = "/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";
 		$timeflag = preg_match($time_pattern, $pickup_time);

 		if ($timeflag != 1) 
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
 
    function validdatetime($pickup_date, $pickup_time)
    {
    	$time = $pickup_date.":".$pickup_time;
    	
    	$date = date('Y/m/d H:i:s', strtotime("$pickup_date $pickup_time")); echo "<br />";
    	//echo date_format($date, 'Y/m/d:H:i');
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
    
   function insertData($booking_number,$pass_name,$email_id, $pass_contact, $unit_number, $street_number, $street_name,$suburb,$des_suburb, $timestamp_pickup, $booking_datetime,$status)
   {
   		include "Database.php";
   		$pickup_time = trim($_POST["pickup_time"]);
 		$pickup_date = trim($_POST["pickup_date"]);
   		$timestamp_pickup = date('Y/m/d H:i:s', strtotime("$pickup_date $pickup_time"));
		date_default_timezone_set("Australia/Sydney");
	 	$booking_datetime = date("Y/m/d H:i:s", time())."<br />";
	 	$status = "unassigned";

	 	$sql = "INSERT INTO booking(booking_number, passenger_name, email_id, pass_contact_number, unit_number, street_number, street_name, suburb, destination, pickup_date, pickup_time, booking_datetime, status) VALUES('$booking_number','$pass_name','$email_id', '$pass_contact', '$unit_number', '$street_number', '$street_name','$suburb','$des_suburb', '$pickup_date', '$pickup_time', '$booking_datetime','$status')";

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
 		validTime($pickup_time);
 		if(validdatetime($pickup_date, $pickup_time))
 		{
 			insertData($booking_number,$pass_name,$email_id, $pass_contact, $unit_number, $street_number, $street_name,$suburb,$des_suburb, $timestamp_pickup, $booking_datetime,$status);
 		}
 		else
 		{
 			    $currenttime = date_format(new datetime($timestamp_pickup), 'Y/m/d:H:i');
    			$changetime = date('H:i',strtotime('+40 minute'));
    			echo "<center> Your booking time is ".$currenttime." . You cannot book the cab before " . $changetime."</center>";
 		}
 		
	}
}
?>