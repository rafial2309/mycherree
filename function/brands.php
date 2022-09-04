<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW BRAND
	$Brand_Name 	= $_POST['Brand_Name'];
	
	mysqli_query($conn, "INSERT INTO Master_Brand (Brand_Name, Brand_Status) VALUES ('$Brand_Name','Y')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING BRAND
	$Brand_ID 		= $_POST['Brand_ID'];
	$Brand_Name    = $_POST['Brand_Name'];
	
    mysqli_query($conn, "UPDATE Master_Brand SET Brand_Name='$Brand_Name' WHERE Brand_ID='$Brand_ID'");
} else if ($_GET['menu'] == 'data') {
    $requestData= $_REQUEST;
    $columns = array( 
        0 =>'Brand_ID',
        1 =>'Brand_Name',
        2 =>'Brand_Status',
    );
    //----------------------------------------------------------------------------------
    //join 2 tabel dan bisa lebih, tergantung kebutuhan
    $sql = "SELECT * from Master_Brand WHERE Brand_Status='Y'";
    $query=mysqli_query($conn, $sql) or die("brands?menu=data: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Master_Brand";
    $sql.= " WHERE Brand_Status='Y'";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Brand_Name NOT LIKE '[DELETE]%' AND ( Brand_Name LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR Brand_ID LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("brands?menu=data: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("brands?menu=data: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    $i = 1;
    while( $row=mysqli_fetch_array($query) ) {

        $nestedData=array(); 
        $nestedData[] = $row["Brand_Name"];
        $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#edit-brand-modal' onclick='btnEdit(".$row['Brand_ID'].")'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2' onclick='btnDelete(".$row['Brand_ID'].")'>DELETE</button>";
        
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
    $Brand_ID 	= $_POST['Brand_ID'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Master_Brand WHERE Brand_ID='$Brand_ID'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'Brand_ID'	        => $Brand_ID, 
        'Brand_Name' 		=> $data['Brand_Name'],
	];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// SOFT DELETE BRAND
	$Brand_ID = $_GET['id'];

	mysqli_query($conn, "UPDATE Master_Brand SET Brand_Status='N' WHERE Brand_ID='$Brand_ID'");
}
// REDIRECT KEMBALI KE HALAMAN BRAND
echo "<script>location.href='../app?p=master_brand';</script>";
?>