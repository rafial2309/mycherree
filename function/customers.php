<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW CUSTOMER
	$name 		 	= $_POST['name'];
	$address 		= $_POST['address'];
	$membership     = $_POST['membership'];
	$join_date 		= date('Y-m-d');

	mysqli_query($conn, "INSERT INTO customer (name, address, membership, join_date) 
						 VALUES ('$name','$address','$membership','$join_date')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING CUSTOMER
	$id 		 	= $_POST['id'];
	$name 		 	= $_POST['name'];
	$address 		= $_POST['address'];
	$membership     = $_POST['membership'];

    mysqli_query($conn, "UPDATE customer SET name='$name', address='$address', membership='$membership' WHERE id='$id'");
} elseif ($_GET['menu'] == 'ajax') { 
    // KEYWORD DIKIRIM DENGAN METHOD POST
    $id 	= $_POST['id'];

    $sql 	= mysqli_query($conn, "SELECT * FROM customer WHERE id='$id'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'id'	        => $id, 
        'name' 	        => $data['name'], 
        'address' 	    => $data['address'], 
        'membership'    => $data['membership'], 
    ];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// DELETE CUSTOMER
	$id = $_GET['id'];

	mysqli_query($conn, "DELETE FROM customer WHERE id='$id'");
}
// REDIRECT KEMBALI KE HALAMAN USER
echo "<script>location.href='../app?p=customers';</script>";
?>