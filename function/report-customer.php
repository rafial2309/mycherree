<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'tampilcustomer' ) { ?>
	<link rel="stylesheet" href="plugin/selectize/selectize.css" />
    <script type="text/javascript" src="plugin/selectize/selectize.min.js" ></script>
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

<?php } elseif ($_GET['menu'] == 'tampil') { 
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    $cust = $_GET['cust'];
    ?>
   



    <link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th style="width:30px">No</th>
                    <th>Invoice</th>
                    <th>Order</th>
                    <th>Ready</th>
                    <th>Customer</th>
                    <th>Pcs</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Taken</th>
                </tr>
            </thead>
            <tbody id="hasil">
                <?php 
                    $no=1;
                    $query=mysqli_query($conn,"SELECT * from Invoice WHERE Cust_Id='$cust' and Inv_Tgl_Masuk>='$tgl1' AND Inv_Tgl_Masuk <= '$tgl2'"); 
                    while($data = mysqli_fetch_assoc($query)){
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['Inv_Number'] ?></td>
                    <td><?php echo date('d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?></td>
                    <td><?php echo date('d M Y', strtotime($data['Inv_Tg_Selesai'])); ?></td>
                    <td><?php echo $data['Cust_Nama'] ?></td>
                    <td><?php echo $data['Total_PCS'] ?></td>
                    <td>Rp <?php echo number_format($data['Payment_Amount'] ,0,",",".")?></td>
                    <td><?php if ($data['Status_Payment']=='Y') { echo 'PAID'; } ?></td>
                    <td><?php echo $data['Status_Taken'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

            <script type="text/javascript" src="plugin/datatable/jquery-3.5.1.js"></script>
            <script type="text/javascript" src="plugin/datatable/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="plugin/datatable/dataTables.buttons.min.js"></script>
            <script type="text/javascript" src="plugin/datatable/buttons.flash.min.js"></script>
            <script type="text/javascript" src="plugin/datatable/jszip.min.js"></script>
            <script type="text/javascript" src="plugin/datatable/buttons.html5.min.js"></script>

        <script type="text/javascript">

                        
                        $(document).ready(function() {
                            $('#example').DataTable( {
                                dom: 'Bfrtip',
                                "paging": false,
                                buttons: [
                                    'excel',
                                    
                                    ],  
                                 
                            } );     
                        } );

                        function btnExcel () {
                            //let search = $('#example_filter :input').val();

                            //location.href='function/report?type=customer&search='+search;
                        }

                        

        </script>

<?php } 
?>