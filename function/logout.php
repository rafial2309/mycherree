<?php
	include"../config/configuration.php";

	error_reporting(0);
	session_start();

		date_default_timezone_set('Asia/Jakarta'); 
		$waktu = date('d F Y H:i:s');
		$catatan = $waktu . " : LOGOUT SISTEM OLEH - " . $_SESSION['Staff_Name'];
		mysqli_query($conn,"INSERT into log values('','$catatan')");

		$sh = md5($_COOKIE['sessid']);
		mysqli_query($conn,"DELETE from Sessions WHERE session_hash='$sh'");

		unset($_COOKIE['sessid']);
		unset($_COOKIE['sesshash']);
    	setcookie('sessid', '', time() - 3600, '/'); // empty value and old timestamp
    	setcookie('sesshash', '', time() - 3600, '/'); // empty value and old timestamp

	session_destroy();
	echo "<script type='text/javascript'>window.location='../login'</script>";
	
?>
