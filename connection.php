<?php

$conn = mysqli_connect('localhost:3307','root','','chat2');
if(!$conn)
{
	echo "Connection failed to establish"; 
}
$base_url = 'http://localhost/chat2/';
?>