            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Customers
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-customer-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Customer</button>
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <button class="btn btn-primary mr-1 mb-2" onclick="btnExcel()">Export Data - Excel</button>
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Membership</th>
                                        <th>Join Date</th>
                                        <th>Note</th>
                                        <th width="125px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="hasil">
                                    
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
                <div id="new-customer-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="create" action="function/customers?menu=create" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    New Customer
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="pos-form-1" class="form-label">Name</label>
                                    <input id="pos-form-1" name="Cust_Nama" type="text" class="form-control flex-1" placeholder="Customer name">
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-2" class="form-label">No Telp</label>
                                    <input id="pos-form-2" type="text" name="Cust_Telp" class="form-control flex-1" placeholder="081234567890 ">
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-3" class="form-label">Tgl Lahir</label>
                                    <input id="pos-form-3" type="date" name="Cust_Tgl_Lahir" class="form-control flex-1">
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-4" class="form-label">Alamat</label>
                                    <textarea id="pos-form-4" name="Cust_Alamat" class="form-control flex-1" placeholder="Jl Mayjend Sungkono"></textarea>
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-5" class="form-label">Notes</label>
                                    <textarea id="pos-form-5" name="Cust_Note" class="form-control flex-1" placeholder="notes : Jangan dijemur terik matahari"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer text-right">
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                <button type="button" onclick="document.getElementById('create').submit()" class="btn btn-primary w-32">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="edit-customer-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="edit" action="function/customers?menu=edit" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    Edit Customer
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="edit-nama" class="form-label">Name</label>
                                    <input id="edit-id" type="hidden" name="Cust_No">
                                    <input id="edit-nama" type="text" name="Cust_Nama" class="form-control flex-1" placeholder="Customer name">
                                </div>
                                <div class="col-span-6">
                                    <label for="edit-telp" class="form-label">No Telp</label>
                                    <input id="edit-telp" type="text" name="Cust_Telp" class="form-control flex-1" placeholder="example : 081234567890 ">
                                </div>
                                <div class="col-span-6">
                                    <label for="edit-tgl" class="form-label">Tgl Lahir</label>
                                    <input id="edit-tgl" type="date" name="Cust_Tgl_Lahir" class="form-control flex-1">
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-alamat" class="form-label">Alamat</label>
                                    <textarea id="edit-alamat" name="Cust_Alamat" class="form-control flex-1" placeholder="Jl Mayjend Sungkono"></textarea>
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-note" class="form-label">Notes</label>
                                    <textarea id="edit-note" name="Cust_Note" class="form-control flex-1" placeholder="notes : Jangan dijemur terik matahari"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer text-right">
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                <button type="button" onclick="document.getElementById('edit').submit()" class="btn btn-primary w-32">Save</button>
                            </div>     
                            </form>
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
                            url :"function/customers?menu=data",
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
                        buttons: [],   
                    } );     
                } );

                function btnExcel () {
                    let search = $('#example_filter :input').val();

                    location.href='function/report?type=customer&search='+search;
                }

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

            </script>

            