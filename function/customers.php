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

	mysqli_query($conn, "INSERT INTO Customer (Cust_Nama, Cust_Telp, Cust_Tgl_Lahir, Cust_Alamat, Cust_Note, Cust_Tgl_Join, Cust_Store, Cust_Status) VALUES ('$Cust_Nama','$Cust_Telp','$Cust_Tgl_Lahir','$Cust_Alamat','$Cust_Note','$Cust_Tgl_Join','PIK','Y')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING CUSTOMER
	$Cust_No 		 	= $_POST['Cust_No'];
	$Cust_Nama 		 	= $_POST['Cust_Nama'];
	$Cust_Telp 		    = $_POST['Cust_Telp'];
	$Cust_Tgl_Lahir     = $_POST['Cust_Tgl_Lahir'];
    $Cust_Alamat 		= $_POST['Cust_Alamat'];
	$Cust_Note 		    = $_POST['Cust_Note'];

    mysqli_query($conn, "UPDATE Customer SET Cust_Nama='$Cust_Nama', Cust_Telp='$Cust_Telp', Cust_Tgl_Lahir='$Cust_Tgl_Lahir', Cust_Alamat='$Cust_Alamat', Cust_Note='$Cust_Note' WHERE Cust_No='$Cust_No'");

} elseif ($_GET['menu'] == 'createdeposit') {
    // INPUT DEPOSIT
    $Cust_No            = $_POST['Cust_No'];
    $Total_Deposit      = str_replace('.', '', $_POST['Total_Deposit']);
    $Note               = $_POST['Note'];
    $Tgl                = date('Y-m-d');

    mysqli_query($conn, "INSERT INTO Customer_Deposit VALUES (0,'$Cust_No','$Total_Deposit','CREDIT (+)','$Note','$Tgl')");
    echo "<script>location.href='../app?p=customer_detail&Cust_No=".$Cust_No."';</script>";
    exit();

} elseif ($_GET['menu'] == 'usedeposit') {
    // INPUT DEPOSIT
    $Cust_No            = $_POST['Cust_No'];
    $Total_Deposit      = str_replace('.', '', $_POST['Total_Deposit_2']);
    $Note               = $_POST['Note_2'];
    $Tgl                = date('Y-m-d');

    mysqli_query($conn, "INSERT INTO Customer_Deposit VALUES (0,'$Cust_No','$Total_Deposit','DEBIT (-)','$Note','$Tgl')");
    echo "<script>location.href='../app?p=customer_detail&Cust_No=".$Cust_No."';</script>";
    exit();

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
        $nestedData[] = "<a href='app?p=customer_detail&Cust_No=".$row["Cust_No"]."' style='font-size:15px' class='underline decoration-dotted whitespace-nowrap'>".$row["Cust_Nama"]."</a>";
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
}elseif ($_GET['menu'] == 'datasingle') {
    $Cust_No = $_GET['Cust_No'];
    $requestData= $_REQUEST;
    $columns = array( 
        0 =>'Inv_Number',
        1 =>'Inv_Tgl_Masuk',
        2 =>'Inv_Tgl_Selesai',
        3 =>'Cust_Nama',
        4 =>'Total_PCS',
        5 =>'Payment_Amount',
        6 =>'Status_Payment',
        7 =>'Status_Taken',
    );
    //----------------------------------------------------------------------------------
    //join 2 tabel dan bisa lebih, tergantung kebutuhan
    $sql = "SELECT * from Invoice WHERE Cust_ID='$Cust_No'";
    $query=mysqli_query($conn, $sql) or die("colours?menu=datasingle: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Invoice";
    $sql.= " WHERE Cust_ID='$Cust_No'";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Cust_Nama NOT LIKE '[DELETE]%' AND (Cust_Nama LIKE '%".$requestData['search']['value']."%' "; 
        $sql.=" OR Inv_Number LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Inv_Tgl_Masuk LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Inv_Tgl_Selesai LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Payment_Amount LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Status_Taken LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Status_Payment LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("colours?menu=datasingle: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("colours?menu=datasingle: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    $i = 1;
    while( $row=mysqli_fetch_array($query) ) {

        $nestedData=array(); 
        $nestedData[] = "".$i++."";
        $nestedData[] = "<a href='app?p=transactions_detail&invoice=" . $row['Inv_Number'] ."' style='font-size:15px' class='underline decoration-dotted whitespace-nowrap'>".$row["Inv_Number"]."</a>";
        $nestedData[] = "".date('d M Y', strtotime($row["Inv_Tgl_Masuk"]))."";
        $nestedData[] = "".date('d M Y', strtotime($row["Inv_Tg_Selesai"]))."";
        $nestedData[] = "".$row["Cust_Nama"]."";
        $nestedData[] = "".$row["Total_PCS"]."";
        $nestedData[] = "".$row["Payment_Amount"]."";
        $nestedData[] = "".$row["Status_Payment"]."";
        $nestedData[] = "".$row["Status_Taken"]."";
        
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
} elseif ($_GET['menu'] == 'datadeposit') {
    $Cust_No = $_GET['Cust_No'];
    $requestData= $_REQUEST;
    $columns = array( 
        0 =>'Nilai',
        1 =>'Jenis',
        2 =>'Note',
        3 =>'Tanggal',
    );
    //----------------------------------------------------------------------------------
    //join 2 tabel dan bisa lebih, tergantung kebutuhan
    $sql = "SELECT * from Customer_Deposit WHERE Cust_No='$Cust_No'";
    $query=mysqli_query($conn, $sql) or die("colours?menu=datadeposit: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Customer_Deposit";
    $sql.= " WHERE Cust_No='$Cust_No'";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Nilai NOT LIKE '[DELETE]%' AND (Nilai LIKE '%".$requestData['search']['value']."%' "; 
        $sql.=" OR Note LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Tanggal LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("colours?menu=datadeposit: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("colours?menu=datadeposit: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    $i = 1;
    while( $row=mysqli_fetch_array($query) ) {

        $nestedData=array(); 
        $nestedData[] = "".$i++."";
        $nestedData[] = "".date('d M Y', strtotime($row["Tanggal"]))."";
        $nestedData[] = "".$row["Nilai"]."";
        $nestedData[] = "".$row["Jenis"]."";
        $nestedData[] = "".$row["Note"]."";
        
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