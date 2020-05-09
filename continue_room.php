<?php
	session_start();
	include 'connection.php';
	if((empty($_SESSION['id'])) || empty(($_SESSION['user_name'])) || empty($_SESSION['email']))
     	{
		   // redirect(base_url());
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
	<title>ChatRoom - Continue Room</title>

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
					<a class="nav-link" href="<?php echo $base_url?>chat.php">Home</a>
					<a class="nav-link active" href="#">Continue Room</a>
					<!-- <a class="nav-link" href="#"><?php echo $_SESSION['user_name']?></a> -->
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
					$code = $_POST['code'];
					$ciphering = "AES-128-CTR";
					$decryption_key = "ChatRoom";
					$options = 0;
					$decryption_iv = '1211101987654321'; 
					$code=openssl_decrypt ($code, $ciphering, $decryption_key, $options, $decryption_iv);
					if(empty($code))
					{
						$error_msg = 'Please Enter Code';
						echo '	<div class="alert alert-danger alert-dismissible fade show" role="alert">'.
  								$error_msg.'
  								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<span aria-hidden="true">&times;</span>
  								</button>
								</div>';
					}
					else if(strlen($code)<2)
					{
						$error_msg = 'Invalid code length';
						echo '	<div class="alert alert-warning alert-dismissible fade show" role="alert">'.
  								$error_msg.'
  								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<span aria-hidden="true">&times;</span>
  								</button>
								</div>';
					}
					else if(ctype_digit($code))
					{
						$error_msg = 'ChatRoom Code cannot start with number(s)';
						echo '	<div class="alert alert-warning alert-dismissible fade show" role="alert">'.
  								$error_msg.'
  								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<span aria-hidden="true">&times;</span>
  								</button>
								</div>';
					}
					else
					{
						$sql = "SELECT * FROM `people` WHERE name='$code'";
						$res = mysqli_query($conn, $sql);
						if(mysqli_num_rows($res) > 0)
						{
							header('Location: '.$base_url.'rooms.php?name='.$code);
						}
						else
						{
							$error_msg = 'ChatRoom Code is not valid';
							echo '	<div class="alert alert-warning alert-dismissible fade show" role="alert">'.
  									$error_msg.'
  									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    								<span aria-hidden="true">&times;</span>
  									</button>
									</div>';
						}
					}
				}
	?>
			<h1 class="cover-heading">Welcome to the ChatRoom.</h1>
			<p class="lead">ChatRoom is the place where you can chat with your friends across all the barries of the world. To begin chat just enter room name below.</p>
			<form method="POST" >
			<input type="text" name="code" class="form-control" placeholder="Enter Code:">
			<p class="lead">
				<input type="submit" name="submit" class="btn btn-lg btn-secondary mt-3" value="Continue Chat">
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
