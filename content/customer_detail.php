    <?php 
    $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Customer WHERE Cust_No='$_GET[Cust_No]'")); 
        if (isset($data['Cust_No'])) {
    ?>
            <div class="wrapper-box">
               
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            <?php echo $data['Cust_Nama'] ?>
                        </h2>
                        
                    </div>
                    <!-- BEGIN: Transaction Details -->
                    <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                            
                            <div class="box p-5 rounded-md">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Customer Details</div>
                                    <!-- <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#change-cust-modal" class="flex items-center ml-auto text-primary"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Change Customer </a> -->
                                </div>
                                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Name: <a href="" class="underline decoration-dotted ml-1"><?php echo $data['Cust_Nama'] ?></a> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Phone Number: <?php echo $data['Cust_Telp'] ?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 mr-2"></i> Address: <?php echo $data['Cust_Alamat'] ?> </div>
                            </div>
                           
                           
                        </div>
                        <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
                            <div class="box p-5 rounded-md">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Transaction History</div>
                                    <!-- <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Notes </a> -->
                                   
                                    
                                </div>
                              
                                
                                <div class="overflow-auto lg:overflow-visible -mt-3">
                                    <table id="example" class="display" style="width:100%">
                                        <thead>
                                            <th style="width:30px">No</th>
                                            <th>Invoice</th>
                                            <th>Order</th>
                                            <th>Ready</th>
                                            <th>Customer</th>
                                            <th>Pcs</th>
                                            <th>Total</th>
                                            <th>Payment</th>
                                            <th>Taken</th>
                                        </thead>
                                        <tbody id="hasil">
                                            
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


            </div>
    <?php } ?>
            <?php include 'appjs.php'; ?>
          <script type="text/javascript">
              $(document).ready(function() {
                    $('#example').DataTable( {
                        "ajax":{
                            url :"function/customers?menu=datasingle&Cust_No=<?php echo $_GET['Cust_No'] ?>",
                            type: "post",
                            error: function(){
                                $(".dataku-error").html("");
                                $("#dataku").append('<tbody class="dataku-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
                                $("#dataku-error-proses").css("display","none");
                            }
                        },
                        order: [[0, 'desc']],
                        dom: 'Bfrtip',
                        "processing": true,
                        "serverSide": true,
                        buttons: [],   
                    } );     
                } );
          </script>