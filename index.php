<?php
  session_start();
  include 'connection.php';

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">

    <title>ChatRoom - Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
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
        <img class="mb-4" src="https://img.icons8.com/cute-clipart/64/000000/chat.png" alt="" width="72" height="72">

        <?php

          if(isset($_POST['signin']))
          {
            $email = $_POST['email'];
            $password = base64_encode($_POST['password']);
            // "SELECT * FROM `people` WHERE name='$name'"
            $sql = "SELECT * FROM `users` WHERE `email`='$email' and `password`='$password'";
            // print_r($sql);
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) <= 0)
            {
              echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">Login Failed!<br>Please Enter Correct Credientials
  								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<span aria-hidden="true">&times;</span>
  								</button>
								</div>';
            }
            else{
              $_SESSION['email'] = $email;
              $sql = "SELECT * FROM `users` WHERE `email`='$email'";
              $result = mysqli_query($conn, $sql);
              if(mysqli_num_rows($result) > 0)
              {
                while($row = mysqli_fetch_array($result))
                {
                  $_SESSION['id'] = $row['id'];
                  $_SESSION['user_name'] = $row['name'];
                  $_SESSION['temp_ip'] = $row['temp_ip'];
                }
              }
              header("location:chat.php");
            }
          }
        ?>

        <h1 class="h3 mb-3 font-weight-normal">Please Sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
        <input type="submit" class="btn btn-lg btn-primary btn-block mt-3" value="Sign in" name="signin">
        <p class="mt-3">Don't Have account, Please <a href="<?php echo $base_url?>register.php">Register</a></p>
        <p><a href="<?php echo $base_url?>forgot.php">Forgot Password</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>



