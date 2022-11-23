<?php 
//error_reporting(0);
function anti_injection($data){
  $filter=stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}

date_default_timezone_set('Asia/Jakarta');
include"../config/configuration.php";


$id=anti_injection($_POST['id']);
$pin=md5(anti_injection($_POST['pin']));
$cabang=$_POST['cabang'];


if (($_POST['id']=='') or ($_POST['pin']=='')) {
	echo"<script>window.location=('../login?error=error&msg=Mohon isi form ID dan PIN')</script>";
	exit();
}else {

// BYPASS
//------------------------------------------------------------
// if ($_POST['id']=='piizaa' && $_POST['pin']=='kosong31') {
// 		session_start();
	
// 		$_SESSION['no_user']='0';
// 		$_SESSION['nama_user']='Adminsitrator';
// 		$_SESSION['bagian']='Admin';
// 	echo "<script>window.location=('../index')</script>";
// 	exit();
// }
//------------------------------------------------------------

$login=mysqli_query($conn, "SELECT * FROM Staff WHERE Staff_ID='$id' AND Staff_PIN='$pin'");
$ketemu=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);

	if (mysqli_num_rows($login)) {

		session_start();
		if ($r['Staff_Status']=='N') {
			echo "<script>window.location=('../login?error=error&msg=Akun sudah dinonaktifkan')</script>";
			exit();
		}

		// server should keep session data for AT LEAST 1 hour
		ini_set('session.gc_maxlifetime', 18000);

		// each client should remember their session id for EXACTLY 1 hour
		session_set_cookie_params(18000); 
		$_SESSION['Staff_ID']=$r['Staff_ID'];
		$_SESSION['Staff_Name']=$r['Staff_Name'];
		$_SESSION['Staff_Access']=$r['Staff_Access'];
		$_SESSION['cabang']=$cabang;

		date_default_timezone_set('Asia/Jakarta'); 
		$waktu = date('d F Y H:i:s');
		$catatan = $waktu . " : LOGIN SISTEM OLEH - " . $_SESSION['Staff_Name'];
		mysqli_query($conn,"INSERT into log values('','$catatan')");
		
		echo "<script>window.location=('../index')</script>";
	} else {
	
		echo "<script>window.location=('../login?error=error&msg=ID atau PIN yang anda masukkan tidak sesuai!')</script>";
	}
}
?>
