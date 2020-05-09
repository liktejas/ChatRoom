<?php
        session_start();
        include 'connection.php';
        unset($_SESSION['email']);
        unset($_SESSION['id']);
        unset($_SESSION['user_name']);
        session_destroy();
		echo '<script>';
	    echo "alert(`You're Logged Out!`);";
		echo 'window.location="'.$base_url.'index.php";';
        echo '</script>';     

?>