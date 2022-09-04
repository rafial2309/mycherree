<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW DISCOUNT
	$Discount_Nama 	= $_POST['Discount_Nama'];
	$Discount_Type 	= $_POST['Discount_Type'];
	$Persentase 	= $_POST['Persentase'];
	
	mysqli_query($conn, "INSERT INTO Discount (Discount_Nama, Discount_Type, Persentase, Discount_Status) VALUES ('$Discount_Nama','$Discount_Type','$Persentase','Y')");
    
} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING DISCOUNT
	$Discount_No 	= $_POST['Discount_No'];
	$Discount_Nama 	= $_POST['Discount_Nama'];
	$Discount_Type 	= $_POST['Discount_Type'];
	$Persentase 	= $_POST['Persentase'];
	
    mysqli_query($conn, "UPDATE Discount SET Discount_No='$Discount_No', Discount_Nama='$Discount_Nama', Discount_Type='$Discount_Type', Persentase='$Persentase' WHERE Discount_No='$Discount_No'");
} elseif ($_GET['menu'] == 'data') {
    $requestData= $_REQUEST;
    $columns = array( 
        0 =>'Discount_No',
        1 =>'Discount_Nama',
        2 =>'Discount_Type',
        3 =>'Persentase',
    );
    //----------------------------------------------------------------------------------
    //join 2 tabel dan bisa lebih, tergantung kebutuhan
    $sql = "SELECT * from Discount WHERE Discount_Status='Y'";
    $query=mysqli_query($conn, $sql) or die("discounts?menu=data: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Discount";
    $sql.= " WHERE Discount_Status='Y'";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Discount_Nama NOT LIKE '[DELETE]%' AND ( Discount_Nama LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR Discount_Type LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Persentase LIKE '".$requestData['search']['value']."%')";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("discounts?menu=data: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("discounts?menu=data: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    $i = 1;
    while( $row=mysqli_fetch_array($query) ) {

        $nestedData=array(); 
        $nestedData[] = $row["Discount_No"];
        $nestedData[] = $row["Discount_Nama"];
        $nestedData[] = $row["Discount_Type"];
        $nestedData[] = $row["Persentase"].'%';
        $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#edit-discount-modal' onclick='btnEdit(".$row['Discount_No'].")'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2' onclick='btnDelete(".$row['Discount_No'].")'>DISABLE</button>";
        
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
    $Discount_No 	= $_POST['Discount_No'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Discount WHERE Discount_No='$Discount_No'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'Discount_No'   => $data['Discount_No'],
        'Discount_Nama' => $data['Discount_Nama'],
        'Discount_Type' => $data['Discount_Type'],
        'Persentase' 	=> $data['Persentase'],
    ];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// DELETE DISCOUNT
	$Discount_No = $_GET['id'];

	mysqli_query($conn, "UPDATE Discount SET Discount_Status='N' WHERE Discount_No='$Discount_No'");
}
// REDIRECT KEMBALI KE HALAMAN DISCOUNT
echo "<script>location.href='../app?p=discount';</script>";
?>