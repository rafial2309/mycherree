<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW COLOUR
	$Colour_Name 	= $_POST['Colour_Name'];
	
	mysqli_query($conn, "INSERT INTO Master_Colour (Colour_Name, Colour_Status) VALUES ('$Colour_Name','Y')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING COLOUR
	$Colour_ID 		= $_POST['Colour_ID'];
	$Colour_Name    = $_POST['Colour_Name'];
	
    mysqli_query($conn, "UPDATE Master_Colour SET Colour_Name='$Colour_Name' WHERE Colour_ID='$Colour_ID'");
} else if ($_GET['menu'] == 'data') {
    $requestData= $_REQUEST;
    $columns = array( 
        0 =>'Colour_ID',
        1 =>'Colour_Name',
        2 =>'Colour_Status',
    );
    //----------------------------------------------------------------------------------
    //join 2 tabel dan bisa lebih, tergantung kebutuhan
    $sql = "SELECT * from Master_Colour WHERE Colour_Status='Y'";
    $query=mysqli_query($conn, $sql) or die("colours?menu=data: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Master_Colour";
    $sql.= " WHERE Colour_Status='Y'";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Colour_Name NOT LIKE '[DELETE]%' AND ( Colour_Name LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR Colour_ID LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("colours?menu=data: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("colours?menu=data: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    $i = 1;
    while( $row=mysqli_fetch_array($query) ) {

        $nestedData=array(); 
        $nestedData[] = $row["Colour_Name"];
        $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#edit-colour-modal' onclick='btnEdit(".$row['Colour_ID'].")'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2' onclick='btnDelete(".$row['Colour_ID'].")'>DISABLE</button>";
        
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
    exit();
} elseif ($_GET['menu'] == 'ajax') { 
    // KEYWORD DIKIRIM DENGAN METHOD POST
    $Colour_ID 	= $_POST['Colour_ID'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Master_Colour WHERE Colour_ID='$Colour_ID'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'Colour_ID'	        => $Colour_ID, 
        'Colour_Name' 		=> $data['Colour_Name'],
	];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// SOFT DELETE COLOUR
	$Colour_ID = $_GET['id'];

	mysqli_query($conn, "UPDATE Master_Colour SET Colour_Status='N' WHERE Colour_ID='$Colour_ID'");
}
// REDIRECT KEMBALI KE HALAMAN COLOUR
echo "<script>location.href='../app?p=master_colour';</script>";
?>