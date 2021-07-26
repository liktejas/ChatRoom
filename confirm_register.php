<?php
  session_start();
  include 'connection.php';
  if(empty($_SESSION['email']))
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

    <title>ChatRoom - Register</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- Favicons -->
	<link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
	<link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
	<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
  <link rel="icon" href="https://img.icons8.com/cute-clipart/64/000000/chat.png">
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
      body{
      	background-color: #333;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      p,h1{
        color: #fff;
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="<?php echo $base_url?>signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form class="form-signin" method="POST">
    <?php
    
    $email = mysqli_real_escape_string($conn, $_GET['email']);
      if(isset($_POST['register']))
      {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $password = base64_encode($_POST['password']);
        $repassword = base64_encode($_POST['repassword']);

        if($password == $repassword)
        {
            $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name','$email','$password')";
            if(mysqli_query($conn, $sql))
		    {
				echo '<script>';
                echo 'alert("Account Created");';
                unset($_SESSION['email']);
                session_destroy();
				echo 'window.location="'.$base_url.'index.php";';
				echo '</script>';
            }
        }
      }
    
    ?>

        <img class="mb-4" src="https://img.icons8.com/cute-clipart/64/000000/chat.png" alt="" width="72" height="72"> 
        <h1 class="h3 mb-3 font-weight-normal">Please Register</h1>

        <label for="name" class="sr-only">Name</label>
        <input type="text" id="name" class="form-control" name="name" placeholder="Name" required autofocus>

        <label for="email" class="sr-only">Email address</label>
        <input type="email" id="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo $email ?>" readonly>
        <span id="availability"></span>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>

        <label for="repassword" class="sr-only">Re-Password</label>
        <input type="password" id="repassword" class="form-control mb-2" name="repassword" placeholder="ReEnter Password" required>

        <span id="progress_bar"></span>
        <span id="reprogress_bar"></span>

        <input type="submit" id="register" class="btn btn-lg btn-primary btn-block mt-3" value="Register" name="register">
        <p class="mt-3">Already Have account, Please <a href="<?php echo $base_url?>index.php">Login</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function(){
        $('#progress_bar').hide();
        $('#reprogress_bar').hide();
          $('#password').click(function(){
                $('#password').keyup(function(){
                    var pass = $('#password').val();
                    if(pass.length == '')
                    {
                        $('#progress_bar').show();
                        $('#progress_bar').html('<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Password cannot be empty</div></div>');
                    }
                    else if(pass.length <= 3)
                    {
                        $('#progress_bar').show();
                        $('#progress_bar').html('<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Password is short</div></div>');
                    }
                    else if(pass.length <= 6)
                    {
                        $('#progress_bar').show();
                        $('#progress_bar').html('<div class="progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Password is weak</div></div>');
                    }
                    else if(pass.length <= 8)
                    {
                        $('#progress_bar').show();
                        $('#progress_bar').html('<div class="progress"><div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Password is predictable</div></div>');
                    }
                    else
                    {
                        $('#progress_bar').show();
                        $('#progress_bar').html('<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Password is Strong</div></div>');
                    }
                });

            });
          $('#repassword').click(function(){
            $(this).keyup(function(){
              var pass = $('#password').val();
              var repass = $('#repassword').val();
               if(pass != repass)
               {
                 $('#reprogress_bar').show();
                 $('#reprogress_bar').html('<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Passwords do not Match</div></div>');
                 $('#register').attr('disabled', true);
               }
               else{
                $('#reprogress_bar').show();
                $('#reprogress_bar').html('<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Passwords Matched</div></div>');
                $('#register').attr('disabled', false);
               }
            });
          });
      });
    </script>
</body>
</html>
