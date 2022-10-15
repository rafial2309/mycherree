<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW CUSTOMER
	// $Cust_Nama 		 	= $_POST['Cust_Nama'];
	// $Cust_Telp 		    = $_POST['Cust_Telp'];
	// $Cust_Tgl_Lahir     = $_POST['Cust_Tgl_Lahir'];
 //    $Cust_Alamat 		= $_POST['Cust_Alamat'];
	// $Cust_Note 		    = $_POST['Cust_Note'];
	// $Cust_Tgl_Join 		= date('Y-m-d');

	// mysqli_query($conn, "INSERT INTO Customer (Cust_Nama, Cust_Telp, Cust_Tgl_Lahir, Cust_Alamat, Cust_Note, Cust_Tgl_Join, Cust_Store, Cust_Status) VALUES ('$Cust_Nama','$Cust_Telp','$Cust_Tgl_Lahir','$Cust_Alamat','$Cust_Note','$Cust_Tgl_Join','PIK','Y')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING CUSTOMER
	// $Cust_No 		 	= $_POST['Cust_No'];
	// $Cust_Nama 		 	= $_POST['Cust_Nama'];
	// $Cust_Telp 		    = $_POST['Cust_Telp'];
	// $Cust_Tgl_Lahir     = $_POST['Cust_Tgl_Lahir'];
 //    $Cust_Alamat 		= $_POST['Cust_Alamat'];
	// $Cust_Note 		    = $_POST['Cust_Note'];

 //    mysqli_query($conn, "UPDATE Customer SET Cust_Nama='$Cust_Nama', Cust_Telp='$Cust_Telp', Cust_Tgl_Lahir='$Cust_Tgl_Lahir', Cust_Alamat='$Cust_Alamat', Cust_Note='$Cust_Note' WHERE Cust_No='$Cust_No'");
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
    $sql = "SELECT Payment_ID,Invoice_Payment.Inv_Number,Invoice.Cust_Nama,Invoice_Payment.Payment_Name,Invoice_Payment.Payment_Total, Invoice_Payment.Payment_Tgl, Invoice_Payment.Payment_Type, Invoice_Payment.Payment_Note, Invoice_Payment.Staff_Name from Invoice_Payment join Invoice on Invoice.Inv_Number=Invoice_Payment.Inv_Number ORDER BY Payment_ID DESC LIMIT 20";
    $query=mysqli_query($conn, $sql) or die("payment?menu=data: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = "SELECT Payment_ID,Invoice_Payment.Inv_Number,Invoice.Cust_Nama,Invoice_Payment.Payment_Name,Invoice_Payment.Payment_Total, Invoice_Payment.Payment_Tgl, Invoice_Payment.Payment_Type, Invoice_Payment.Payment_Note, Invoice_Payment.Staff_Name from Invoice_Payment join Invoice on Invoice.Inv_Number=Invoice_Payment.Inv_Number WHERE Invoice_Payment.Inv_Number!=''";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND (Invoice_Payment.Inv_Number LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR Invoice.Cust_Nama LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Invoice_Payment.Payment_Name LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Invoice_Payment.Payment_Total LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Invoice_Payment.Payment_Tgl LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Invoice_Payment.Payment_Type LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Invoice_Payment.Payment_Note LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Invoice_Payment.Staff_Name LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("payment?menu=data: get dataku");
   
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY Payment_ID  ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("payment?menu=data: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();

    while( $row=mysqli_fetch_array($query) ) {
        

        $nestedData=array(); 
        $nestedData[] = $row["Payment_ID"];
        $nestedData[] = "<p style='font-size:15px'>".$row["Inv_Number"]."</p>";
        $nestedData[] = "<p style='font-size:15px'>".$row["Cust_Nama"] ."</p>";
        $nestedData[] = "<p style='font-size:15px'>".$row["Payment_Name"] ."</p>";
        $nestedData[] = "<p style='font-size:15px'>".$row["Payment_Total"] ."</p>";
        $nestedData[] = "<p style='font-size:15px'>".$row["Payment_Tgl"] ."</p>";
        $nestedData[] = "<p style='font-size:15px'>".$row["Payment_Type"] ."</p>";
        $nestedData[] = "<p style='font-size:15px'>".$row["Payment_Note"] ."</p>";
        $nestedData[] = "<p style='font-size:15px'>".$row["Staff_Name"] ."</p>";
        
        $nestedData[] = "";
        
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
    // $id 	= $_POST['id'];

    // $sql 	= mysqli_query($conn, "SELECT * FROM Customer WHERE Cust_No='$id'");
    // $data 	= mysqli_fetch_assoc($sql);

    // $json = [ 
    //     'Cust_No' 		 	=> $data['Cust_No'],
    //     'Cust_Nama' 		=> $data['Cust_Nama'],
    //     'Cust_Telp'		    => $data['Cust_Telp'],
    //     'Cust_Tgl_Lahir'    => $data['Cust_Tgl_Lahir'],
    //     'Cust_Alamat' 		=> $data['Cust_Alamat'],
    //     'Cust_Note'		    => $data['Cust_Note'],
    // ];
    // // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    // echo json_encode($json);
    // exit();
} else {
	// DELETE CUSTOMER
	//$id = $_GET['id'];

	//mysqli_query($conn, "UPDATE Customer SET Cust_Status='N' WHERE Cust_No='$id'");
}
// REDIRECT KEMBALI KE HALAMAN USER

?>