<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$cabang         = $_SESSION['cabang'];
if ($_GET['menu'] == 'Top Customer') { ?>
    <h2 class="intro-y text-lg font-medium">
        Generate Report <i><?php echo $_GET['menu']; ?></i>
    </h2>

	<input type="date"   name="" id="tanggal1">
    <input type="date"  name="" id="tanggal2">
    <button class="btn btn-primary mr-1 mb-2" onclick="ambildata1()">Generate</button>
    <br>
    <div id="hasilajaxreport">
        
    </div>
<?php }elseif($_GET['menu'] == 'ambildata1'){ 
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    ?>

    <link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
    <div style="width:100%;display: inline-flex;">
        

        <div style="width:50%;margin-top: 10px;">
            <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;margin-bottom: 15px;">TOP 100 Customer by PCS</h2>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:30px">No</th>
                        <th>Customer</th>
                        <th>Member</th>
                        <th>Pcs</th>
                    </tr>
                </thead>
                <tbody id="hasil">
                    <?php 
                        $no=1;
                        $totpcs=0;
                        $totpay=0;
                        $query=mysqli_query($conn,"SELECT Cust_ID, Cust_Nama, SUM(Total_PCS) as total from Invoice WHERE Inv_Tgl_Masuk>='$tgl1' AND Inv_Tgl_Masuk<='$tgl2' GROUP BY Cust_ID ORDER BY SUM(Total_PCS) DESC LIMIT 100"); 
                        while($data = mysqli_fetch_assoc($query)){
                            $cekmember = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount_Nama from Discount JOIN Customer ON Customer.Discount_No=Discount.Discount_No WHERE Cust_No='$data[Cust_ID]'"));
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['Cust_Nama'] ?></td>
                        <td><?php if (isset($cekmember['Discount_Nama'])) { echo $cekmember['Discount_Nama']; } ?></td>
                        <td><?php echo $data['total'] ?></td>
                    </tr>
                    <?php } ?>
                    
                </tbody>
                
            </table>
        </div>

        <div style="width:50%;margin-top: 10px;margin-left: 20px;">
            <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;margin-bottom: 15px;">TOP 100 Customer by Total Invoice</h2>
            <table id="example2" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:30px">No</th>
                        <th>Customer</th>
                        <th>Member</th>
                        <th>Total Invoice</th>
                    </tr>
                </thead>
                <tbody id="hasil">
                    <?php 
                        $nox=1;
                        $totpcs=0;
                        $totpay=0;
                        $query=mysqli_query($conn,"SELECT Cust_ID, Cust_Nama, SUM(Payment_Amount) as total from Invoice WHERE Inv_Tgl_Masuk>='$tgl1' AND Inv_Tgl_Masuk<='$tgl2' GROUP BY Cust_ID ORDER BY SUM(Payment_Amount) DESC LIMIT 100"); 
                        while($data = mysqli_fetch_assoc($query)){
                            $cekmember = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount_Nama from Discount JOIN Customer ON Customer.Discount_No=Discount.Discount_No WHERE Cust_No='$data[Cust_ID]'"));
                    ?>
                    <tr>
                        <td><?php echo $nox++; ?></td>
                        <td><?php echo $data['Cust_Nama'] ?></td>
                        <td><?php if (isset($cekmember['Discount_Nama'])) { echo $cekmember['Discount_Nama']; } ?></td>
                        <td>Rp&nbsp;<?php echo number_format($data['total'] ,0,",","."); ?></td>
                    </tr>
                    <?php } ?>
                    
                </tbody>
                
            </table>
        </div>
    </div>

    <script type="text/javascript" src="plugin/datatable/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="plugin/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.flash.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" src="plugin/datatable/jszip.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript">   
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                "paging": false,
                "order":false,
                buttons: [
                    { extend: 'excelHtml5', footer: true,messageTop: 'Top 100 Customer by PCS' },
                ]   
            } );     
        } );

        $(document).ready(function() {
            $('#example2').DataTable( {
                dom: 'Bfrtip',
                "paging": false,
                "order":false,
                buttons: [
                    { extend: 'excelHtml5', footer: true,messageTop: 'Top 100 Customer by Total Invoice' },
                ]   
            } );     
        } );
    </script>

