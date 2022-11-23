<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$tgl1 = $_GET['tgl1'];
$tanggalnya = date('Ymd', strtotime($tgl1));
?>
<link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
<link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
<div style="width:100%;display: inline-flex;">
    

<div style="width:100%;">
    <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;">DATE LINE <?php echo date('d F Y', strtotime($tgl1)); ?></h2>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>trx_no</th>
                <th>item_code</th>
                <th>item_name</th>
                <th>qty</th>
                <th>price</th>
                <th>disc_amount</th>
            </tr>
        </thead>
        <tbody id="hasil">
            <?php 
                $query=mysqli_query($conn,"SELECT * from Invoice_Payment WHERE DATE(Payment_Tgl)='$tgl1'"); 
                while($data = mysqli_fetch_assoc($query)){
                    $detail = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='$data[Inv_Number]'"));
            ?>
            <tr>
                <td><?php echo $data['Inv_Number'] ?></td>
                <td><?php echo date(DATE_ISO8601, strtotime($data['Payment_Tgl'])); ?></td>
                <td><?php echo $data['Payment_Type'] ?></td>
                <td><?php echo $data['Payment_Type'] ?></td>
                <td><?php echo $data['Payment_Total'] ?></td>
                <td><?php echo $data['Payment_Total'] ?></td>
                <td>0</td>
                <td><?php echo $header['Total_Diskon'] ?></td>
                <td>0</td>
                <td>0</td>
                <td><?php echo $header['Payment_Rounding'] ?></td>
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
                { extend: 'csvHtml5',fieldBoundary: '',title: 'trans_details_<?php echo $tanggalnya; ?>' },
            ]

            
             
        } );     
    } );
</script>