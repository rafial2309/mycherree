<?php
include 'config/configuration.php';

if (isset($_GET['p'])) {
	$page = $_GET['p'];
}else{
	$page = 'dashboard';
}





?>