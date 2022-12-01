    <?php 
    $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Customer WHERE Cust_No='$_GET[Cust_No]'")); 
        if (isset($data['Cust_No'])) {
    ?>
    <style type="text/css">
        .dt-button{
            background: #ff5070;color: white;padding: 8px;border-radius: 6px;
        }
    </style>
            <div class="wrapper-box">
               
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            <?php echo $data['Cust_Nama'] ?>
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-deposit-modal"><i data-lucide='wallet' class='w-5 h-5'></i> &nbsp; New Deposit Customer</button>

                        <button class=" btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#use-deposit-modal"><i data-lucide='wallet' class='w-5 h-5'></i> &nbsp; Use Deposit</button>
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
                                <br>
                                <hr>
                                <?php
                                $totalcredit = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(nilai) as total from Customer_Deposit where Cust_No='$_GET[Cust_No]' and Jenis='CREDIT (+)'"));
                                $totaldebit = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(nilai) as total from Customer_Deposit where Cust_No='$_GET[Cust_No]' and Jenis='DEBIT (-)'"));

                                $total = intval($totalcredit["total"]) - intval($totaldebit["total"]);
                                ?>
                                <div class="pb-5 mt-5 text-center">
                                    <div class="font-medium text-base truncate">Balance Deposit <br> Rp <?php echo number_format($total,0,',','.'); ?></div>
                                </div>
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

                            <div class="box p-5 rounded-md mt-5">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Deposit History</div>
                                    <!-- <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Notes </a> -->
                                   
                                    
                                </div>
                              
                                
                                <div class="overflow-auto lg:overflow-visible -mt-3">
                                    <table id="example2" class="display" style="width:100%">
                                        <thead>
                                            <th style="width:30px">No</th>
                                            <th>Tanggal</th>
                                            <th>Nilai</th>
                                            <th>Transaksi</th>
                                            <th>Note</th>
                                            <th>Sisa Deposit</th>
                                        </thead>
                                        <tbody id="hasil2">
                                            
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

                    <div id="new-deposit-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="create" action="function/customers?menu=createdeposit" method="post">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">
                                        New Deposit Customer
                                    </h2>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <input type="hidden" name="Cust_No" value="<?php echo $_GET['Cust_No'] ?>">
                                    <div class="col-span-12">
                                        <label for="pos-form-3" class="form-label">Total Deposit</label>
                                        <input type="text" name="Total_Deposit" id="pos-form-3" class="form-control flex-1 uang" placeholder="50.000">
                                    </div>
                                    <div class="col-span-12">
                                        <label for="pos-form-1" class="form-label">Note</label>
                                        <input id="pos-form-1" name="Note" type="text" class="form-control flex-1" placeholder="Note">
                                    </div>
                                </div>
                                <div class="modal-footer text-right">
                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                    <button type="submit" class="btn btn-primary w-32">Save</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="use-deposit-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="create" action="function/customers?menu=usedeposit" method="post">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">
                                        Use Deposit Customer
                                    </h2>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <input type="hidden" name="Cust_No" value="<?php echo $_GET['Cust_No'] ?>">
                                    <div class="col-span-12">
                                        <label for="pos-form-3" class="form-label">Total Use Deposit</label>
                                        <input type="text" name="Total_Deposit_2" id="pos-form-3" class="form-control flex-1 uang" placeholder="50.000">
                                    </div>
                                    <div class="col-span-12">
                                        <label for="pos-form-1" class="form-label">Note</label>
                                        <input id="pos-form-1" name="Note_2" type="text" class="form-control flex-1" placeholder="Note">
                                    </div>
                                </div>
                                <div class="modal-footer text-right">
                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                    <button type="submit" class="btn btn-primary w-32">Save</button>
                                </div>
                                </form>
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

                $(document).ready(function() {
                    $('#example2').DataTable( {
                        "ajax":{
                            url :"function/customers?menu=datadeposit&Cust_No=<?php echo $_GET['Cust_No'] ?>",
                            type: "post",
                            error: function(){
                                $(".dataku-error").html("");
                                $("#dataku").append('<tbody class="dataku-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
                                $("#dataku-error-proses").css("display","none");
                            }
                        },
                        order: [[0, 'desc']],
                        dom: 'Bfrtip',
                        "searching": false,
                        "processing": true,
                        "serverSide": true,
                        buttons: ['excelHtml5']

                    } );     
                } );

                $(document).ready(function(){
                    // Format mata uang.
                    $( '.uang' ).mask('000.000.000', {reverse: true});
                })

                function commaSeparateNumber(val) {
                    while (/(\d+)(\d{3})/.test(val.toString())) {
                        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
                    }

                    return val;
                }
          </script>