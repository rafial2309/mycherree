<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW ITEM
	$Item_Name 		 	= $_POST['Item_Name'];
	$Item_Category 		= $_POST['Item_Category'];
	$Item_Price         = $_POST['Item_Price'];
	$Item_Pcs           = $_POST['Item_Pcs'];
	
	mysqli_query($conn, "INSERT INTO Master_Item (Item_Name, Item_Category, Item_Price, Item_Pcs, Item_Pic, Item_Status) VALUES ('$Item_Name','$Item_Category','$Item_Price','$Item_Pcs','','Y')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING ITEM
	$Item_ID 		 	= $_POST['Item_ID'];
	$Item_Name 		 	= $_POST['Item_Name'];
	$Item_Category 		= $_POST['Item_Category'];
	$Item_Price         = $_POST['Item_Price'];
	$Item_Pcs           = $_POST['Item_Pcs'];
	
    mysqli_query($conn, "UPDATE Master_Item SET Item_Name='$Item_Name', Item_Category='$Item_Category', Item_Price='$Item_Price', Item_Pcs='$Item_Pcs' WHERE Item_ID='$Item_ID'");
} else if ($_GET['menu'] == 'data') {
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
    $sql = "SELECT * from Master_Item WHERE Item_Status='Y'";
    $query=mysqli_query($conn, $sql) or die("items?menu=data: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Master_Item";
    $sql.= " WHERE Item_Status='Y'";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Item_Name NOT LIKE '[DELETE]%' AND ( Item_Name LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR Item_Category LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Item_Price LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("items?menu=data: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("items?menu=data: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    $i = 1;
    while( $row=mysqli_fetch_array($query) ) {

        $nestedData=array(); 
        $nestedData[] = $row["Item_ID"];
        $nestedData[] = $row["Item_Name"];
        $nestedData[] = $row["Item_Category"];
        $nestedData[] = number_format($row["Item_Price"],0,',','.');
        $nestedData[] = $row["Item_Pcs"];
        $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#edit-item-modal' onclick='btnEdit(".$row['Item_ID'].")'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2' onclick='btnDelete(".$row['Item_ID'].")'>DISABLE</button>";
        
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
    $Item_ID 	= $_POST['Item_ID'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Master_Item WHERE Item_ID='$Item_ID'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'Item_ID'	        => $Item_ID, 
        'Item_Name' 		=> $data['Item_Name'],
	    'Item_Category'     => $data['Item_Category'],
	    'Item_Price'        => $data['Item_Price'],
	    'Item_Pcs'          => $data['Item_Pcs'],
	];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// SOFT DELETE ITEM
	$Item_ID = $_GET['id'];

	mysqli_query($conn, "UPDATE Master_Item SET Item_Status='N' WHERE Item_ID='$Item_ID'");
}
// REDIRECT KEMBALI KE HALAMAN ITEM
echo "<script>location.href='../app?p=master_item';</script>";
?>