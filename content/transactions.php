            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <h2 class="intro-y text-lg font-medium mt-5">
                        Transaction History
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
                                    <option value="UNPAID">Unpaid</option>
                                    <option value="PAID">Paid</option>
                                    <option value="UNTAKEN">UnTaken</option>
                                    <option value="TAKEN">Taken</option>
                                </select>
                            </div>
                            <div class="hidden xl:block mx-auto text-slate-500">&nbsp;</div>
                            <div class="w-full xl:w-auto flex items-center mt-3 xl:mt-0">
                                
                                <button onclick="window.location='app?p=newtransaction'" class="btn btn-primary shadow-md mr-2"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> NEW TRANSACTION </button>

                                <button data-tw-toggle="modal" data-tw-target="#payment-modal" onclick="gopayment('MULTI')" class="btn btn-primary shadow-md mr-2"> <i data-lucide="credit-card" class="w-4 h-4 mr-2"></i> PAYMENT </button>
                               
                            </div>
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
                                    <?php
                                        $query = mysqli_query($conn,"SELECT * from Invoice order by Inv_No DESC LIMIT 20");
                                        while($data=mysqli_fetch_assoc($query)){
                                    ?>
                                    <tr class="intro-x">
                                        
                                        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap" style="font-size: 17px;">#INV-<?php echo $data['Inv_Number'] ?></a> </td>
                                        <td class="w-40">
                                            <a href="" class="font-medium whitespace-nowrap"><?php echo $data['Cust_Nama'] ?></a> 
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo $data['Cust_Alamat'] ?></div>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo $data['Cust_Telp'] ?></div>
                                        </td>
                                        <td>
                                            <div class="pr-16"><?php echo date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?></div>
                                            <div class="pr-16"><?php echo date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])); ?></div>
                                        </td>
                                        <td>
                                            <?php if ($data['Status_Payment']=='N') { ?>
                                                <div class="flex items-center whitespace-nowrap text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> UNPAID </div>
                                                
                                            <?php }else{ 
                                                $cekpay = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Payment where Inv_Number='$data[Inv_Number]'"));
                                                ?>
                                                <div class="flex items-center whitespace-nowrap text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> PAID </div>
                                                <div class="whitespace-nowrap"><?php echo $cekpay['Payment_Type'] ?></div>
                                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo date('d M Y H:i:s', strtotime($cekpay['Payment_Tgl'])); ?>
                                                    <br>
                                                    <?php if ($data['Status_Taken']=='N') {
                                                        echo "<b class='text-danger'>UNTAKEN</b>";
                                                    }else{
                                                        echo "<b class='text-success'>".$data['Status_Taken']."</b>"; 
                                                    }?>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td class="w-40 text-right">
                                            <div class="pr-16">Rp <?php echo number_format($data['Payment_Amount'] ,0,",",".")?></div>
                                        </td>
                                        <td class="table-report__action">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center text-primary whitespace-nowrap mr-5" href="app?p=transactions_detail&invoice=<?php echo $data['Inv_Number'] ?>"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> View Details </a>
                                                
                                                <div class="dropdown"> 
                                                    <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown"><i data-lucide="send" class="w-4 h-4 mr-2"></i> Process</button> 
                                                    <div class="dropdown-menu w-40"> 
                                                        <ul class="dropdown-content"> 
                                                            <li> <div class="dropdown-header">Process</div> </li> 
                                                            <li> <hr class="dropdown-divider"> </li> 
                                                            <li> <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print Invoice </a> </li> 
                                                            <li> <a href="javascript:;" onclick="gopayment('<?php echo $data['Inv_Number']  ?>###<?php echo $data['Payment_Amount']  ?>')" data-tw-toggle="modal" data-tw-target="#payment-modal" class="dropdown-item"> <i data-lucide="credit-card" class="w-4 h-4 mr-2"></i> Payment </a> 
                                                            </li> 
                                                            <li> <a href="" class="dropdown-item"> <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i> Cancel </a> </li> 
                                                            <li> <a href="" class="dropdown-item"> <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i> Rewash </a> </li> 
                                                            
                                                        </ul> 
                                                    </div> 
                                                </div> 
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
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
                            <form method="POST" id="savepayment" action="function/transaksi_payment?menu=savepayment">
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
                            url:'function/transaksi?menu=cari',
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

                function gantistatus(){
                    var keyword     = document.getElementById('inputcari').value;
                    var status      = document.getElementById('status').value;
                    $.ajax({
                        url:'function/transaksi?menu=cari',
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
                function gopayment(data){
                    $.ajax({
                        url:'function/transaksi_payment?menu=tampilcust',
                        type:'POST',
                        data:{
                          data: data,
                        },
                        dataType:'html',
                        success:function (response) {
                            $('#hasilpaymentpop').html(response);
                        },

                    })
                }
                function ganticustpay(data){
                    var customer_data     = document.getElementById('customer_data').value;
                    var cust              = customer_data.split("###");
                    document.getElementById('cust_nama').innerHTML      = cust[1];
                    document.getElementById('cust_alamat').innerHTML    = cust[2];
                    document.getElementById('cust_telp').innerHTML      = cust[3];
                    if(data!='MULTI'){
                       pilihinv(data);
                    }else{
                        
                        $.ajax({
                            url:'function/transaksi_payment?menu=cari_invoice',
                            type:'POST',
                            dataType:'html',
                            data:{
                              customer_data: cust[0],
                            },
                            success:function (response) {
                                $('#hasilinvoice').html(response);
                                $('#isi_inv').html('');
                                document.getElementById("totalpay_data").value = '0';
                                document.getElementById("totalpay").innerHTML = '0';
                                jQuery('.datainv').remove();
                            },

                        })
                    }
                    
                }

                function pilihinv(data){
                    if (data=='MULTI') {
                        var invoice_data     = document.getElementById('invoice_data').value;
                    }else{
                        var invoice_data     = data;
                    }
                    
                    var inv              = invoice_data.split("###");
                    var payment          = inv[1].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                    var sudahada         = 'N';

                    $("input[name='invoice[]']").each(function() {
                        var valsiki = $(this).val().substring(0, 7);
                        if (valsiki==inv[0]) {
                            sudahada = 'Y';
                        }
                    });

                    if (sudahada=='Y') {
                        alert('INVOICE LISTED!')
                    }else{
                        if (inv[0]!='') {
                            document.getElementById("isi_inv").insertAdjacentHTML("beforeend",
                            "<div class='flex items-center mb-1 datainv'>&nbsp; INV-"+inv[0]+"<div class='ml-auto'>Rp "+payment+"</div><input type='hidden' name='invoice[]' value='"+inv[0]+"--"+inv[1]+"'></div>");
                        }
                        
                    }

                    var tot              = 0;
                    $("input[name='invoice[]']").each(function() {
                        var invdat = $(this).val().split("--");
                        tot = parseInt(tot) + parseInt(invdat[1]);
                    });
                    
                    document.getElementById("totalpay_data").value = tot;
                    document.getElementById("totalpay").innerHTML = tot.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                }

                var frm = $('#savepayment');
                frm.submit(function (e) {
                  e.preventDefault(e);

                  var formData = new FormData(this);

                  $.ajax({
                    async: true,
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,

                    success: function (data) {
                      console.log("success");
                      document.getElementById('closemodalpayment').click();
                      document.getElementById('success-additem').click();
                      setTimeout(function() { window.location.reload(); }, 1500);
                    },
                    error: function(request, status, error) {
                      console.log("error")
                    }
                  });
                });
            </script>