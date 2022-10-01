            <?php 
            $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='$_GET[invoice]'")); 
            ?>
            <style type="text/css">
                input[type=checkbox]
                {
                  /* Double-sized Checkboxes */
                  -ms-transform: scale(1.3); /* IE */
                  -moz-transform: scale(1.3); /* FF */
                  -webkit-transform: scale(1.3); /* Safari and Chrome */
                  -o-transform: scale(1.3); /* Opera */
                  transform: scale(1.3);
                  padding: 10px;
                }

                /* Might want to wrap a span around your checkbox text */
                .checkboxtext
                {
                  /* Checkbox text */
                  font-size: 110%;
                  display: inline;
                }
            </style>
            <div class="wrapper-box">
               
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            New Rewash Transaction | #INV-<?php echo $data['Inv_Number'] ?> | <?php echo $data['Cust_Nama'] ?>
                        </h2>
                        
                    </div>
                    <!-- BEGIN: Transaction Details -->
                    <form method="POST" action="function/transaksi_item?menu=savetransaksirewash" id="simpantransaksi">
                    <div class="intro-y grid grid-cols-12 gap-5 mt-5">
                        
                        <div class="col-span-12 lg:col-span-8">
                            <div class="box p-5 rounded-md">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Item(s) Details</div>
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
                                                <th class="whitespace-nowrap text-center" style="width:150px">REWASH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $queryitem = mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='$data[Inv_Number]'");
                                            while($dataitem=mysqli_fetch_assoc($queryitem)){
                                            ?>
                                            <tr>
                                                <td><?php echo $dataitem['Item_No'] ?>
                                                    
                                                </td>
                                                <td>
                                                    <?php echo $dataitem['Deskripsi'] ?>
                                                </td>
                                               
                                                <td class="text-right"><input type="text" class="form-control" style="width: 50px;" name="QTY[]" value="<?php echo $dataitem['Qty'] ?>"></td>
                                                <td class="text-right">Rp <?php echo number_format($dataitem['Total_Price'] ,0,",",".")?></td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="Inv_Item_No[]" value="<?php echo $dataitem['Inv_Item_No'] ?>">
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
                        <div class="col-span-12 lg:col-span-4">
                            
                                <input type="hidden" name="Inv_Number" value="<?php echo $data['Inv_Number'] ?>">
                                <div class="box p-5">
                                    <div style="width: 100%;">
                                        <div class="text-slate-500">Ready Date</div>
                                        <div class="mt-1">
                                            <input type="date" name="Inv_Tg_Selesai" class=" form-control block mx-auto" onchange="gantitgl()" data-single-mode="true" required> 
                                        </div>
                                        
                                    </div> 
                                    <div class="mt-2" style="width: 100%;">
                                        <div class="text-slate-500">Note Rewash</div>
                                        <div class="mt-1">
                                            <textarea id="Note" required name="Note" class="form-control" style="width: 100%;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex mt-5">
                                    <a href="app?p=transactions" class="btn w-40 border-slate-300 dark:border-darkmode-400 text-slate-500">Cancel Transaction</a>
                                    <button class="btn btn-primary w-40 shadow-md ml-auto">Save Transaction</button>
                                </div>
                            
                            </div>
                        </div>
                        
                    </div>
                    </form>
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
                     <!-- END: Modal Content --> 
            </div>
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

                function gantitgl(){
                    document.getElementById('Note').focus();
                }

                var frm3 = $('#simpantransaksi');
                frm3.submit(function (e) {
                  e.preventDefault(e);

                  var formData = new FormData(this);

                  $.ajax({
                    async: true,
                    type: frm3.attr('method'),
                    url: frm3.attr('action'),
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,

                    success: function (data) {
                      if(data=='PILIHCUSTOMER'){
                        alert('Please select customer before save transaction');
                      }else{
                          console.log("success");
                          document.getElementById('success-additem').click();
                          setTimeout(function() { window.location.href = 'app?p=rewash'; }, 1500);
                      }
                      
                    },
                    error: function(request, status, error) {
                      console.log("error")
                    }
                  });
                });
            </script>