<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$tgl1       = $_GET['tgl1'];
$cabang     = 'MCL2';
$tanggalnya = date('Ymd', strtotime($tgl1));
?>
<link rel="stylesheet" href="plugin/datatable/jquery.dataTables.min.css" />
<link rel="stylesheet" href="plugin/datatable/buttons.dataTables.min.css" />
<div style="width:100%;display: inline-flex;">
    

<div style="width:100%;">
    <h2  style="text-align: center;font-size: 18px;text-transform: uppercase;font-weight: bold;">GENERATE CSV <?php echo date('d F Y', strtotime($tgl1)); ?></h2>
    <br>
    <button class="btn btn-primary mr-1 mb-2" onclick="startsend()">MULAI PENGIRIMAN INVOICE</button> <img id="gambar" style="height:50px;display: none;" src="media/images/loading.gif">
    <br>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th style="width:70px">status</th>
                <th>trx_no</th>
                <th>trx_date</th>
                <th>payment_method_code</th>
                <th>doc_amount</th> 
            </tr>
        </thead>
        <tbody id="hasil">
            <?php 
                $no=1;
                $totpay=0;
                $totround=0;
                $query=mysqli_query($conn,"SELECT * from Invoice_Payment WHERE DATE(Payment_Tgl)='$tgl1' and Inv_Number LIKE '$cabang%'"); 
                while($data = mysqli_fetch_assoc($query)){
                    $header = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='$data[Inv_Number]'"));
            ?>
            <tr>
                <td> 
                    
                    <span id="hasil-<?php echo $no; ?>"></span>
                    <input type="hidden" id="inv-<?php echo $no++; ?>" value="<?php echo $data['Inv_Number'] ?>">

                 </td>
                <td><?php echo $data['Inv_Number'] ?></td>
                <td><?php echo date(DATE_ISO8601, strtotime($data['Payment_Tgl'])); ?></td>
                <td><?php echo $data['Payment_Type']; $totround=$totround+$header['Payment_Rounding'];  ?></td>
                <td><?php echo $data['Payment_Total']; $totpay=$totpay+$data['Payment_Total']; ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="background: yellow;font-weight: bold;font-size: 16px;">Total Sales</td>
                <td style="background: yellow;font-weight: bold;font-size: 16px;">Rp&nbsp;<?php echo number_format($totpay ,0,",","."); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="background: yellow;font-weight: bold;font-size: 16px;">Rounding</td>
                <td style="background: yellow;font-weight: bold;font-size: 16px;">Rp&nbsp;<?php echo number_format($totround ,0,",","."); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="background: yellow;font-weight: bold;font-size: 21px;">Net Sales</td>
                <td style="background: yellow;font-weight: bold;font-size: 21px;">Rp&nbsp;<?php echo number_format($totpay-$totround ,0,",","."); ?></td>
            </tr>
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
                { extend: 'csvHtml5' },
            ] 
        } );     
    } );


     
    var i = 1;
        function startsend(){  
            document.getElementById("gambar").style.display='inline-block';
            const myInterval = setInterval(myTimer, 2000);

            function myTimer(){
                var inv = document.getElementById("inv-"+i).value;
                $.ajax({
                    type: 'GET',
                    url: 'function/sendinvoice.php?inv='+inv,
                    dataType: 'html',
                    success: function (data) {
                        console.log(i);
                        if (data=='success') {
                            document.getElementById("hasil-"+(i-1)).innerHTML = '<span class="text-success">SUCCESS</span>';
                            
                        }else{
                            document.getElementById("hasil-"+(i-1)).innerHTML = '<span class="text-error">ERROR</span>';
                            
                        }
                    }
                });
                i = i+1;
                if (i==<?php echo $no; ?>) {
                    clearInterval(myInterval);
                    document.getElementById("gambar").style.display='none';
                }
            }
        }

        

    
</script>