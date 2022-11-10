<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$tgl1 = $_GET['tgl1'];
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
            <th>Total Pcs</th>
        </tr>
    </thead>
    <tbody id="hasil">
        <?php 
            $no=1;
            $query=mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Tg_Selesai='$tgl1'"); 
            while($data = mysqli_fetch_assoc($query)){
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['Inv_Number'] ?></td>
            <td><?php echo date('d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?></td>
            <td><?php echo date('d M Y', strtotime($data['Inv_Tg_Selesai'])); ?></td>
            <td><?php echo $data['Cust_Nama'] ?></td>
            <td><?php echo $data['Total_PCS'] ?></td>
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