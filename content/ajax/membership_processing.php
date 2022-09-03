<?php
 
include '../../config/configuration.php';

$requestData= $_REQUEST;
$columns = array( 
    0 =>'Cust_No',
    1 =>'Cust_Nama',
    2 =>'Registrasi_Tgl',
    3 =>'Discount_No',
    4 =>'Registrasi_Payment',
    5 =>'Status_Payment',
    6 =>'Payment_Type',
    7 =>'Cust_Member_Join',
    8 =>'Cust_Member_Exp',
    9 =>'Staff_Name',
);
//----------------------------------------------------------------------------------
//join 2 tabel dan bisa lebih, tergantung kebutuhan
$sql = "SELECT * from Registrasi_Member";
$query=mysqli_query($conn, $sql) or die("membership_processing.php: get dataku");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;

//----------------------------------------------------------------------------------
$sql = " SELECT * from Registrasi_Member";
$sql.= " WHERE 1=1";
if( !empty($requestData['search']['value']) ) {
    //----------------------------------------------------------------------------------
    $sql.=" AND Cust_Nama NOT LIKE '[DELETE]%' AND ( Cust_Nama LIKE '%".$requestData['search']['value']."%' ";    
    $sql.=" OR Registrasi_Tgl LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR Payment_Type LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR Registrasi_Payment LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR Cust_Member_Join LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR Cust_Member_Exp LIKE '".$requestData['search']['value']."%' )";
}
//----------------------------------------------------------------------------------
$query=mysqli_query($conn, $sql) or die("membership_processing.php: get dataku");
$totalFiltered = mysqli_num_rows($query);
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
$query=mysqli_query($conn, $sql) or die("membership_processing.php: get dataku");
//----------------------------------------------------------------------------------
$data = array();
while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 
    $nestedData[] = "".$row['Registrasi_Tgl']."";
    $nestedData[] = "".$row["Cust_Nama"]."";
    $nestedData[] = "PAID - ".$row["Registrasi_Payment"] ." - ".$row["Payment_Type"] ."";
    $nestedData[] = "".$row["Cust_Member_Join"]." - ".$row["Cust_Member_Exp"]."";
    $nestedData[] = "".$row["Staff_Name"]."";
    $nestedData[] = "<button class='btn btn-sm btn-primary w-16 mr-1 mb-2'>PRINT</button>";
    
    $data[] = $nestedData;
}
//----------------------------------------------------------------------------------
$json_data = array(
            "draw"            => intval( $requestData['draw'] ),  
            "recordsTotal"    => intval( $totalData ), 
            "recordsFiltered" => intval( $totalFiltered ), 
            "data"            => $data );
//----------------------------------------------------------------------------------
echo json_encode($json_data);

?>