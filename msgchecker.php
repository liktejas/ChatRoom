<?php
	session_start();
	include 'connection.php';

	$name = $_POST['name'];
	// $sql = "SELECT convs, stored_at, ip FROM conv WHERE name = '$name';";
	$sql = "SELECT `convs`, `ip`, `stored_at` FROM `conv` WHERE chatroom = '$name' ORDER BY `id` DESC";
	// print_r($sql);
	$res = "";
	$result = mysqli_query($conn, $sql);
	// print_r($result);
	if(mysqli_num_rows($result)>0)
	{
		// $row = mysqli_fetch_assoc($result);
		// if($row['ip'] == $_SERVER['REMOTE_ADDR'])
		// {
			// echo 'same';
			$remote_ip = $_SERVER['REMOTE_ADDR'];
			while ($row = mysqli_fetch_assoc($result)) {
				if($row['ip'] == $remote_ip)
				{
					$sql1 = "SELECT `convs`, `ip`, `stored_at` FROM `conv` WHERE chatroom = '$name' AND ip = $remote_ip ORDER BY `id` DESC";
				$res = $res.'<div class="container1">';
				$res = $res.'<b style="color: #fca400">You</b>';
				$res = $res."<p>".$row['convs'];
				$res = $res.'</p> <span class="time-right">'.$row["stored_at"].'</span></div>';
				}
				else
				{
					$res = $res.'<div class="container">';
					$res = $res.'<b style="color: #4ef55c">'.$row['ip'];
					$res = $res." says</b> <p>".$row['convs'];
					$res = $res.'</p> <span class="time-right">'.$row["stored_at"].'</span></div>';
				}
		}

		// }
		// else{
		// 	// echo 'not same';
		// }
		// echo($row['ip']);
		// echo $_SERVER['REMOTE_ADDR'];
		// exit();
		// while ($row = mysqli_fetch_assoc($result)) {
		// 	$res = $res.'<div class="container">';
		// 	$res = $res.'<b>'.$row['ip'];
		// 	$res = $res." says</b> <p>".$row['convs'];
		// 	$res = $res.'</p> <span class="time-right">'.$row["stored_at"].'</span></div>';
		// }
	}
	echo $res;
?>