<?php }elseif($_GET['menu'] == 'Customer Retention'){ ?>
    <h2 class="intro-y text-lg font-medium">
        Generate Report <i><?php echo $_GET['menu']; ?></i>
    </h2>

    <b>Select Closing Date (Age >30 days)</b>
    <input type="date"   name="" id="tanggal1">
    <button class="btn btn-primary mr-1 mb-2" onclick="ambildata2()">Generate</button>
    <br>
    <div id="hasilajaxreport">
        
    </div>
<?php }elseif($_GET['menu'] == 'ambildata2'){ 
    $tgl1 = $_GET['tgl1'];
    ?>

    <link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
    <div style="width:100%;display: inline-flex;">
        

        <div style="width:100%;margin-top: 10px;">
            <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;margin-bottom: 15px;">Customer Retention <br>
                <small style="font-size: 10px;font-weight: normal;">Menampilkan customer yang tidak balik kembali melebihi 30 hari dari tanggal closing date yang dipilih</small>
            </h2>

         
            
            <br>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Member</th>
                        <th>Days</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody id="hasil">

                    <?php 


                       
                        
                        $datetime2 = new DateTime($tgl1);
                        

                        $no=1;
                        $totpcs=0;
                        $totpay=0;
                        $query=mysqli_query($conn,"SELECT Cust_ID,Cust_Nama,Cust_Telp,Cust_Alamat, MAX(Inv_Tgl_Masuk) as dm  FROM Invoice WHERE Inv_Tgl_Masuk<'$tgl1' AND Inv_Number LIKE '%$cabang%' GROUP BY Cust_ID ORDER BY Inv_No DESC"); 

                        while($data = mysqli_fetch_assoc($query)){
                        
                        // $datetime1 = new DateTime($data['dm']);
                        // $interval = $datetime1->diff($datetime2);

                        // $dd = $interval->format('%d');


                        $date1=date_create($data['dm']);
                        $date2=date_create($tgl1);
                        $diff=date_diff($date1,$date2);
                        $dd = intval($diff->format("%a"));
                        

                        if($dd > 30) {
                            $cekmember = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount_Nama from Discount JOIN Customer ON Customer.Discount_No=Discount.Discount_No WHERE Cust_No='$data[Cust_ID]'"));
                    ?>
                        <tr>
                            <td><?php echo $data['Cust_Nama'] ?></td>
                            <td><?php echo $data['Cust_Telp'] ?></td>
                            <td><?php echo $data['Cust_Alamat'] ?></td>
                            <td><?php if (isset($cekmember['Discount_Nama'])) { echo $cekmember['Discount_Nama']; } ?></td>
                            <td><?php echo $dd; ?></td>
                            <td><?php echo $diff->format('%y years %m months and %d days'); ?></td>
                        </tr>
                    <?php } } ?>
                    
                </tbody>
                
            </table>
        </div>

    </div>

    <script type="text/javascript" src="plugin/datatable/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="plugin/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.flash.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" src="plugin/datatable/jszip.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript">   
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                "paging": false,
                order: [[2, 'desc']],
                buttons: [
                    { extend: 'excelHtml5', footer: true,messageTop: 'Customer Retention' },
                ]   

            } );     
        } );

        
    </script>
