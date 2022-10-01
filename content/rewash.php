            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <h2 class="intro-y text-lg font-medium mt-5">
                        Rewash
                    </h2>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
                            <div class="flex w-full sm:w-auto">
                                <div class="w-48 relative text-slate-500">
                                    <input type="text" id="inputcari" class="form-control w-48 box pr-10" placeholder="Search by invoice...">
                                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
                                </div>
                                <select class="form-select box ml-2" id="status" onchange="gantistatus()">
                                    <option value="ALL">All</option>
                                
                                </select>
                            </div>
                            <div class="hidden xl:block mx-auto text-slate-500">&nbsp;</div>
       
                        </div>
                        <!-- BEGIN: Data List -->
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <table class="table table-report -mt-2">
                                <thead>
                                    <tr>
                                        
                                        <th class="whitespace-nowrap">INVOICE</th>
                                        <th class="whitespace-nowrap">BUYER NAME</th>
                                        <th class="whitespace-nowrap" style="width: 220px;">FINISH</th>
                                        <th class="whitespace-nowrap">STATUS</th>
                                        <th class="text-right whitespace-nowrap" style="width: 190px;">
                                            <div class="pr-16">PAYMENT</div>
                                        </th>
                                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="hasilcari">
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- END: Data List -->
                        
                    </div>
                    <!-- BEGIN: Delete Confirmation Modal -->
                    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="p-5 text-center">
                                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                                        <div class="text-3xl mt-5">Are you sure?</div>
                                        <div class="text-slate-500 mt-2">
                                            Do you really want to delete these records? 
                                            <br>
                                            This process cannot be undone.
                                        </div>
                                    </div>
                                    <div class="px-5 pb-8 text-center">
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                        <button type="button" class="btn btn-danger w-24">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Delete Confirmation Modal -->
                    <div id="payment-modal" class="modal" tabindex="-1" aria-hidden="true">
                        
                        <div class="modal-dialog" style="width:50%">
                            <form method="POST" id="savepayment" action="#">
                            <div class="modal-content" id="hasilpaymentpop">
                                
                            </div>
                            </form>
                        </div>
                        
                    </div>
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
                $(document).ready(function(e) {

                    setTimeout(function(){ myFunction(); }, 300);
                    var timeout;
                    var delay = 600;   // 2 seconds

                    $('#inputcari').keyup(function(e) {
                        //$('#status').html("User started typing!");
                        if(timeout) {
                            clearTimeout(timeout);
                        }
                        timeout = setTimeout(function() {
                            myFunction();
                        }, delay);
                    });

                    function myFunction() {

                        var keyword     = document.getElementById('inputcari').value;
                        var status      = document.getElementById('status').value;
                        $.ajax({
                            url:'function/transaksi?menu=carirewash',
                            type:'POST',
                            dataType:'html',
                            data:{
                              keyword: keyword,
                              status: status,
                            },
                            success:function (response) {
                                $('#hasilcari').html(response);
                            },

                        })
                    }
                });

                

                function taken(data){
                    var doc = prompt("Please enter Taken Name",
                        "");
                   
                    if (doc != null) {
                        $.ajax({
                            url:'function/transaksi?menu=simpantaken',
                            type:'POST',
                            dataType:'html',
                            data:{
                              doc: doc,
                              data: data,
                            },
                            success:function (response) {
                                console.log("success");
                                document.getElementById('success-additem').click();
                                setTimeout(function() { window.location.href = 'app?p=rewash'; }, 1500);
                            },

                        })
                    }
                }

                
            </script>