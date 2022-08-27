<!-- 

	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The database will connect with mercury database set by the Swinburne university.
	It will connect with the database and can access any table from the database.
 -->


<?php

$conn = mysqli_connect("localhost", "root", "","customer_information");

if (!$conn) {
	die("Your database connection is not set.".mysqli_connect_error($conn));
}
?>