<?php }elseif($_GET['menu'] == 'Customer UNPAID'){ ?>
    <h2 class="intro-y text-lg font-medium">
        Generate Report <i><?php echo $_GET['menu']; ?></i>
    </h2>

    <b>Select Closing Date</b>
    <input type="date"   name="" id="tanggal1">
    <button class="btn btn-primary mr-1 mb-2" onclick="ambildata3()">Generate</button>
    <br>
    <div id="hasilajaxreport">
        
    </div>
<?php }elseif($_GET['menu'] == 'ambildata3'){ 
    $tgl1 = $_GET['tgl1'];
    ?>

    <link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
    <div style="width:100%;display: inline-flex;">
        

        <div style="width:100%;margin-top: 10px;">
            <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;margin-bottom: 15px;">Customer UNPAID</h2>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:30px">No</th>
                        <th>Invoice</th>
                        <th>Order</th>
                        <th>Ready</th>
                        <th>Customer</th>
                        <th>Member</th>
                        <th>Address</th>
                        <th>Item</th>
                        <th style="width:100px">Total</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody id="hasil">

                    <?php 
                        $no=1;
                        $totpcs=0;
                        $totpay=0;
                        $query=mysqli_query($conn,"SELECT *  FROM Invoice WHERE Inv_Number LIKE '%$cabang%' AND Inv_Tgl_Masuk<'$tgl1' AND status_payment='N' AND Status_Inv!='C' ORDER BY Inv_No DESC"); 
                        while($data = mysqli_fetch_assoc($query)){
                             
                        $cekmember = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount_Nama from Discount JOIN Customer ON Customer.Discount_No=Discount.Discount_No WHERE Cust_No='$data[Cust_ID]'"));
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['Inv_Number'] ?></td>
                            <td><?php echo date('d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($data['Inv_Tg_Selesai'])); ?></td>
                            <td><?php echo $data['Cust_Nama'] ?></td>
                            <td><?php if (isset($cekmember['Discount_Nama'])) { echo $cekmember['Discount_Nama']; } ?></td>
                            <td style="text-transform: capitalize;"><?php echo $data['Cust_Alamat'] ?></td>
                            <td><?php echo $data['Total_PCS']; $totpcs = $totpcs+intval($data['Total_PCS']); ?></td>
                            <td>Rp&nbsp;<?php echo number_format($data['Payment_Amount'] ,0,",","."); $totpay = $totpay+intval($data['Payment_Amount']);?></td>
                            <td><?php if ($data['Status_Payment']=='Y') { echo 'PAID/LUNAS'; }else{ echo 'UNPAID/BELUM BAYAR'; } ?></td>
                        </tr>
                    <?php } ?>
                    
                </tbody>
                
            </table>
        </div>

    </div>

    <script type="text/javascript" src="plugin/datatable/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="plugin/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.flash.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" src="plugin/datatable/jszip.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript">   
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                order: [[2, 'desc']],
                buttons: [
                    { extend: 'excelHtml5', footer: true,messageTop: 'Customer UNPAID' },
                ]   

            } );     
        } );

        
    </script>
