<?php 
session_start();
if (!isset($_SESSION['Staff_ID'])) {
	echo "<script>window.location=('login')</script>";
	exit();
}
 ?>
<script type="text/javascript">window.location='app';</script>