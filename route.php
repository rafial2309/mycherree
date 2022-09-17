<?php
include 'config/configuration.php';
session_start();
if (!isset($_SESSION['Staff_ID'])) {
	echo "<script>window.location=('login?error=error&msg=Session anda habis, silahkan login kembali')</script>";
	exit();
}

if (isset($_GET['p'])) {
	$page = $_GET['p'];
}else{
	$page = 'dashboard';
}





?>