<?php }elseif($_GET['menu'] == 'Customer UNTAKEN'){ ?>
    <h2 class="intro-y text-lg font-medium">
        Generate Report <i><?php echo $_GET['menu']; ?></i>
    </h2>

    <b>Select Closing Date</b>
    <input type="date"   name="" id="tanggal1">
    <button class="btn btn-primary mr-1 mb-2" onclick="ambildata4()">Generate</button>
    <br>
    <div id="hasilajaxreport">
        
    </div>
<?php }elseif($_GET['menu'] == 'ambildata4'){ 
    $tgl1 = $_GET['tgl1'];
    ?>
    <link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
    <div style="width:100%;display: inline-flex;">
        

        <div style="width:100%;margin-top: 10px;">
            <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;margin-bottom: 15px;">Customer UNTAKEN</h2>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:30px">No</th>
                        <th>Invoice</th>
                        <th>Order</th>
                        <th>Ready</th>
                        <th>Customer</th>
                        <th>Member</th>
                        <th>Address</th>
                        <th>Item</th>
                        <th style="width:100px">Total</th>
                        <th>Untaken</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody id="hasil">

                    <?php 
                        $no=1;
                        $totpcs=0;
                        $totpay=0;
                        $query=mysqli_query($conn,"SELECT *  FROM Invoice WHERE Inv_Number LIKE '%$cabang%' AND Inv_Tgl_Masuk<'$tgl1' AND Status_Taken='N' ORDER BY Inv_No DESC"); 
                        while($data = mysqli_fetch_assoc($query)){
                             
                        $cekmember = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount_Nama from Discount JOIN Customer ON Customer.Discount_No=Discount.Discount_No WHERE Cust_No='$data[Cust_ID]'"));
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['Inv_Number'] ?></td>
                            <td><?php echo date('d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($data['Inv_Tg_Selesai'])); ?></td>
                            <td><?php echo $data['Cust_Nama'] ?></td>
                            <td><?php if (isset($cekmember['Discount_Nama'])) { echo $cekmember['Discount_Nama']; } ?></td>
                            <td style="text-transform: capitalize;"><?php echo $data['Cust_Alamat'] ?></td>
                            <td><?php echo $data['Total_PCS']; $totpcs = $totpcs+intval($data['Total_PCS']); ?></td>
                            <td>Rp&nbsp;<?php echo number_format($data['Payment_Amount'] ,0,",","."); $totpay = $totpay+intval($data['Payment_Amount']);?></td>
                            <td><?php if ($data['Status_Taken']=='N') { echo 'UNTAKEN/PENDINGAN'; } ?></td>
                            <td><?php if ($data['Status_Payment']=='N') { echo 'UNPAID/BL'; }else{ echo 'PAID/L'; } ?></td>
                        </tr>
                    <?php } ?>
                    
                </tbody>
                
            </table>
        </div>

    </div>

    <script type="text/javascript" src="plugin/datatable/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="plugin/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.flash.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" src="plugin/datatable/jszip.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript">   
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                order: [[2, 'desc']],
                buttons: [
                    { extend: 'excelHtml5', footer: true,messageTop: 'Customer UNTAKEN' },
                ]   

            } );     
        } );

        
    </script>

<?php }elseif($_GET['menu'] == 'Customer JOIN'){ ?>
    <h2 class="intro-y text-lg font-medium">
        Generate Report <i><?php echo $_GET['menu']; ?></i>
    </h2>

    <b>Select Range Date</b>
    <input type="date"   name="" id="tanggal1">
    <input type="date"  name="" id="tanggal2">
    <select name="" data-placeholder="Select Report" id="cabang5">
        <option>-- Select Store --</option>
        <option value="MCL1">MCL1</option>
        <option value="MCL2">MCL2</option>
    </select>
    <button class="btn btn-primary mr-1 mb-2" onclick="ambildata5()">Generate</button>
    <br>
    <div id="hasilajaxreport">
        
    </div>
<?php }elseif($_GET['menu'] == 'ambildata5'){ 
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    $cabang = $_GET['cabang'];
    ?>
    <link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
    <div style="width:100%;display: inline-flex;">
        

        <div style="width:100%;margin-top: 10px;">
            <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;margin-bottom: 15px;">Customer JOIN Report</h2>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:30px">No</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Member</th>
                        <th>Store</th>
                        <th>Join</th>
                    </tr>
                </thead>
                <tbody id="hasil">

                    <?php 
                        $no=1;
                        $query=mysqli_query($conn,"SELECT *  FROM Customer WHERE (Cust_Tgl_Join>='$tgl1' AND Cust_Tgl_Join<='$tgl2') and Cust_Store='$cabang' ORDER BY Cust_Tgl_Join ASC"); 
                        $jmldata = mysqli_num_rows($query);
                        while($data = mysqli_fetch_assoc($query)){  
                            $cekmember = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount_Nama from Discount JOIN Customer ON Customer.Discount_No=Discount.Discount_No WHERE Cust_No='$data[Cust_No]'"));
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['Cust_Nama'] ?></td>
                            <td><?php echo $data['Cust_Alamat'] ?></td>
                            <td><?php echo $data['Cust_Telp'] ?></td>
                            <td><?php if (isset($cekmember['Discount_Nama'])) { echo $cekmember['Discount_Nama']; } ?></td>
                            <td><?php echo $data['Cust_Store'] ?></td>
                            <td><?php echo date('d M Y', strtotime($data['Cust_Tgl_Join'])); ?></td>
                        </tr>
                    <?php } ?>
                    
                </tbody>
                <tfoot>
                    <tr style="background-color:yellow;font-weight: bold;font-size: 20px;">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;">TOTAL</td>
                        <td style="font-weight:bold;"><?php echo number_format($jmldata ,0,",","."); ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    <script type="text/javascript" src="plugin/datatable/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="plugin/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.flash.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" src="plugin/datatable/jszip.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript">   
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                order: [[0, 'asc']],
                buttons: [
                    { extend: 'excelHtml5', footer: true,messageTop: 'Customer Join Report' },
                ]   

            } );     
        } );

        
    </script>

