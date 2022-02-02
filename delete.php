<?php
	include 'logincheck.php';

	header('location:./clearCheck.php?employee_no'.$_GET['compareCode']);

?>
