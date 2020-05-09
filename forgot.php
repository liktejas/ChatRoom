<?php
    session_start();
    include 'connection.php';
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">

    <title>Forgot Password</title>

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
  <body class="text-center">
    <form class="form-signin" method="POST">
    <img class="mb-4" src="https://img.icons8.com/cute-clipart/64/000000/chat.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Reset Password</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required autofocus>
        <input type="submit" class="btn btn-lg btn-primary btn-block mt-3" value="Send Confirmation Email" name="forgot">
        <p class="mt-3">Already Have account, Please <a href="<?php echo $base_url?>index.php">Login</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php

      if(isset($_POST['forgot']))
      {
        $send_email_to = $_POST['email'];
        $sql = "SELECT * FROM `users` WHERE `email`='$send_email_to'";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) > 0)
        {
          $result = mysqli_fetch_array($res);
          $_SESSION['email'] = $result['email'];
            $developmentMode = true;
                $mailer = new PHPMailer($developmentMode);

                try{
                    //Server settings
                    $mailer->SMTPDebug = 0;//0 = off (for production use, No debug messages) debugging: 1 = errors and messages, 2 = messages only
                    $mailer->isSMTP();

                    if($developmentMode){
                        $mailer->SMTPOptions = [
                            'ssl'=>[
                                'verify_peer'=> false,
                                'verify' => false,
                                'allow_self_signed' => true
                            ]
                        ];
                    }


                    $mailer->Host = 'smtp.gmail.com';
                    $mailer->SMTPAuth = true;
                    $mailer->Username = 'Sender Email Address';
                    $mailer->Password = 'Password of Sender Email Address';
                    $mailer->SMTPSecure = 'tls';
                    $mailer->Port = 587;

                    //Recipients
                    $mailer->setFrom('Sender Email Address','Sender Name(optional)');
                    $mailer->addAddress($send_email_to);

                    // Content
                    $mailer->isHTML(true);
                    $mailer->Subject = 'Reset Password';
                    $mailer->Body = 'Click on this <a href="'.$base_url.'confirm.php?email='.$send_email_to.'">link</a> to reset your password';
                    
                    $mailer->send();
                    $mailer->ClearAllRecipients();
                    echo "<script>alert('CONFIRMATION MAIL HAS BEEN SENT SUCCESSFULLY');</script>";

                } catch(Exception $e){
                    echo "EMAIL SENDING FAILED. INFO: " . $mailer->ErrorInfo;
                }
        }
        else
        {
            echo '<script>alert("Email not found")</script>';
        }
      }

?>
