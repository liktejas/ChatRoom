<?php
	session_start();
	include 'connection.php';
	if((empty($_SESSION['id'])) || empty(($_SESSION['user_name'])) || empty($_SESSION['email']))
     	{
		   header('Location: '.$base_url.'index.php');
    	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Jekyll v3.8.6">
	<title>ChatRoom - Home</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- Favicons -->
	
	<link rel="icon" href="https://img.icons8.com/cute-clipart/64/000000/chat.png">
	<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
	<meta name="theme-color" content="#563d7c">


	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

	</style>
	<!-- Custom styles for this template -->
	<link href="cover.css" rel="stylesheet">
</head>
<body class="text-center">
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
		<header class="masthead mb-auto">
			<div class="inner">
				<h3 class="masthead-brand"><img src="https://img.icons8.com/cute-clipart/64/000000/chat.png"> ChatRoom</h3>
				<nav class="nav nav-masthead justify-content-center">
					<a class="nav-link active" href="<?php echo $base_url?>chat.php">Home</a>
					<a class="nav-link" href="<?php $base_url?>continue_room.php">Continue Room</a>
					<a class="nav-link" href="#"></a>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $_SESSION['user_name']?>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="<?php echo $base_url?>change.php">Change Password</a>
						<a class="dropdown-item" href="<?php echo $base_url?>logout.php">Logout</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo $base_url?>deactivate.php" onclick="return fun_deactivate()">Deactivate Account</a>
						</div>
					</li>
				</nav>
			</div>
		</header>

		<main role="main" class="inner cover">
			<?php

				if(isset($_POST['submit']))
				{
					$name = $_POST['name'];
					if(empty($name))
					{
						$error_msg = 'Please Enter ChatRoom Name';
						echo '	<div class="alert alert-danger alert-dismissible fade show" role="alert">'.
  								$error_msg.'
  								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<span aria-hidden="true">&times;</span>
  								</button>
								</div>';
					}
					else if(strlen($name)<2 or strlen($name)>10)
					{
						$error_msg = 'Please Enter ChatRoom Name between 2 to 10 Characters';
						echo '	<div class="alert alert-warning alert-dismissible fade show" role="alert">'.
  								$error_msg.'
  								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<span aria-hidden="true">&times;</span>
  								</button>
								</div>';	
					}
					else if(ctype_digit($name))
					{
						$error_msg = 'ChatRoom Name cannot start with number(s)';
						echo '	<div class="alert alert-warning alert-dismissible fade show" role="alert">'.
  								$error_msg.'
  								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<span aria-hidden="true">&times;</span>
  								</button>
								</div>';
					}
					else
					{
						$sql = "SELECT * FROM `people` WHERE name='$name'";
						// print_r($sql);
						$result = mysqli_query($conn, $sql);
						if($result)
						{
							if(mysqli_num_rows($result) > 0)
							{
								$error_msg = 'The Chatroom on this name is already registered, Please Enter Another Name';
								echo '	<div class="alert alert-warning alert-dismissible fade show" role="alert">'.
	  								$error_msg.'
	  								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    							<span aria-hidden="true">&times;</span>
	  								</button>
									</div>';
								// echo "<script>alert('Room already registered');</script>";
							}
							else
							{
								$sql = "INSERT INTO `people` (`name`) VALUES ('$name')";
								if(mysqli_query($conn, $sql))
								{
									$msg = "Your ChatRoom is ready!!!";
									echo '<script>';
									echo 'alert("'.$name." - ".$msg.'");';
									echo 'window.location="'.$base_url.'rooms.php?name='.$name.'";';
									echo '</script>';

								}
							}
						}
					}
				}
	?>
			<h1 class="cover-heading">Welcome to the ChatRoom.</h1>
			<p class="lead">ChatRoom is the place where you can chat with your friends across all the barries of the world. To begin chat just enter room name below.</p>
			<form method="POST" >
			<input type="text" name="name" class="form-control" placeholder="Enter ChatRoom Name:">
			<p class="lead">
				<input type="submit" name="submit" class="btn btn-lg btn-secondary mt-3" value="Start Chat">
			</p>
			</form>
		</main>

		<footer class="mastfoot mt-auto">
			
		</footer>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script>
		function fun_deactivate()
		{
			return confirm("Are you sure, you want to deactivate this account");
		}
	</script>
</body>
</html>

