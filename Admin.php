<!-- 

	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The admin will be the only one to be able to access the admin page which will show the list 
	of all the the unassigned bookings that are within 3 hours from now. The list will show any pending book-
	ings from any date within 3 hours or from current time for 3 hours. The admin can assign cab to the pend-
	ing bookings by updating by the customer's reference number.
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
	// checks if submit was clicked by the user/ if update list was clicked
	if (isset($_POST['list']) || isset($_POST['update'])) 
	{
		//updates if reference number is provided.
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
				bookinglist();
			}
			else
			{
				
				bookinglist();
				echo "<h3> Please give valid reference booking number.</h3>";
				exit();
			}
		}
		else
		{
			bookinglist();
		}
	}


	// for showing list for 3 hours from the current time.
	function bookinglist()
	{
		include "Database.php";
		date_default_timezone_set("Australia/Melbourne");
		$todaydate = date('Y/m/d');
		$timestart = date('H:i');
		$timeend = date('H:i', strtotime('+180 minute'));
		
		//$datequery = " AND b.pickup_date = '$todaydate' AND b.pickup_time > '$timestart' AND b.pickup_time < '$timeend' ";
		//query for selecting data to display with the pickup time comparison with current time and time after 3 hours.
		$sql = "SELECT b.booking_number, c.customer_name, b.passenger_name, b.pass_contact_number, b.unit_number, b.street_number, b.street_name, b.suburb, b.destination, b.pickup_date, b.pickup_time FROM booking b, Customer c WHERE b.email_id = c.email_id AND b.status = 'unassigned' AND b.pickup_time > '$timestart' AND b.pickup_time < '$timeend' ";


		//echo $sql;
		$query = mysqli_query($conn, $sql);
		$result = mysqli_fetch_row($query);
		//echo  $result;
		if (count($result) > 0) 
		{
			//display the data in table format.
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
					echo "<td>". date('j M', strtotime($result[9])) ." " .$result[10] ." </td>";
					
				echo "</tr>";
				$result = mysqli_fetch_row($query);
			}

			echo "</table></center>";
			echo "<br /><br />";
			echo "<br /><br />";
			echo "<form method= \"post\" ><h3>2. Input a reference number below and click 'Update' button to assign a taxi to that resquest."; 
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
	mysqli_close($conn);
?>
<!-- <form method="post">
	<p><h3>2.Input a reference number below and click "Update" button to assign a taxi to that respect.</h3></p>
		<input type="text" name="number"  />
		<input type="submit" name="update" value="update" />
</form> -->
</body>
</center>

</html>
