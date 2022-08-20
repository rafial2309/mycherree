<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW CUSTOMER
	$name 		 	= $_POST['name'];
	$discount 		= $_POST['discount'];
	
	mysqli_query($conn, "INSERT INTO membership (name, discount) VALUES ('$name','$discount')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING CUSTOMER
	$id 		 	= $_POST['id'];
	$name 		 	= $_POST['name'];
	$discount 		= $_POST['discount'];
	
    mysqli_query($conn, "UPDATE membership SET name='$name', discount='$discount' WHERE id='$id'");
} elseif ($_GET['menu'] == 'ajax') { 
    // KEYWORD DIKIRIM DENGAN METHOD POST
    $id 	= $_POST['id'];

    $sql 	= mysqli_query($conn, "SELECT * FROM membership WHERE id='$id'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'id'	        => $id, 
        'name' 	        => $data['name'], 
        'discount' 	    => $data['discount'], 
    ];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// DELETE CUSTOMER
	$id = $_GET['id'];

	mysqli_query($conn, "DELETE FROM membership WHERE id='$id'");
}
// REDIRECT KEMBALI KE HALAMAN USER
echo "<script>location.href='../app?p=membership';</script>";
?>