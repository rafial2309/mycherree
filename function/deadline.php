<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$tgl1 = $_GET['tgl1'];
?>
<link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
<link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
<div style="width:100%;display: inline-flex;">
    

<div style="width:100%;">
    <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;">DATE LINE <?php echo date('d F Y', strtotime($tgl1)); ?></h2>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th style="width:30px">No</th>
                <th>Invoice</th>
                <th>Order</th>
                <th>Ready</th>
                <th>Customer</th>
                <th>Address</th>
                <th>Item</th>
                <th style="width:100px">Total</th>
                <th>Payment</th>
                <th>Sign</th>
            </tr>
        </thead>
        <tbody id="hasil">
            <?php 
                $no=1;
                $totpcs=0;
                $totpay=0;
                $query=mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Tg_Selesai='$tgl1'"); 
                while($data = mysqli_fetch_assoc($query)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['Inv_Number'] ?></td>
                <td><?php echo date('d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?></td>
                <td><?php echo date('d M Y', strtotime($data['Inv_Tg_Selesai'])); ?></td>
                <td><?php echo $data['Cust_Nama'] ?></td>
                <td style="text-transform: capitalize;"><?php echo $data['Cust_Alamat'] ?></td>
                <td><?php echo $data['Total_PCS']; $totpcs = $totpcs+intval($data['Total_PCS']); ?></td>
                <td>Rp&nbsp;<?php echo number_format($data['Payment_Amount'] ,0,",","."); $totpay = $totpay+intval($data['Payment_Amount']);?></td>
                <td><?php if ($data['Status_Payment']=='Y') { echo 'PAID'; } ?></td>
                <td></td>
            </tr>
            <?php } ?>
            
        </tbody>
        <tfoot>
            <tr style="background-color:yellow;font-weight: bold;font-size: 20px;">
                <td></td>
                <td style="font-weight:bold;">TOTAL</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight:bold;"><?php echo number_format($totpcs ,0,",","."); ?></td>
                <td>Rp&nbsp;<?php echo number_format($totpay ,0,",","."); ?></td>
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
                        "paging": false,
                        "order":false,
                        buttons: [
                            { extend: 'excelHtml5', footer: true,messageTop: 'DATE LINE <?php echo date('d F Y', strtotime($tgl1)); ?>' },
                        ]

                        
                         
                    } );     
                } );

              

           

                function btnExcel () {
                    //let search = $('#example_filter :input').val();

                    //location.href='function/report?type=customer&search='+search;
                }

                

</script>