<?php }elseif($_GET['menu'] == 'Member JOIN'){ ?>
    <h2 class="intro-y text-lg font-medium">
        Generate Report <i><?php echo $_GET['menu']; ?></i>
    </h2>

    <b>Select Range Date</b>
    <input type="date"   name="" id="tanggal1">
    <input type="date"  name="" id="tanggal2">
    <select name="" data-placeholder="Select Report" id="cabang6">
        <option>-- Select Store --</option>
        <option value="MCL1">MCL1</option>
        <option value="MCL2">MCL2</option>
    </select>

    <button class="btn btn-primary mr-1 mb-2" onclick="ambildata6()">Generate</button>
    <br>
    <div id="hasilajaxreport">
        
    </div>
<?php }elseif($_GET['menu'] == 'ambildata6'){ 
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    $cabang = $_GET['cabang'];
    ?>
    <link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
    <div style="width:100%;display: inline-flex;">
        

        <div style="width:100%;margin-top: 10px;">
            <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;margin-bottom: 15px;">Customer Member JOIN Report</h2>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:30px">No</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Member</th>
                        <th>Store</th>
                        <th>Join Member</th>
                    </tr>
                </thead>
                <tbody id="hasil">

                    <?php 
                        $no=1;
                        $query=mysqli_query($conn,"SELECT *  FROM Customer WHERE (Cust_Member_Join>='$tgl1' AND Cust_Member_Join<='$tgl2') and Cust_Store='$cabang' ORDER BY Cust_Member_Join ASC"); 
                        $jmldata = mysqli_num_rows($query);
                        while($data = mysqli_fetch_assoc($query)){  
                            $cekmember = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount_Nama from Discount JOIN Customer ON Customer.Discount_No=Discount.Discount_No WHERE Cust_No='$data[Cust_No]'"));
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['Cust_Nama'] ?></td>
                            <td><?php echo $data['Cust_Alamat'] ?></td>
                            <td><?php echo $data['Cust_Telp'] ?></td>
                            <td><?php if (isset($cekmember['Discount_Nama'])) { echo $cekmember['Discount_Nama']; } ?></td>
                            <td><?php echo $data['Cust_Store']; ?></td>
                            <td><?php echo date('d M Y', strtotime($data['Cust_Member_Join'])); ?></td>
                        </tr>
                    <?php } ?>
                    
                </tbody>
                <tfoot>
                    <tr style="background-color:yellow;font-weight: bold;font-size: 20px;">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;">TOTAL</td>
                        <td style="font-weight:bold;"><?php echo number_format($jmldata ,0,",","."); ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    <script type="text/javascript" src="plugin/datatable/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="plugin/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.flash.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" src="plugin/datatable/jszip.min.js"></script>
    <script type="text/javascript" src="plugin/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript">   
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                order: [[0, 'asc']],
                buttons: [
                    { extend: 'excelHtml5', footer: true,messageTop: 'Customer Member JOIN' },
                ]   

            } );     
        } );

        
    </script>

<?php } ?> 