            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Payment
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-customer-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Payment</button>
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Payer</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Note</th>
                                        <th>Staff</th>
                                        <th width="125px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="hasil">
                                    
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
               
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

                
            </script>

            