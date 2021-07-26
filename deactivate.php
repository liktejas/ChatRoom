<?php
    session_start();
    include 'connection.php';
    if((empty($_SESSION['id'])) || empty(($_SESSION['user_name'])) || empty($_SESSION['email']))
     	{
		   header('Location: '.$base_url.'index.php');
    	}
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    // print_r($email);
    $sql = "DELETE FROM `users` WHERE `email`='$email'";
    $res = mysqli_query($conn, $sql);
    if($res)
    {
        unset($_SESSION['email']);
        unset($_SESSION['id']);
        unset($_SESSION['user_name']);
        session_destroy();
        echo '<script>alert("Account Deactivated")</script>';
        echo '<script>window.location="'.$base_url.'index.php"</script>';
    }
    else
    {
        echo '<script>alert("Deactivation Failed")</script>';
        echo '<script>window.location="'.$base_url.'chat.php"</script>';
    }
    
?>