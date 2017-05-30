<?php

	$servername="localhost";
	$username="u754745649_infra";
	$password="root123";
	$dbname="u754745649_easy";

$con=mysqli_connect($servername,$username,$password,$dbname);

if(!$con)
		{
			die("connection failed :".mysqli_connect_error());
		}
?>