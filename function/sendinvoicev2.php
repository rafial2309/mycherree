<?php
include "../config/configuration.php";
include 'api.php';

$token = $access_token;

$payment    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Payment WHERE Inv_Number='MCL1-2200072'"));
$invoice    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='MCL1-2200072'"));
$queryz     = mysqli_query($conn,"SELECT * from Invoice_Item WHERE Inv_Number='MCL1-2200072'");

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

$opts = array(
    'http' => array(
        'method'  => 'POST',
        'header' => "Content-Type: application/json\r\n".
                    "User-Agent:MyAgent/1.0\r\n".
                    "Authorization: Bearer ". $token . "\r\n",
        'content' => http_build_query($postData),
        'ignore_errors' => true,
    ),
    'ssl' => array(
        'verify_peer' => false,
    ),
);

$context    = stream_context_create($opts);
$result     = file_get_contents('https://swing-api.appspot.com/api/transactions/others/swing_mycherree_cm/', false, $context);

$profile    = json_decode($result, TRUE);
var_dump($profile);