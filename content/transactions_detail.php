    <?php 
    $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='$_GET[invoice]'")); 
        if (isset($data['Inv_Number'])) {
    ?>
            <div class="wrapper-box">
               
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            Transaction Details
                        </h2>
                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            <button class="btn btn-primary shadow-md mr-2"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print Invoice</button>
                            <button class="btn btn-primary shadow-md mr-2" onclick="editTrans()"><i data-lucide="edit" class="w-4 h-4 mr-2"></i> Edit</button>
                        </div>
                    </div>
                    <!-- BEGIN: Transaction Details -->
                    <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                            <div class="box p-5 rounded-md">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Transaction Details</div>
                                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#change-stat-modal" onclick="changestat()" class="flex items-center ml-auto text-primary"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Change Status </a>
                                </div>
                                <?php if ($data['Status_Inv']=='C') { ?>
                                    <button class="btn btn-outline-danger w-full inline-block mr-1 mb-4">STATUS CANCELED</button>
                                <?php } ?>
                                

                                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Invoice: <a href="" class="underline decoration-dotted ml-1">#INV-<?php echo $data['Inv_Number'] ?></a> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Transaction Date: <?php echo date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Ready Date: <?php echo date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])); ?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i> Payment Status: <?php if ($data['Status_Payment']=='N') { echo '<span class="bg-warning/20 text-warning rounded px-2 ml-1">UNPAID</span>'; }else{ echo '<span class="bg-success/20 text-success rounded px-2 ml-1">PAID</span>'; }?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i> Taken Status: <?php if ($data['Status_Taken']=='N') { echo '<span class="bg-warning/20 text-warning rounded px-2 ml-1">UNTAKEN</span>'; }else{ echo '<span class="bg-success/20 text-success rounded px-2 ml-1">'.$data['Status_Taken'].'</span>';}?> </div>

                            </div>
                            <div class="box p-5 rounded-md mt-5">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Customer Details</div>
                                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#change-cust-modal" class="flex items-center ml-auto text-primary"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Change Customer </a>
                                </div>
                                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Name: <a href="" class="underline decoration-dotted ml-1"><?php echo $data['Cust_Nama'] ?></a> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Phone Number: <?php echo $data['Cust_Telp'] ?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 mr-2"></i> Address: <?php echo $data['Cust_Alamat'] ?> </div>
                            </div>
                            <div class="box p-5 rounded-md mt-5">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Payment Details</div>
                                </div>
                                <div class="flex items-center">
                                    <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Payment Method: 
                                    <div class="ml-auto">
                                        <?php $cekpay = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Payment where Inv_Number='$data[Inv_Number]'")); ?>
                                        <?php if ($data['Status_Payment']=='N') { echo '<span class="bg-warning/20 text-warning rounded px-2 ml-1">UNPAID</span>'; }else{ echo '<span class="bg-success/20 text-success rounded px-2 ml-1">'.$cekpay['Payment_Type'].'</span>'; }?>
                                    </div>
                                </div>
                                <div class="flex items-center mt-3">
                                    <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i> Date 
                                    <div class="ml-auto"><?php if (isset($cekpay['Payment_Tgl'])) {
                                        echo date('d M Y H:i:s', strtotime($cekpay['Payment_Tgl']));
                                    } ?></div>
                                </div>
                                <div class="flex items-center mt-3">
                                    <i data-lucide="box" class="w-4 h-4 text-slate-500 mr-2"></i> Total Pcs: 
                                    <div class="ml-auto"><?php echo $data['Total_PCS'] ?> item(s)</div>
                                </div>

                                <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium">
                                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Total Payment: 
                                    <div class="ml-auto">Rp <?php echo number_format($data['Payment_Amount'] ,0,",",".")?></div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
                            <div class="box p-5 rounded-md">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Order Details</div>
                                    <!-- <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Notes </a> -->
                                   
                                    
                                </div>
                                <div class="font-medium text-base mb-5">Note: <span style="font-weight: normal;"><?php echo $data['Note'] ?></span></div>
                                <hr>
                                <div class="overflow-auto lg:overflow-visible -mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="whitespace-nowrap" style="width:40px">No</th>
                                                <th class="whitespace-nowrap !py-5">Item(s) Description</th>
                                              
                                                <th class="whitespace-nowrap text-right">Qty</th>
                                                <th class="whitespace-nowrap text-right">Total</th>
                                                <th class="whitespace-nowrap text-right" style="width:150px">CANCEL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $queryitem = mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='$data[Inv_Number]'");
                                            while($dataitem=mysqli_fetch_assoc($queryitem)){
                                            ?>
                                            <tr>
                                                <td><?php echo $dataitem['Item_No'] ?></td>
                                                <td>
                                                    <?php echo $dataitem['Deskripsi'] ?>
                                                </td>
                                               
                                                <td class="text-right"><?php echo $dataitem['Qty'] ?></td>
                                                <td class="text-right">Rp <?php echo number_format($dataitem['Total_Price'] ,0,",",".")?></td>
                                                <td class="text-right">
                                                    <?php

                                                    if ($data['Status_Payment']=='N' || $data['Status_Taken']=='N') {
                                                        if (strpos($dataitem['Deskripsi'], '(CANCEL)') !== false) {
                                                           
                                                        }else{
                                                    ?>
                                                    <button class="btn btn-danger shadow-md mr-2" onclick="cancelitem('<?php echo $dataitem['Inv_Item_No'] ?>')"><i data-lucide="x-circle" class="w-4 h-4 mr-2"></i> CANCEL</button>
                                                    <?php }
                                                    } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="4"><?php echo $dataitem['Item_Note'] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Transaction Details -->
                </div>
                <!-- END: Content -->

                <!-- END: Add Item Modal -->
                     <div class="text-center"> 
                        <a id="success-additem" href="javascript:;" style="opacity:0" data-tw-toggle="modal" data-tw-target="#success-modal-preview" class="btn btn-primary">-</a> 
                        <a id="danger-additem" href="javascript:;" style="opacity:0" data-tw-toggle="modal" data-tw-target="#danger-modal-preview" class="btn btn-danger">-</a> 
                     </div> <!-- END: Modal Toggle --> 
                     <!-- BEGIN: Modal Content --> 
                     <div id="success-modal-preview" class="modal" tabindex="-1" aria-hidden="true"> 
                        <div class="modal-dialog"> 
                            <div class="modal-content"> 
                                <div class="modal-body p-0"> 
                                    <div class="p-5 text-center"> 
                                        <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i> 
                                        <div class="text-3xl mt-5">Save Success!</div> 
                                        <div class="text-slate-500 mt-2">Data saved</div> 
                                    </div> 
                                    <div class="px-5 pb-8 text-center"> 
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                     </div> 
                     <div id="danger-modal-preview" class="modal" tabindex="-1" aria-hidden="true"> 
                        <div class="modal-dialog"> 
                            <div class="modal-content"> 
                                <div class="modal-body p-0"> 
                                    <div class="p-5 text-center"> 
                                        <i data-lucide="check-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                                        <div class="text-3xl mt-5">Delete Success!</div> 
                                        <div class="text-slate-500 mt-2">Item deleted.</div> 
                                    </div> 
                                    <div class="px-5 pb-8 text-center"> 
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                     </div> 


                    <div id="change-cust-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">
                                        Change Customer
                                    </h2>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12">
                                         <label class="form-label">Customers</label>
                                         <div class="mt-1">
                                             <select name="customer" id="customer" data-placeholder="Select Customers" class="tom-select w-full" onchange="cekcust()">
                                                <option>-- SELECT CUSTOMER --</option>
                                                <?php 
                                                    $querycust = mysqli_query($conn,"SELECT * from Customer WHERE Cust_Status='Y' order by Cust_Nama asc");
                                                    while($datacust = mysqli_fetch_assoc($querycust)){
                                                ?>
                                                    <option value="<?php echo $datacust['Cust_No'] ?>+<?php echo $datacust['Cust_Nama'] ?>"><?php echo $datacust['Cust_Nama'] ?></option>
                                                <?php } ?>
                                             </select> 
                                         </div>
                                    </div>
                                    <div class="col-span-12">
                                        <input type="text" name="telp" id="telp" class="form-control" placeholder="Input Phone">
                                    </div>
                                    <div class="col-span-12">
                                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Input Address">
                                    </div>
                                    <div class="col-span-12">
                                        <button class="btn btn-outline-primary w-full inline-block mr-1 mb-2" id="hasilcekmember">-</button>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer text-right">
                                    <button type="button" id="closemodalcustomer" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                    <button type="button" onclick="updatechangecust()" class="btn btn-primary w-32">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="change-stat-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">
                                        Change Status Invoice
                                    </h2>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    
                                    <div class="col-span-12">
                                        <center> <strong style="font-size: 25px;">INV-<c id="invnum"></c></strong> </center>
                                        <input type="hidden" name="invoicedata" value="<?php echo $datainv['Inv_Number']; ?>">
                                    </div>

                                    <div class="col-span-12">
                                         <ul class="nav nav-boxed-tabs" role="tablist"> 
                                            <li id="example-3-tab" class="nav-item flex-1" role="presentation"> 
                                                <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-3" type="button" role="tab" aria-controls="example-tab-3" aria-selected="true" > Status Payment </button> 
                                            </li> 
                                            <li id="example-4-tab" class="nav-item flex-1" role="presentation"> 
                                                <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-4" type="button" role="tab" aria-controls="example-tab-4" aria-selected="false" > Status Taken </button> 
                                            </li> 
                                        </ul> 
                                        <div class="tab-content mt-5"> 
                                            <div id="example-tab-3" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-3-tab"> 
                                                <div class="col-span-12">
                                                     <div class="mt-7 mb-7"> 
                                                         <div class="flex flex-col sm:flex-row mt-3">

                                                            <?php 
                                                            if ($data['Status_Payment']=='N') { 
                                                                $disablepay = 'disabled';
                                                                $checkedpay = '';
                                                            }else{
                                                                $disablepay = '';
                                                                $checkedpay = 'checked';
                                                            }

                                                            ?>

                                                             <div class="form-check mr-3"> <input id="radio-paid" class="form-check-input" type="radio" name="status_pay" value="PAID" <?php echo $disablepay; ?> <?php echo $checkedpay; ?>> 
                                                                <label class="form-check-label" for="radio-taken"> PAID</label> </div>

                                                             <div class="form-check mr-3 mt-2 sm:mt-0"> <input id="radio-unpaid" class="form-check-input" type="radio" name="status_pay" value="UNPAID"> 
                                                                <label class="form-check-label" for="radio-untaken"> UNPAID</label> </div>

                                                         </div>
                                                     </div>
                                                </div>
                                                <div class="modal-footer text-right mt-5">
                                                    <button type="button" id="closemodalcustomer" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                                    <button type="button" onclick="updatechangestatpay()" class="btn btn-primary w-32">Update</button>
                                                </div>

                                            </div> 

                                            <div id="example-tab-4" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-4-tab"> 

                                                <div class="col-span-6">
                                                     <div class="mt-7 mb-7">
                                                         <div class="flex flex-col sm:flex-row mt-3">

                                                            <?php 
                                                            if ($data['Status_Taken']=='N') { 
                                                                $disabletaken = 'disabled';
                                                                $checkedtaken = '';
                                                            }else{
                                                                $disabletaken = '';
                                                                $checkedtaken = 'checked';
                                                            }

                                                            ?>

                                                             <div class="form-check mr-3"> <input id="radio-taken" class="form-check-input" type="radio" name="status_taken" value="TAKEN" <?php echo $disabletaken; ?> <?php echo $checkedtaken; ?>> 
                                                                <label class="form-check-label" for="radio-taken"> TAKEN</label> </div>

                                                             <div class="form-check mr-3 mt-2 sm:mt-0"> <input id="radio-untaken" class="form-check-input" type="radio" name="status_taken" value="UNTAKEN"> 
                                                                <label class="form-check-label" for="radio-untaken"> UNTAKEN</label> </div>

                                                         </div>
                                                     </div>
                                                </div>
                                                <div class="col-span-6">
                                                    &nbsp;
                                                </div>
                                                <div class="col-span-12">
                                                    <input type="text" name="payer_name" id="payer_name" class="form-control" placeholder="Taken Name" value="<?php if ($data['Status_Taken']!='N') { echo $data['Status_Taken']; }  ?>" required>
                                                </div>
                                                <div class="modal-footer text-right mt-5">
                                                    <button type="button" id="closemodalcustomer" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                                    <button type="button" onclick="updatechangestattaken()" class="btn btn-primary w-32">Update</button>
                                                </div>

                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    


                                    
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                     <!-- END: Modal Content --> 
            </div>
    <?php } ?>
            <?php include 'appjs.php'; ?>
            <script type="text/javascript">
                
                function cancelitem(data){
                    let text = "Are you sure? (CANCEL ITEM)";
                    if (confirm(text) == true) {
                        $.ajax({
                            type:'POST',
                            url:'function/transaksi?menu=cancel',
                            data:'id='+data,
                            success: function(data) { // Jika berhasil
                                if (data=='Y') {
                                    document.getElementById('success-additem').click();
                                    setTimeout(function() { window.location.reload(); }, 1500);
                                }
                            }
                        });
                    } else {
                        
                    }
                }

                function cekcust(){
                    var id = document.getElementById('customer').value;
                    $.ajax({
                        url:'function/transaksi_item?menu=cekcust',
                        type:'POST',
                        data:'id='+id,
                        dataType:'html',
                        success:function (response) {
                            var json = response,
                            obj = JSON.parse(json);
                            $('#telp').val(obj.Cust_Telp);
                            $('#alamat').val(obj.Cust_Alamat);
                            document.getElementById('hasilcekmember').innerHTML = obj.member;
                        },

                    })
                }

                function updatechangecust(){
                    var id           = document.getElementById('customer').value;
                    var Cust_Telp    = document.getElementById('telp').value;
                    var Cust_Alamat  = document.getElementById('alamat').value;
                    var Cust_No_Data = id.split("+");
                    var invoice      = '<?php echo $_GET['invoice']; ?>';
                    $.ajax({
                        url:'function/transaksi?menu=updatecust',
                        type:'POST',
                        data:{
                          id: id,
                          Cust_Telp: Cust_Telp,
                          Cust_Alamat: Cust_Alamat,
                          invoice: invoice,
                        },
                        success:function (response) {
                            if (response=='Y') {
                                document.getElementById('success-additem').click();
                                setTimeout(function() { window.location.reload(); }, 1500);
                            }
                        },

                    })
                }

                function changestat(){
                    document.getElementById('invnum').innerHTML = '<?php echo $_GET['invoice']; ?>';
                }

                function editTrans() {
                    let id = '<?= $data['Inv_No']?>';
                    location.href='app?p=edit-transaction&id='+id;
                }

                function updatechangestatpay(){
                    var unpaid = document.getElementById('radio-unpaid').value;
                    var invoice = '<?php echo $_GET['invoice']; ?>';
                    if (unpaid=='UNPAID') {
                        $.ajax({
                            url:'function/transaksi?menu=updatestatus',
                            type:'POST',
                            data:{
                              status: 'pay',
                              paid: 'N',
                              invoice: invoice,
                            },
                            success:function (response) {
                                if (response=='Y') {
                                    document.getElementById('success-additem').click();
                                    setTimeout(function() { window.location.reload(); }, 1500);
                                }
                            },

                        })
                    }
                }
                function updatechangestattaken(){
                    var name    = document.getElementById('payer_name').value;
                    var invoice = '<?php echo $_GET['invoice']; ?>';

                    if (document.getElementById('radio-taken').checked) {

                        $.ajax({
                            url:'function/transaksi?menu=updatestatus',
                            type:'POST',
                            data:{
                              status: 'taken',
                              taken: 'Y',
                              name: name,
                              invoice: invoice,
                            },
                            success:function (response) {
                                if (response=='Y') {
                                    document.getElementById('success-additem').click();
                                    setTimeout(function() { window.location.reload(); }, 1500);
                                }
                            },

                        })

                    }else{
                        $.ajax({
                            url:'function/transaksi?menu=updatestatus',
                            type:'POST',
                            data:{
                              status: 'taken',
                              taken: 'N',
                              name: name,
                              invoice: invoice,
                            },
                            success:function (response) {
                                if (response=='Y') {
                                    document.getElementById('success-additem').click();
                                    setTimeout(function() { window.location.reload(); }, 1500);
                                }
                            },

                        })
                    }

                    
                }
            </script>