<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW CUSTOMER
	$Cust_Nama 		 	= $_POST['Cust_Nama'];
	$Cust_Telp 		    = $_POST['Cust_Telp'];
	$Cust_Tgl_Lahir     = $_POST['Cust_Tgl_Lahir'];
    $Cust_Alamat 		= $_POST['Cust_Alamat'];
	$Cust_Note 		    = $_POST['Cust_Note'];
	$Cust_Tgl_Join 		= date('Y-m-d');

	mysqli_query($conn, "INSERT INTO Customer (Cust_Nama, Cust_Telp, Cust_Tgl_Lahir, Cust_Alamat, Cust_Note, Cust_Tgl_Join, Cust_Status) VALUES ('$Cust_Nama','$Cust_Telp','$Cust_Tgl_Lahir','$Cust_Alamat','$Cust_Note','$Cust_Tgl_Join','Y')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING CUSTOMER
	$Cust_No 		 	= $_POST['Cust_No'];
	$Cust_Nama 		 	= $_POST['Cust_Nama'];
	$Cust_Telp 		    = $_POST['Cust_Telp'];
	$Cust_Tgl_Lahir     = $_POST['Cust_Tgl_Lahir'];
    $Cust_Alamat 		= $_POST['Cust_Alamat'];
	$Cust_Note 		    = $_POST['Cust_Note'];

    mysqli_query($conn, "UPDATE Customer SET Cust_Nama='$Cust_Nama', Cust_Telp='$Cust_Telp', Cust_Tgl_Lahir='$Cust_Tgl_Lahir', Cust_Alamat='$Cust_Alamat', Cust_Note='$Cust_Note' WHERE Cust_No='$Cust_No'");
} elseif ($_GET['menu'] == 'data') {
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
    $sql = "SELECT Customer.*, Registrasi_Member.Status_Payment from Customer 
            LEFT JOIN Registrasi_Member 
            ON Customer.Cust_No = Registrasi_Member.Cust_No 
            WHERE Customer.Cust_Status='Y'";
    $query=mysqli_query($conn, $sql) or die("customers?menu=data: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = "SELECT Customer.*, Registrasi_Member.Status_Payment from Customer 
            LEFT JOIN Registrasi_Member 
            ON Customer.Cust_No = Registrasi_Member.Cust_No 
            WHERE Customer.Cust_Status='Y'";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Customer.Cust_Nama NOT LIKE '[DELETE]%' AND ( Customer.Cust_Nama LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR Customer.Cust_Telp LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Customer.Cust_Alamat LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Customer.Cust_Tgl_Join LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Customer.Cust_Note LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Customer.Cust_Member_Name LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Customer.Cust_No LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("customers?menu=data: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("customers?menu=data: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    while( $row=mysqli_fetch_array($query) ) {
        if ($row["Status_Payment"]=='Y') {
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
        $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#edit-customer-modal' onclick='btnEdit(".$row['Cust_No'].")'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2' onclick='btnDelete(".$row['Cust_No'].")'>DELETE</button>";
        
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
    $id 	= $_POST['id'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Customer WHERE Cust_No='$id'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'Cust_No' 		 	=> $data['Cust_No'],
        'Cust_Nama' 		=> $data['Cust_Nama'],
        'Cust_Telp'		    => $data['Cust_Telp'],
        'Cust_Tgl_Lahir'    => $data['Cust_Tgl_Lahir'],
        'Cust_Alamat' 		=> $data['Cust_Alamat'],
        'Cust_Note'		    => $data['Cust_Note'],
    ];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} else {
	// DELETE CUSTOMER
	$id = $_GET['id'];

	mysqli_query($conn, "UPDATE Customer SET Cust_Status='N' WHERE Cust_No='$id'");
}
// REDIRECT KEMBALI KE HALAMAN USER
echo "<script>location.href='../app?p=customers';</script>";
?>