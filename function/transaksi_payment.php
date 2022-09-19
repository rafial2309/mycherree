<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$Staff_ID           = $_SESSION['Staff_ID'];
$Staff_Name         = $_SESSION['Staff_Name'];
?>

<link rel="stylesheet" href="plugin/selectize/selectize.css" />
<script type="text/javascript" src="plugin/selectize/selectize.min.js"></script>

<?php if ($_GET['menu'] == 'tampilcust' ) { ?>
    <div class="modal-header">
        <h2 class="font-medium text-base mr-auto w-full">
            Payment Invoice
            <div class="grid grid-cols-12 mt-2">
                <div class="col-span-5 mr-3">
                    <select id="customer_data" name="customer" data-placeholder="Select Customer" class="tom-select w-full colour" style="" onchange="ganticustpay()">
                        <option></option>
                        <option>-- SELECT CUSTOMER --</option>
                        <?php 
                            $querycust = mysqli_query($conn,"SELECT * from Customer WHERE Cust_Status='Y' order by Cust_Nama asc");
                            while($datacust = mysqli_fetch_assoc($querycust)){
                        ?>
                            <option value="<?php echo $datacust['Cust_No'] ?>###<?php echo $datacust['Cust_Nama'] ?>###<?php echo $datacust['Cust_Alamat'] ?>###<?php echo $datacust['Cust_Telp'] ?>"><?php echo $datacust['Cust_Nama'] ?></option>
                        <?php } ?>
                     </select> 
                     <script type="text/javascript">
                        $('#customer_data').selectize();
                     </script>
                </div>
                <div class="col-span-7 whitespace-nowrap">
                    <c id="cust_nama">-</c><br>
                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                        <c id="cust_telp">-</c> <br>
                    <c id="cust_alamat">-</c></div>
                </div>
            </div>
            
            
        </h2>
    </div>
    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
        <div class="col-span-12">
            <div class="mt-1" id="hasilinvoice">
                 
             </div>

            <!-- 
            <div class="input-group mt-2"> <input type="text" class="form-control" placeholder="Price" aria-label="Price" aria-describedby="input-group-price" value="INV-2200001 - Rp 300.000">
                <div id="input-group-price" class="input-group-text"><img src="plugin/lucide/trash.svg" class="w-5 h-5" style="box-shadow: none;filter: invert(34%) sepia(26%) saturate(256%) hue-rotate(175deg) brightness(89%) contrast(88%);"></div>
            </div> -->
        </div>
        <div class="col-span-12">
            <hr>
        </div>
        <div class="col-span-6">
             <div class="mt-1 mb-2"> <label>Paymet Method</label>
                 <div class="flex flex-col sm:flex-row mt-2">
                     <div class="form-check mr-3"> <input id="radio-cash" class="form-check-input" type="radio" name="payment_method" value="horizontal-radio-chris-evans" checked> 
                        <label class="form-check-label" for="radio-cash"> CASH</label> </div>

                     <div class="form-check mr-3 mt-2 sm:mt-0"> <input id="radio-transfer" class="form-check-input" type="radio" name="payment_method" value="horizontal-radio-liam-neeson"> 
                        <label class="form-check-label" for="radio-transfer"> TRANSFER</label> </div>

                 </div>
             </div>
        </div>
        <div class="col-span-6">
             <div class="mt-1 mb-2"> <label>Status Taken</label>
                 <div class="flex flex-col sm:flex-row mt-2">
                     <div class="form-check mr-3"> <input id="radio-taken" class="form-check-input" type="radio" name="status_taken" value="horizontal-radio-chris-evans" checked> 
                        <label class="form-check-label" for="radio-taken"> TAKEN</label> </div>

                     <div class="form-check mr-3 mt-2 sm:mt-0"> <input id="radio-untaken" class="form-check-input" type="radio" name="status_taken" value="horizontal-radio-liam-neeson"> 
                        <label class="form-check-label" for="radio-untaken"> UNTAKEN</label> </div>

                 </div>
             </div>
        </div>
        <div class="col-span-12">
            <input type="text" name="payer_name" id="payer_name" class="form-control" placeholder="Payer Name">
        </div>
        <div class="col-span-12">
            <input type="text" name="note" id="note" class="form-control" placeholder="Note">
        </div>
       
        
    </div>
    <div class="modal-footer text-right">
        <button type="button" id="closemodalcustomer" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
        <button type="button" onclick="pilihcust()" class="btn btn-primary w-32">Apply</button>
    </div>
<?php }elseif($_GET['menu'] == 'cari_invoice'){ 
    $customer_data = $_POST['customer_data'];
    ?>
    <select id="invoice_data" data-placeholder="Select Invoice" class="tom-select w-full colour" style="z-index: 99999;">
        <option></option>
        <?php 
            $queryinv = mysqli_query($conn,"SELECT * from Invoice WHERE Cust_ID='$customer_data' AND Status_Payment='N' ");
            while($datainv = mysqli_fetch_assoc($queryinv)){
        ?>
            <option value="<?php echo $datainv['Inv_Number'] ?>">INV-<?php echo $datainv['Inv_Number'] ?> &nbsp; Rp <?php echo number_format($datainv['Payment_Amount'] ,0,",",".")?></option>
        <?php } ?>
     </select> 
     <script type="text/javascript">
        $('#invoice_data').selectize();
     </script>
<?php } ?>