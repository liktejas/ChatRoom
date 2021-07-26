<?php
	include 'connection.php';
	$msg = mysqli_real_escape_string($conn, $_POST['text']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$ip = mysqli_real_escape_string($conn, $_POST['ip']);

	$sql = "INSERT INTO `conv` (`convs`, `chatroom`, `ip`) VALUES ('$msg', '$name', '$ip')";
	mysqli_query($conn, $sql);
	mysqli_close($conn);

?>