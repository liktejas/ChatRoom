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

    <title>Confirm Password</title>

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
      p,h1{
        color: #fff;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="<?php echo $base_url?>signin.css" rel="stylesheet">
  </head>
    <?php

    // $email = $_GET['email'];
    if(isset($_POST['confirm']))
    {
        $current_password = base64_encode($_POST['current_password']);
        $new_password = base64_encode($_POST['newpassword']);
        $re_password = base64_encode($_POST['repassword']);
        $email = $_SESSION['email'];
        $q = "SELECT * FROM `users` WHERE `email`='$email'";
        $r = mysqli_query($conn, $q);
        $result = mysqli_fetch_array($r);
        if(mysqli_num_rows($r) > 0)
        {
            // echo "<script>alert('Password found in db')</script>";
            if($result['password'] == $current_password)
            {
                // echo "<script>alert('Password Matched')</script>";
                if($new_password == $re_password)
                {
                    $sql = "UPDATE `users` SET `password`='$new_password' WHERE `email`='$email'";
                    $res = mysqli_query($conn, $sql);
                    if($res)
                    {
                        echo "<script>alert('Password Updated');";
                        unset($_SESSION['email']);
                        unset($_SESSION['id']);
                        unset($_SESSION['user_name']);
                        session_destroy();
                        echo 'window.location="'.$base_url.'index.php"';
                        echo '</script>';

                    }
                    else
                    {
                        echo "<script>alert('Password Not Updated');</script>";
                    }
                }
                else
                {
                    echo "<script>alert('Passwords do not Match, Please Enter Again');</script>";
                }
            }
            else
            {
                echo "<script>alert('Please Enter Correct Current Password')</script>";   
            }
        }
        else
        {
            echo "<script>alert('Account do not Exist')</script>";
        }
    }

    ?>

  <body class="text-center">
    <form class="form-signin" method="POST">
    <img class="mb-4" src="https://img.icons8.com/cute-clipart/64/000000/chat.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Create New Password</h1>
        <label for="current_password" class="sr-only">Current Password</label>
        <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Current Password" required autofocus>
        <label for="NewPassword" class="sr-only">New Password</label>
        <input type="password" id="NewPassword" class="form-control" name="newpassword" placeholder="New Password" required>
        <span id="password_error"></span>
        <label for="Repassword" class="sr-only">Re-enter Password</label>
        <input type="password" id="Repassword" class="form-control" name="repassword" placeholder="Re-Enter Password" required>
        <span id="repassword_error"></span>
        <input type="submit" id="confirm" class="btn btn-lg btn-primary btn-block mt-3" value="Change Password" name="confirm">
        <p class="mt-3">Back to <a href="<?php echo $base_url?>chat.php">Home</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#password_error').hide();
            $('#repassword_error').hide();
            $('#NewPassword').click(function(){ 
                $(this).keyup(function(){ 
                    var newpassword = $(this).val();
                    if(newpassword.length == "")
                    {
                        $('#password_error').show();
                        $('#password_error').html('<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Email cannot be empty</div></div>');
                        $('#confirm').attr('disabled', true);
                    }
                    else if(newpassword.length <= 3)
                    {
                        $('#password_error').show();
                        $('#password_error').html('<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Password is short</div></div>');
                        $('#confirm').attr('disabled', false);
                    }
                    else if(newpassword.length <= 6)
                    {
                        $('#password_error').show();
                        $('#password_error').html('<div class="progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Password is weak</div></div>');
                        $('#confirm').attr('disabled', false);
                    }
                    else if(newpassword.length <= 8)
                    {
                        $('#password_error').show();
                        $('#password_error').html('<div class="progress"><div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Password is predictable</div></div>');
                        $('#confirm').attr('disabled', false);
                    }
                    else
                    {
                        $('#password_error').show();
                        $('#password_error').html('<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Password is Strong</div></div>');
                        $('#confirm').attr('disabled', false);
                    }
                });
            });
            $('#Repassword').click(function(){
                $(this).keyup(function(){
                    var newpassword = $('#NewPassword').val();
                    var repassword = $('#Repassword').val();
                    if(newpassword != repassword)
                    {
                        $('#repassword_error').show();
                        $('#repassword_error').html('<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Passwords do not Match</div></div>');
                        $('#confirm').attr('disabled', true);
                    }
                    else
                    {
                        $('#repassword_error').show();
                        $('#repassword_error').html('<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Passwords Matched</div></div>');
                        $('#confirm').attr('disabled', false);
                    }
                    });
            });
        });
    </script>
</body>
</html>


