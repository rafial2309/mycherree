<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW CUSTOMER
	$name 		 	= $_POST['name'];
	$position 		= $_POST['position'];
	$store_id       = $_POST['store_id'];
	
	mysqli_query($conn, "INSERT INTO user (name, position, store_id) VALUES ('$name','$position','$store_id')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING CUSTOMER
	$id 		 	= $_POST['id'];
	$name 		 	= $_POST['name'];
	$position 		= $_POST['position'];
	$store_id       = $_POST['store_id'];
	

    mysqli_query($conn, "UPDATE user SET name='$name', position='$position', store_id='$store_id' WHERE id='$id'");
} elseif ($_GET['menu'] == 'ajax') { 
    // KEYWORD DIKIRIM DENGAN METHOD POST
    $id 	= $_POST['id'];

    $sql 	= mysqli_query($conn, "SELECT * FROM user WHERE id='$id'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'id'	        => $id, 
        'name' 	        => $data['name'], 
        'store_id' 	    => $data['store_id'], 
        'position'      => $data['position'], 
    ];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// DELETE CUSTOMER
	$id = $_GET['id'];

	mysqli_query($conn, "DELETE FROM user WHERE id='$id'");
}
// REDIRECT KEMBALI KE HALAMAN USER
echo "<script>location.href='../app?p=staff';</script>";
?>