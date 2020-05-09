<?php
session_start();
include 'connection.php';
if((empty($_SESSION['id'])) || empty(($_SESSION['user_name'])) || empty($_SESSION['email']))
     	{
		   header('Location: '.$base_url.'index.php');
    	}
$name = $_GET['name'];
$sql = "SELECT * FROM `people` WHERE name=".$name;
$result = mysqli_query($conn, $sql);
if($result)
{
	if(mysqli_num_rows($result) == 0)
	{
		$error_msg = 'The Chatroom on this name does not exist';
		echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'.$error_msg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		header("Location:".$base_url."chat.php");
	}
}

// Store a string into the variable which need to be Encrypted 
$simple_string = $name; 

// Store the cipher method 
$ciphering = "AES-128-CTR"; 
  
// Use OpenSSl Encryption method 
$iv_length = openssl_cipher_iv_length($ciphering); 
$options = 0; 
  
// Non-NULL Initialization Vector for encryption 
$encryption_iv = '1211101987654321'; 
  
// Store the encryption key 
$encryption_key = "ChatRoom"; 
  
// Use openssl_encrypt() function to encrypt the data 
$encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv); 

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="icon" href="https://img.icons8.com/cute-clipart/64/000000/chat.png">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css">
	<title>ChatRoom</title>
	<style>
		body {
			margin: 0 auto;
			max-width: 800px;
			padding: 0 20px;
		}

		.container {
			border: 2px solid #dedede;
			background-color: #f1f1f1;
			border-radius: 5px;
			padding: 10px;
			margin: 10px 0;
			background-color: #333;
			color: white;
		}
		.container1 {
			border: 2px solid #dedede;
			background-color: #f1f1f1;
			border-radius: 10px;
			padding: 10px;
			margin: 10px 0;
			background-color: #335;
			color: white;
			text-align: right;
		}

		.darker {
			border-color: #ccc;
			background-color: #fff;
		}

		.container::after {
			content: "";
			clear: both;
			display: table;
		}
		.container1::after {
			content: "";
			clear: both;
			display: table;
		}

		.container img {
			float: left;
			max-width: 60px;
			width: 100%;
			margin-right: 20px;
			border-radius: 50%;
		}

		.container img.right {
			float: right;
			margin-left: 20px;
			margin-right:0;
		}

		.time-right {
			float: right;
			color: #aaa;
		}

		.time-left {
			float: left;
			color: #999;
		}

		.scroller{
			height: 400px;
			overflow-y: scroll;
		}
	</style>
	
</head>
<body>
	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<img src="https://img.icons8.com/cute-clipart/64/000000/chat.png"><h3 class="my-0 mr-md-auto font-weight-normal">ChatRoom</h3>
		<nav class="my-2 my-md-0 mr-md-3">
			<a class="p-2 btn btn-outline-primary" href="<?php echo $base_url.'chat.php' ?>">Home</a>
					<li class="nav-item dropdown btn">
						<a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
	<center>
		<h2 class="mb-4 mt-3">Welcome! to your <?php echo $name;?> ChatRoom</h2>
		<p>For Future use of this ChatRoom. Please, Note this code:</p>
		<input type="text" name="get_url" id="get_url" class="form-control" style="text-align:center; background-color: #333;color: white" value="<?php echo $encryption ?>" readonly>
		<button onclick="copy_text()" class="btn btn-dark mt-2">Copy Code</button>
	</center>

	<div class="container">
		<div class="scroller">
			
		</div>
	</div>

	<textarea name="user-msg" id="user-msg" class="form-control" placeholder="Enter Message"></textarea>
	<button name="sub_msg" id="postbtn" class="btn btn-primary mt-3 mb-3">Post</button>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
	
	<script type="text/javascript">

		setInterval(checkmsg, 1000);
		function checkmsg()
		{
			$.post('msgchecker.php', {name: '<?php echo $name ?>'}, function(data, status) {
				document.getElementsByClassName('scroller')[0].innerHTML = data;
			});
		}

		$("#postbtn").click(function() {
			var msg = $('#user-msg').val();
			console.log(msg);
			$.post("msgpost.php", {text: msg, name:'<?php echo $name ?>', ip:'<?php echo $_SERVER['REMOTE_ADDR'] ?>'}, function(data, status) {
				document.getElementsByClassName('scroller')[0].innerHTML = data;
				$(".emojionearea-editor").html('');
				return false;
			});
		});

		$('#user-msg').emojioneArea({
			pickerPosition:"bottom"
		});

	</script>
	<script>
		function copy_text() {
			var copyText = document.getElementById("get_url");
			copyText.select();
			copyText.setSelectionRange(0, 99999)
			document.execCommand("copy");
			alert("Code Copied");
		}
		function fun_deactivate()
		{
			return confirm("Are you sure, you want to deactivate this account");
		}
</script>
</body>
</html>
