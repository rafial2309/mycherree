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
                 <select id="invoice_datax" data-placeholder="Select Invoice" class="tom-select w-full colour" style="z-index: 99999;">
                    <option></option>
                  
                 </select> 
                 <script type="text/javascript">
                    $('#invoice_datax').selectize();
                 </script>
             </div>
            
                <div class="col-span-12 lg:col-span-12 2xl:col-span-12">
                   
                    <div class="box p-3 rounded-md mt-3">
                        <div id="isi_inv">
                            
                            
                        </div>
                        
                        

                        <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-3 mt-3 font-medium">
                            &nbsp;  Total Payment: 
                            <div class="ml-auto">Rp <c id="totalpay">-</c></div>
                            <input type="hidden" name="totalpay" id="totalpay_data">
                        </div>
                    </div>
                   
                </div>
                
         
        </div>
        <div class="col-span-12">
            <hr>
        </div>
        <div class="col-span-6">
             <div class="mt-1 mb-2"> <label>Paymet Method</label>
                 <div class="flex flex-col sm:flex-row mt-3">
                     <div class="form-check mr-3"> <input id="radio-cash" class="form-check-input" type="radio" name="payment_method" value="CASH" checked> 
                        <label class="form-check-label" for="radio-cash"> CASH</label> </div>

                     <div class="form-check mr-3 mt-2 sm:mt-0"> <input id="radio-transfer" class="form-check-input" type="radio" name="payment_method" value="TRANSFER"> 
                        <label class="form-check-label" for="radio-transfer"> TRANSFER</label> </div>

                 </div>
             </div>
        </div>
        <div class="col-span-6">
             <div class="mt-1 mb-2"> <label>Status Taken</label>
                 <div class="flex flex-col sm:flex-row mt-3">
                     <div class="form-check mr-3"> <input id="radio-taken" class="form-check-input" type="radio" name="status_taken" value="TAKEN" checked> 
                        <label class="form-check-label" for="radio-taken"> TAKEN</label> </div>

                     <div class="form-check mr-3 mt-2 sm:mt-0"> <input id="radio-untaken" class="form-check-input" type="radio" name="status_taken" value="UNTAKEN"> 
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
        <button type="button" id="closemodalpayment" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
        <button type="submit" class="btn btn-primary w-32">Apply</button>
    </div>
<?php }elseif($_GET['menu'] == 'cari_invoice'){ 
    $customer_data = $_POST['customer_data'];
    ?>
    <select id="invoice_data" onchange="pilihinv()" data-placeholder="Select Invoice" class="tom-select w-full colour" style="z-index: 99999;">
        <option></option>
        <?php 
            $queryinv = mysqli_query($conn,"SELECT * from Invoice WHERE Cust_ID='$customer_data' AND Status_Payment='N' ");
            while($datainv = mysqli_fetch_assoc($queryinv)){
        ?>
            <option value="<?php echo $datainv['Inv_Number'] ?>###<?php echo $datainv['Payment_Amount'] ?>">INV-<?php echo $datainv['Inv_Number'] ?> &nbsp; Rp <?php echo number_format($datainv['Payment_Amount'] ,0,",",".")?></option>
        <?php } ?>
     </select> 
     <script type="text/javascript">
        $('#invoice_data').selectize();
     </script>
<?php } elseif($_GET['menu'] == 'savepayment'){ 

    array(8) { ["customer"]=> string(46) "2###Mustafa Kemal###Jl Bekasi###08812 8282 222" ["amountz"]=> array(2) { [0]=> string(6) "240300" [1]=> string(6) "255600" } ["invoice"]=> array(2) { [0]=> string(7) "2200002" [1]=> string(7) "2200001" } ["totalpay"]=> string(6) "495900" ["payment_method"]=> string(28) "horizontal-radio-chris-evans" ["status_taken"]=> string(28) "horizontal-radio-chris-evans" ["payer_name"]=> string(11) "rafi aldian" ["note"]=> string(7) "notenya" } 


    var_dump($_POST);
    exit();
}