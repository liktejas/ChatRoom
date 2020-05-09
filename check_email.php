<?php

$connect = mysqli_connect("localhost:3307","root","","chat2");
if(isset($_POST['email_to_check']))
{
	$email = mysqli_real_escape_string($connect,$_POST['email_to_check']);
	$q = "SELECT * FROM users WHERE email='".$email."'";
	$res = mysqli_query($connect, $q);
	echo mysqli_num_rows($res);
}
?>