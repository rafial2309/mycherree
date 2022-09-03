<?php
 
include '../../config/configuration.php';

$requestData= $_REQUEST;
$columns = array( 
    0 =>'Staff_ID',
    1 =>'Staff_Name',
    2 =>'Staff_Tempat_Lahir',
    3 =>'Staff_Alamat',
    4 =>'Staff_Telp',
    5 =>'Staff_Access',
);
//----------------------------------------------------------------------------------
//join 2 tabel dan bisa lebih, tergantung kebutuhan
$sql = "SELECT * from Staff";
$query=mysqli_query($conn, $sql) or die("master_staff_processing.php: get dataku");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;

//----------------------------------------------------------------------------------
$sql = " SELECT * from Staff";
$sql.= " WHERE 1=1";
if( !empty($requestData['search']['value']) ) {
    //----------------------------------------------------------------------------------
    $sql.=" AND Staff_Name NOT LIKE '[DELETE]%' AND ( Staff_Name LIKE '%".$requestData['search']['value']."%' ";    
    $sql.=" OR Staff_ID LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR Staff_Tempat_Lahir LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR Staff_Alamat LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR Staff_Telp LIKE '".$requestData['search']['value']."%' )";
}
//----------------------------------------------------------------------------------
$query=mysqli_query($conn, $sql) or die("master_staff_processing.php: get dataku");
$totalFiltered = mysqli_num_rows($query);
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
$query=mysqli_query($conn, $sql) or die("master_staff_processing.php: get dataku");
//----------------------------------------------------------------------------------
$data = array();
$i = 1;
while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 
    $nestedData[] = "".$row["Staff_No"]."";
    $nestedData[] = "".$row["Staff_ID"]."";
    $nestedData[] = "".$row["Staff_Name"]."";
    $nestedData[] = "".$row["Staff_Tempat_Lahir"].", ".$row["Staff_Tgl_Lahir"]."";
    $nestedData[] = "".$row["Staff_Telp"]."";
    $nestedData[] = "".$row["Staff_Alamat"]."";
    $nestedData[] = "".$row["Staff_Access"]."";
    $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2'>DISABLE</button>";
    
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