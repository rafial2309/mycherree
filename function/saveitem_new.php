<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";



$Staff_ID 			= $_SESSION['Staff_ID'];
$Staff_Name 		= $_SESSION['Staff_Name'];

$cekitemno = mysqli_num_rows(mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='' AND Staff_ID='$Staff_ID'"));

$colour 			= explode('+',$_POST['colour']);
$brand 				= explode('+',$_POST['brand']);

$Item_No 			= $cekitemno+1;
$Deskripsi 			= $_POST['Item_Name'] . " " . $colour[1] . " " . $brand[1] . " (" . $_POST['size'] . ")";

$Item_ID 			= $_POST['Item_ID'];
$Colour_ID 			= $colour[0];
$Brand_ID 			= $brand[0];
$Size 				= $_POST['size'];
$Item_Note 			= $_POST['note'];
$Adjustment 		= str_replace(".","",$_POST['adjustment']);
$Adjustment_Note 	= $_POST['note_adjustment'];
$Item_Price 		= $_POST['Item_Price'];
$Qty 				= $_POST['item_qty'];
$Total_Price 		= $_POST['Total_Price'];

mysqli_query($conn,"INSERT into Invoice_Item VALUES(0,'','$Item_No','$Deskripsi','$Item_ID','$Colour_ID','$Brand_ID','$Size','$Item_Note','$Item_Price','$Adjustment','$Adjustment_Note','$Qty','$Total_Price','','','$Staff_ID','$Staff_Name','')");