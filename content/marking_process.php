         
            <div class="wrapper-box">
               
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            Marking Process
                        </h2>
                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            <button class="btn btn-primary shadow-md mr-2"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print Marking Tag</button>
                            
                        </div>
                    </div>
                    <!-- BEGIN: Transaction Details -->
                    <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                            
                            <div class="box p-5 rounded-md ">
                                <div class="font-medium text-base truncate mb-2">INVOICE DATE</div>
                                <input type="date" name="tgl" id="tgl" class="form-control" onchange="getdata()">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    
                                    
                                </div>
                                <div id="hasilnya">
                                    
                                </div>
                                            
                                
                            </div>
                           
                        </div>
                        <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
                            <div class="box p-5 rounded-md">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Order Details</div>
                                    <!-- <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Notes </a> -->
                                   
                                    
                                </div>
                                
                                
                                <div class="overflow-auto lg:overflow-visible -mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="whitespace-nowrap" style="width:40px">No</th>
                                                <th class="whitespace-nowrap !py-5">Item(s) Description</th>
                                              
                                                <th class="whitespace-nowrap text-right">Qty</th>
                                                <th class="whitespace-nowrap text-right">Total</th>
                                                <th class="whitespace-nowrap text-center" style="width:150px">PIC</th>
                                            </tr>
                                        </thead>
                                        <tbody id="isidetail">
                                            
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
                     <!-- END: Modal Content --> 
            </div>
            <?php include 'appjs.php'; ?>
            <script type="text/javascript">
                
               function getdata(){
                    var tgl     = document.getElementById('tgl').value;
                    $.ajax({
                        url:'function/marking?menu=data',
                        type:'POST',
                        dataType:'html',
                        data:{
                          tgl: tgl,
                        },
                        success:function (response) {
                            $('#hasilnya').html(response);
                        },

                    })
                }
                function isidetail(data){
                    $.ajax({
                        url:'function/marking?menu=detail',
                        type:'POST',
                        dataType:'html',
                        data:{
                          data: data,
                        },
                        success:function (response) {
                            $('#isidetail').html(response);
                        },

                    })
                }
                function ubahnote(data){
                    const myArray   = data.split("-");
                    var data        = document.getElementById('Item_Note-'+myArray[0]).value;
                    var inv         = myArray[1];
                    var id          = myArray[0];
                    $.ajax({
                        url:'function/marking?menu=ubahnote',
                        type:'POST',
                        dataType:'html',
                        data:{
                          data: data,
                          id: id
                        },
                        success:function (response) {
                            isidetail(inv);
                        },

                    })
                }

            </script>