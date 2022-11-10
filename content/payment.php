            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Payment
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#payment-modal" onclick="gopayment('MULTI')"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Payment</button>
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>PayID</th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Payer</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Note</th>
                                        <th>Staff</th>
                                    </tr>
                                </thead>
                                <tbody id="hasil">
                                    
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
                <div id="payment-modal" class="modal" tabindex="-1" aria-hidden="true">
                        
                    <div class="modal-dialog" style="width:50%">
                        <form method="POST" id="savepayment" action="#">
                        <div class="modal-content" id="hasilpaymentpop">
                            
                        </div>
                        </form>
                    </div>
                    
                </div>

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
                <!-- END: Content -->
            </div>
            <?php include 'appjs.php'; ?>
            <script src="plugin/datatable/jquery-3.5.1.js"></script>
            <script type="text/javascript" src="plugin/datatable/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="plugin/datatable/dataTables.buttons.min.js"></script>
            <script type="text/javascript" src="plugin/datatable/buttons.flash.min.js"></script>
            <script type="text/javascript" src="plugin/datatable/jszip.min.js"></script>
            <script type="text/javascript" src="plugin/datatable/buttons.html5.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#example').DataTable( {
                        "ajax":{
                            url :"function/payment?menu=data",
                            type: "post",
                            error: function(){
                                $(".dataku-error").html("");
                                $("#dataku").append('<tbody class="dataku-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
                                $("#dataku-error-proses").css("display","none");
                            }
                        },
                        dom: 'Bfrtip',
                        "processing": true,
                        "serverSide": true,
             
                          order: [[0, 'desc']],
                        buttons: [
                            'excel',
                        ],   
                    } );     
                } );

                function btnDelete(id){
                    let text = "Are you sure?";
                    if (confirm(text) == true) {
                        location.href="function/customers?menu=delete&id="+id;
                    } else {
                        text = "You canceled!";
                    }
                }
                function btnEdit(id){
                    $.ajax({
                        type:'POST',
                        url:'function/customers?menu=ajax',
                        data:'id='+id,
                        success: function(data) { // Jika berhasil
                            var json = data,
                            obj = JSON.parse(json);
                            $('#edit-id').val(obj.Cust_No);
                            $('#edit-nama').val(obj.Cust_Nama);
                            $('#edit-alamat').val(obj.Cust_Alamat);
                            $('#edit-telp').val(obj.Cust_Telp);
                            $('#edit-note').val(obj.Cust_Note);
                            $('#edit-tgl').val(obj.Cust_Tgl_Lahir);
                        }
                    });
                }

                setTimeout(function(){ 

                    var buttons = document.getElementsByClassName("buttons-excel"),
                        len = buttons !== null ? buttons.length : 0,
                        i = 0;
                    for(i; i < len; i++) {
                        buttons[i].className += " btn btn-primary mr-1 mb-2"; 
                    }

                    $('.buttons-excel span').text('Export Data - Excel');

                }, 500);

                
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
                        var valsiki = $(this).val().substring(0, 12);
                        if (valsiki==inv[0]) {
                            sudahada = 'Y';
                        }
                    });

                    if (sudahada=='Y') {
                        alert('INVOICE LISTED!')
                    }else{
                        if (inv[0]!='') {
                            document.getElementById("isi_inv").insertAdjacentHTML("beforeend",
                            "<div class='flex items-center mb-1 datainv'>&nbsp; "+inv[0]+"<div class='ml-auto'>Rp "+payment+"</div><input type='hidden' name='invoice[]' value='"+inv[0]+"--"+inv[1]+"'></div>");
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

                  var dd = JSON.stringify(Object.fromEntries(formData));
                  obj = JSON.parse(dd);
                  var jenismod = obj.jenismod;

                  if (jenismod=='PAYMENT') {
                    var url = 'function/transaksi_payment?menu=savepayment';
                  }else{
                    var url = 'function/transaksi_payment?menu=savetaken';
                  }

                  $.ajax({
                    async: true,
                    type: frm.attr('method'),
                    url: url,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,

                    success: function (data) {
                      if (data.search('Saldo Tidak Cukup') > -1) {
                          alert('Saldo Deposit Tidak Cukup!');
                          return false;
                      }
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

            