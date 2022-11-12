<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'create' ) {
	// ADD NEW CUSTOMER
	$Customer 		    = explode(' - ', $_POST['Customer']);
	$Cust_No 		    = $Customer[0];
	$Cust_Nama 		 	= $Customer[1];
	$Registrasi_Tgl 	= date('Y-m-d');
    $Discount_No 		= $_POST['Discount_No'];
	$Registrasi_Payment = str_replace('.', '', $_POST['Registrasi_Payment']);
    $Cust_Member_Join 	= $_POST['Cust_Member_Join'];
	$Cust_Member_Exp 	= $_POST['Cust_Member_Exp'];
    $Staff_Name 		= ($_SESSION <> null) ? $_SESSION['Staff_Name'] : 'Admin';
	$Staff_ID 		    = ($_SESSION <> null) ? $_SESSION['Staff_ID'] : 'Admin';

	mysqli_query($conn, "INSERT INTO Registrasi_Member (Cust_No, Cust_Nama, Registrasi_Tgl, Discount_No, Registrasi_Payment, Cust_Member_Join, Cust_Member_Exp, Staff_ID, Status_Payment) VALUES ('$Cust_No', '$Cust_Nama', '$Registrasi_Tgl', '$Discount_No', '$Registrasi_Payment', '$Cust_Member_Join', '$Cust_Member_Exp', '$Staff_ID', 'N')");
    
    $disc       = mysqli_fetch_assoc(mysqli_query($conn, "SELECT *FROM Discount WHERE Discount_No='$Discount_No'"));
    $disc_name  = $disc['Discount_Nama'];
    
    mysqli_query($conn, "UPDATE Customer SET Discount_No='$Discount_No', Cust_Member_Name='$disc_name', Cust_Member_Join='$Cust_Member_Join', Cust_Member_Exp='$Cust_Member_Exp' WHERE Cust_No='$Cust_No'");
} elseif ($_GET['menu'] == 'data') {
    $requestData= $_REQUEST;
    $columns = array( 
        0 =>'Cust_No',
        1 =>'Cust_Nama',
        2 =>'Registrasi_Tgl',
        3 =>'Discount_No',
        4 =>'Registrasi_Payment',
        5 =>'Status_Payment',
        6 =>'Payment_Type',
        7 =>'Cust_Member_Join',
        8 =>'Cust_Member_Exp',
        9 =>'Staff_Name',
    );
    //----------------------------------------------------------------------------------
    //join 2 tabel dan bisa lebih, tergantung kebutuhan
    $sql = "SELECT * from Registrasi_Member";
    $query=mysqli_query($conn, $sql) or die("membership_processing.php: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Registrasi_Member";
    $sql.= " WHERE 1=1";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Cust_Nama NOT LIKE '[DELETE]%' AND ( Cust_Nama LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR Registrasi_Tgl LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Payment_Type LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Registrasi_Payment LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Cust_Member_Join LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR Cust_Member_Exp LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("membership_processing.php: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("membership_processing.php: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    while( $row=mysqli_fetch_array($query) ) {
        $amount = number_format($row['Registrasi_Payment'],0,',','.');
        
        $nestedData=array(); 
        $nestedData[] = $row['Registrasi_Tgl'];
        $nestedData[] = $row["Cust_Nama"];
        $nestedData[] = ($row['Status_Payment'] == 'Y') ? "<button class='btn btn-sm btn-dark w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#payment-member-modal' onclick='btnPayment(".$row['Registrasi_ID'].")'>PAID</button>" : "<button class='btn btn-sm btn-danger w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#payment-member-modal' onclick='btnPayment(".$row['Registrasi_ID'].")'>UNPAID</button>";
        $nestedData[] = ($row['Status_Payment'] == 'Y') ? $amount." | ".$row["Payment_Type"] : "";
        $nestedData[] = $row["Cust_Member_Join"]." - ".$row["Cust_Member_Exp"];
        $nestedData[] = $row["Staff_Name"];
        $nestedData[] = "<button class='btn btn-sm btn-primary w-16 mr-1 mb-2' onclick='printMember(".$row['Registrasi_ID'].")'>PRINT</button>";
        
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
    $Registrasi_ID = $_POST['Registrasi_ID'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Registrasi_Member WHERE Registrasi_ID='$Registrasi_ID'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'Registrasi_ID'         => $data['Registrasi_ID'],
        'Customer'              => $data['Cust_No'] .' - '.$data['Cust_Nama'],
        'Registrasi_Tgl'        => $data['Registrasi_Tgl'],
        'Discount_No'           => $data['Discount_No'],
        'Registrasi_Payment'    => $data['Registrasi_Payment'],
        'Status_Payment'        => $data['Status_Payment'],
        'Payment_Type'          => $data['Payment_Type'],
        'Cust_Member_Join'      => $data['Cust_Member_Join'],
        'Cust_Member_Exp'       => $data['Cust_Member_Exp'],
        'Staff_Name'            => $data['Staff_Name'],
    ];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} elseif ($_GET['menu'] == 'get_payment') { 
    // KEYWORD DIKIRIM DENGAN METHOD POST
    $Registrasi_ID = $_POST['Registrasi_ID'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Registrasi_Member WHERE Registrasi_ID='$Registrasi_ID'");
    $data 	= mysqli_fetch_assoc($sql);

    $json = [ 
        'Registrasi_ID'         => $data['Registrasi_ID'],
        'Status_Payment'        => $data['Status_Payment'],
        'Payment_Type'          => $data['Payment_Type'],
    ];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} elseif ($_GET['menu'] == 'payment') { 
    // UPDATE PAYMENT STATUS
    $Registrasi_ID  = $_POST['Registrasi_ID'];
    $Status_Payment = $_POST['Status_Payment'];
    $Payment_Type   = $_POST['Payment_Type'];
    $Staff_Name 	= ($_SESSION <> null) ? $_SESSION['Staff_Name'] : 'Admin';
	$Staff_ID 		= ($_SESSION <> null) ? $_SESSION['Staff_ID'] : 'Admin';

    mysqli_query($conn, "UPDATE Registrasi_Member SET Status_Payment='$Status_Payment', Payment_Type='$Payment_Type', Staff_ID='$Staff_ID', Staff_Name='$Staff_Name' WHERE Registrasi_ID='$Registrasi_ID'");

} elseif ($_GET['menu'] == 'formsz') {  ?>
    <link rel="stylesheet" href="plugin/selectize/selectize.css" />
    <script type="text/javascript" src="plugin/selectize/selectize.min.js"></script>
    <div class="col-span-12">
        <label for="pilihcustomer" class="form-label">Customer</label>
        <select name="Customer" id="pilihcustomer" data-placeholder="Select Customers" class="w-full pilihcustomer">
            <option></option>
            <?php 
                $querycust = mysqli_query($conn,"SELECT * from Customer WHERE Cust_Status='Y' order by Cust_Nama asc");
                while($datacust = mysqli_fetch_assoc($querycust)){
            ?>
                <option value="<?php echo $datacust['Cust_No'] ?> - <?php echo $datacust['Cust_Nama'] ?>"><?php echo $datacust['Cust_Nama'] ?> | <?php echo $datacust['Cust_Alamat'] ?></option>
            <?php } ?>
        </select>

        <script type="text/javascript">
            $('#pilihcustomer').selectize();
        </script>
    </div>
     <div class="col-span-12">
        <label for="pilihdiscount" class="form-label">Discount</label>
        <select name="Discount_No" id="pilihdiscount" data-placeholder="Select Customers" class="pilihdiscount">
            <option></option>
            <?php 
                $query = mysqli_query($conn,"SELECT * from Discount WHERE Discount_Status='Y' order by Discount_Nama asc");
                while($disc = mysqli_fetch_assoc($query)){
            ?>
                <option value="<?php echo $disc['Discount_No'] ?>"><?php echo $disc['Discount_Nama'] ?> (<?php echo $disc['Persentase'] ?>%)</option>
            <?php } ?>
        </select>
        <script type="text/javascript">
            $('#pilihdiscount').selectize();
        </script>
    </div>
    <div class="col-span-12">
        <label for="pos-form-3" class="form-label">Jumlah Pembayaran</label>
        <input type="text" name="Registrasi_Payment" id="pos-form-3" class="form-control flex-1 uang" placeholder="50.000">
        <!-- <div class="input-group">    
            <div id="input-group-uang" class="input-group-text">Rp</div> 
            <input type="text" name="Registrasi_Payment" id="pos-form-3" class="form-control flex-1 uang" placeholder="50.000"  aria-describedby="input-group-uang">
        </div> -->
    </div>
    <div class="col-span-6">
        <label for="pos-form-4" class="form-label">Start Date</label>
        <input id="pos-form-4" type="date" name="Cust_Member_Join" class="form-control flex-1" onchange="fillExpired(this.valueAsDate)">
    </div>
    <div class="col-span-6">
        <label for="expired" class="form-label">Expired Date</label>
        <input id="expired" type="date" name="Cust_Member_Exp" class="form-control flex-1" readonly>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        // Format mata uang.
        $( '.uang' ).mask('000.000.000', {reverse: true});
    });
</script>
<?php 
    exit();
    }else {
	// DELETE CUSTOMER
	$Registrasi_ID = $_GET['id'];

	mysqli_query($conn, "DELETE FROM Registrasi_Member WHERE Registrasi_ID='$Registrasi_ID'");
}
// REDIRECT KEMBALI KE HALAMAN USER
echo "<script>location.href='../app?p=membership';</script>";
?>