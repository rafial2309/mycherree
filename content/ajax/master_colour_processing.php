<?php
 
include '../../config/configuration.php';

$requestData= $_REQUEST;
$columns = array( 
    0 =>'Colour_ID',
    1 =>'Colour_Name',
    2 =>'Colour_Status',
);
//----------------------------------------------------------------------------------
//join 2 tabel dan bisa lebih, tergantung kebutuhan
$sql = "SELECT * from Master_Colour";
$query=mysqli_query($conn, $sql) or die("master_colour_processing.php: get dataku");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;

//----------------------------------------------------------------------------------
$sql = " SELECT * from Master_Colour";
$sql.= " WHERE 1=1";
if( !empty($requestData['search']['value']) ) {
    //----------------------------------------------------------------------------------
    $sql.=" AND Colour_Name NOT LIKE '[DELETE]%' AND ( Colour_Name LIKE '%".$requestData['search']['value']."%' ";    
    $sql.=" OR Colour_ID LIKE '".$requestData['search']['value']."%' )";
}
//----------------------------------------------------------------------------------
$query=mysqli_query($conn, $sql) or die("master_colour_processing.php: get dataku");
$totalFiltered = mysqli_num_rows($query);
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
$query=mysqli_query($conn, $sql) or die("master_colour_processing.php: get dataku");
//----------------------------------------------------------------------------------
$data = array();
$i = 1;
while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 
    $nestedData[] = "".$row["Colour_ID"]."";
    $nestedData[] = "".$row["Colour_Name"]."";
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