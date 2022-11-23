<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
include 'api.php';

$token = $access_token;

$inv   = $_GET['inv'];

$payment    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Payment WHERE Inv_Number='$inv'"));
$invoice    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='$inv'"));
$queryz     = mysqli_query($conn,"SELECT * from Invoice_Item WHERE Inv_Number='$inv'");

$postData = array(
    "trx_no"                => $payment['Inv_Number'],
    "trx_date"              => date(DATE_ISO8601, strtotime($payment['Payment_Tgl'])),
    "payment_method_code"   => $payment['Payment_Type'],
    "payment_method_name"   => $payment['Payment_Type'],
    "doc_amount"            => $payment['Payment_Total'],
    "net_amount"            => $payment['Payment_Total'],
    "tax_amount"            => "0",
    "disc_amount"           => $invoice['Total_Diskon'],
    "other_amount"          => "0",
    "mdr_amount"            => "0",
    "rounding_amount"       => $invoice['Payment_Rounding'],
);

$postData["details"] = array();


while($datanya = mysqli_fetch_assoc($queryz)){    
    $newdata =  array (
      'item_code'   => $datanya['Item_ID'],
      'item_name'   => $datanya['Deskripsi'],
      'qty'         => $datanya['Item_Pcs']*$datanya['Qty'],
      'price'       => $datanya['Total_Price'],
      'disc_amount' => 0,
    );
    array_push($postData["details"],$newdata);
}

$fields = json_encode($postData);
$curl = curl_init();

$headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token,
    );


curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
curl_setopt($curl, CURLOPT_URL, 'https://swing-api.appspot.com/api/transactions/others/swing_mycherree_cm/');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLINFO_HEADER_OUT, true);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
$result = curl_exec($curl);

$info = curl_getinfo($curl);

if(!$result){die("Connection Failure");}
curl_close($curl);

$hasil = (json_decode($result, true));
$status = $hasil['message'];

echo $status;
?>