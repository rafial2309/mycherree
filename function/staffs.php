<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW STAFF
	$Staff_ID 		 	    = $_POST['Staff_ID'];
	$Staff_Name 		 	= $_POST['Staff_Name'];
	$Staff_PIN 		 	    = $_POST['Staff_PIN'];
	$Staff_Tempat_Lahir 	= $_POST['Staff_Tempat_Lahir'];
	$Staff_Tgl_Lahir 	    = $_POST['Staff_Tgl_Lahir'];
	$Staff_Alamat 		 	= $_POST['Staff_Alamat'];
	$Staff_Telp 		 	= $_POST['Staff_Telp'];
	$Staff_Access 		 	= $_POST['Staff_Access'];
	
	mysqli_query($conn, "INSERT INTO Staff (Staff_Name, Staff_ID, Staff_PIN, Staff_Tempat_Lahir, Staff_Tgl_Lahir, Staff_Alamat, Staff_Telp, Staff_Access, Staff_Status) VALUES ('$Staff_Name','$Staff_ID','$Staff_PIN','$Staff_Tempat_Lahir','$Staff_Tgl_Lahir','$Staff_Alamat','$Staff_Telp','$Staff_Access','Y')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING STAFF
	$Staff_No 		 	    = $_POST['Staff_No'];
	$Staff_Name 		 	= $_POST['Staff_Name'];
	$Staff_ID 		 	    = $_POST['Staff_ID'];
	$Staff_PIN 		 	    = $_POST['Staff_PIN'];
	$Staff_Tempat_Lahir 	= $_POST['Staff_Tempat_Lahir'];
	$Staff_Tgl_Lahir 	    = $_POST['Staff_Tgl_Lahir'];
	$Staff_Alamat 		 	= $_POST['Staff_Alamat'];
	$Staff_Telp 		 	= $_POST['Staff_Telp'];
	$Staff_Access 		 	= $_POST['Staff_Access'];
	

    mysqli_query($conn, "UPDATE Staff SET Staff_Name='$Staff_Name', Staff_PIN='$Staff_PIN', Staff_Tempat_Lahir='$Staff_Tempat_Lahir', Staff_Tgl_Lahir='$Staff_Tgl_Lahir', Staff_Alamat='$Staff_Alamat', Staff_Telp='$Staff_Telp', Staff_Access='$Staff_Access'WHERE Staff_No='$Staff_No'");
} elseif ($_GET['menu'] == 'data') {
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
    $sql = "SELECT * from Staff WHERE Staff_Status='Y'";
    $query=mysqli_query($conn, $sql) or die("master_staff_processing.php: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Staff";
    $sql.= " WHERE Staff_Status='Y'";
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
        $nestedData[] = $row["Staff_ID"];
        $nestedData[] = $row["Staff_Name"];
        $nestedData[] = $row["Staff_Tempat_Lahir"].", ".$row["Staff_Tgl_Lahir"];
        $nestedData[] = $row["Staff_Telp"];
        $nestedData[] = $row["Staff_Alamat"];
        $nestedData[] = $row["Staff_Access"];
        $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#edit-staff-modal' onclick='btnEdit(".$row['Staff_No'].")'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2' onclick='btnDelete(".$row['Staff_No'].")'>DISABLE</button>";
        
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
    $Staff_No 	= $_POST['Staff_No'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Staff WHERE Staff_No='$Staff_No'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'Staff_No' 		 	    => $data['Staff_No'],
        'Staff_ID'		 	    => $data['Staff_ID'],
        'Staff_Name'            => $data['Staff_Name'],
        'Staff_PIN'             => $data['Staff_PIN'],
        'Staff_Tempat_Lahir' 	=> $data['Staff_Tempat_Lahir'],
        'Staff_Tgl_Lahir' 	    => $data['Staff_Tgl_Lahir'],
        'Staff_Alamat' 		 	=> $data['Staff_Alamat'],
        'Staff_Telp' 		 	=> $data['Staff_Telp'],
        'Staff_Access' 		 	=> $data['Staff_Access']
    ];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// DELETE STAFF
	$Staff_No = $_GET['id'];

	mysqli_query($conn, "UPDATE Staff SET Staff_Status='N' WHERE Staff_No='$Staff_No'");
}
// REDIRECT KEMBALI KE HALAMAN STAFF
echo "<script>location.href='../app?p=staff';</script>";
?>