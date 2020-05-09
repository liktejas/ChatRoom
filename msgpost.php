<?php
	include 'connection.php';
	$msg = $_POST['text'];
	$name = $_POST['name'];
	$ip = $_POST['ip'];

	$sql = "INSERT INTO `conv` (`convs`, `chatroom`, `ip`) VALUES ('$msg', '$name', '$ip')";
	mysqli_query($conn, $sql);
	mysqli_close($conn);

?>