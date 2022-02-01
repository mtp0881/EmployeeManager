<?php
	session_start();

	session_regenerate_id(TRUE);

	if(isset($_SESSION['LoginOK']) === false){
		header('location:./login.php');
	}
	
	if($_SESSION['LoginOK'] !== "OK"){
		header('location:./login.php');
	}
