<!-- 

	Name: Sonali Dilip Chauhan
	Student ID: 102836414
	Description: The logout page is use to Sign out from the page.
	It will destroy session on every login and logout.
 -->

<?php
session_start();
//unset($_SESSION['email_id']);
session_destroy();
header('Location: Login.php');

?>