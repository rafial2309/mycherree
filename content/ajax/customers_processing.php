<?php
 
include '../../config/configuration.php';

$requestData= $_REQUEST;
$columns = array( 
    0 =>'Cust_Nama',
    1 =>'Cust_Telp',
    2 =>'Cust_Alamat',
    3 =>'Cust_Tgl_Join',
    4 =>'Cust_Note',
    5 =>'Cust_No',
    6 =>'Cust_Member_Name',
);
//----------------------------------------------------------------------------------
//join 2 tabel dan bisa lebih, tergantung kebutuhan
$sql = "SELECT * from Customer";
$query=mysqli_query($conn, $sql) or die("customers_processing.php: get dataku");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;

//----------------------------------------------------------------------------------
$sql = " SELECT * from Customer";
$sql.= " WHERE 1=1";
if( !empty($requestData['search']['value']) ) {
    //----------------------------------------------------------------------------------
    $sql.=" AND Cust_Nama NOT LIKE '[DELETE]%' AND ( Cust_Nama LIKE '%".$requestData['search']['value']."%' ";    
    $sql.=" OR Cust_Telp LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR Cust_Alamat LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR Cust_Tgl_Join LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR Cust_Note LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR Cust_Member_Name LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR Cust_No LIKE '".$requestData['search']['value']."%' )";
}
//----------------------------------------------------------------------------------
$query=mysqli_query($conn, $sql) or die("customers_processing.php: get dataku");
$totalFiltered = mysqli_num_rows($query);
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
$query=mysqli_query($conn, $sql) or die("customers_processing.php: get dataku");
//----------------------------------------------------------------------------------
$data = array();
while( $row=mysqli_fetch_array($query) ) {
    if ($row["Cust_Member_Name"]!='') {
        $member = "<button class='btn btn-outline-primary inline-block mr-1 mb-2'>".$row["Cust_Member_Name"]."</button>";
    }else{
        $member = "";
    }

    $nestedData=array(); 
    $nestedData[] = "<p style='font-size:15px'>".$row["Cust_Nama"]."</p>";
    $nestedData[] = "<p style='font-size:15px'>".$row["Cust_Telp"] ."</p>";
    $nestedData[] = "".$row["Cust_Alamat"]."<nl><small style='opacity:0'>".$row["Cust_No"]."<small>";
    $nestedData[] = "".$member."";
    $nestedData[] = "".date('d F Y', strtotime($row['Cust_Tgl_Join']))."";
    $nestedData[] = "".$row["Cust_Note"]."";
    $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2'>DELETE</button>";
    
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