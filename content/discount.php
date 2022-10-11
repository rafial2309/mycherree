            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Voucher Discount Data
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-discount-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Discount</button>
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <button class="btn btn-primary mr-1 mb-2" onclick="btnExcel()">Export Data - Excel</button>
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Discount Name</th>
                                        <th>Discount Type</th>
                                        <th>Persentase</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="hasil">
                                    
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
                <div id="new-discount-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="create" action="function/discounts?menu=create" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    New Discount
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="pos-form-1" class="form-label">Name</label>
                                    <input id="pos-form-1" name="Discount_Nama" type="text" class="form-control flex-1" placeholder="Discount Name">
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-2" class="form-label">Discount Type</label>
                                    <select id="pos-form-2" class="form-control" name="Discount_Type">
                                        <option value="Promo">Promo</option>
                                        <option value="Membership">Membership</option>
                                    </select>
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-3" class="form-label">Persentase</label>
                                    <input id="pos-form-3" name="Persentase" type="text" class="form-control flex-1" placeholder="Persentase">
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
                <div id="edit-discount-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="edit" action="function/discounts?menu=edit" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    Edit Colour
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="edit-name" class="form-label">Name</label>
                                    <input type="hidden" id="edit-id" name="Discount_No">
                                    <input id="edit-name" name="Discount_Nama" type="text" class="form-control flex-1" placeholder="Customer name">
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-type" class="form-label">Discount Type</label>
                                    <select id="edit-type" class="form-control" name="Discount_Type">
                                        <option value="Promo">Promo</option>
                                        <option value="Membership">Membership</option>
                                    </select>
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-persentase" class="form-label">Persentase</label>
                                    <input id="edit-persentase" name="Persentase" type="text" class="form-control flex-1" placeholder="Persentase">
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
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#example').DataTable( {
                        "ajax":{
                            url :"function/discounts?menu=data",
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

                    location.href='function/report?type=discount&search='+search;
                }

                function btnEdit(id) {
                    $.ajax({
                        url : "function/discounts?menu=ajax",
                        type: "post",
                        data: "Discount_No="+id,
                            success: function(data) { // Jika berhasil
                                var json = data,
                                obj = JSON.parse(json);
                                $('#edit-id').val(obj.Discount_No);
                                $('#edit-name').val(obj.Discount_Nama);
                                $('#edit-type').val(obj.Discount_Type);
                                $('#edit-persentase').val(obj.Persentase);
                            }
                    });
                }    
                function btnDelete(id) {
                    location.href = "function/discounts?menu=delete&id="+id;
                }    
            </script>

            