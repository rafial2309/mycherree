<?php
 
include '../../config/configuration.php';

$requestData= $_REQUEST;
$columns = array( 
    0 =>'Item_ID',
    1 =>'Item_Name',
    2 =>'Item_Category',
    3 =>'Item_Price',
    4 =>'Item_Pcs',
    5 =>'Item_Status',
);
//----------------------------------------------------------------------------------
//join 2 tabel dan bisa lebih, tergantung kebutuhan
$sql = "SELECT * from Master_Item";
$query=mysqli_query($conn, $sql) or die("master_colour_processing.php: get dataku");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;

//----------------------------------------------------------------------------------
$sql = " SELECT * from Master_Item";
$sql.= " WHERE 1=1";
if( !empty($requestData['search']['value']) ) {
    //----------------------------------------------------------------------------------
    $sql.=" AND Item_Name NOT LIKE '[DELETE]%' AND ( Item_Name LIKE '%".$requestData['search']['value']."%' ";    
    $sql.=" OR Item_Category LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR Item_Price LIKE '".$requestData['search']['value']."%' )";
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
    $nestedData[] = "".$row["Item_ID"]."";
    $nestedData[] = "".$row["Item_Name"]."";
    $nestedData[] = "".$row["Item_Category"]."";
    $nestedData[] = "".$row["Item_Price"]."";
    $nestedData[] = "".$row["Item_Pcs"]."";
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