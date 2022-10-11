            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Master Data - Item
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-item-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Item</button>
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <button class="btn btn-primary mr-1 mb-2" onclick="btnExcel()">Export Data - Excel</button>
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Pcs</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="hasil">
                                    
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
                <div id="new-item-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="create" action="function/items?menu=create" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    New Item
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="pos-form-1" class="form-label">Name</label>
                                    <input id="pos-form-1" name="Item_Name" type="text" class="form-control flex-1" placeholder="Item Name">
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-2" class="form-label">Category</label>
                                    <input id="pos-form-1" name="Item_Category" type="text" class="form-control flex-1" placeholder="Item Category">
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-2" class="form-label">Price</label>
                                    <input id="pos-form-1" name="Item_Price" type="text" class="form-control flex-1 uang" placeholder="Item Price">
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-2" class="form-label">Pcs</label>
                                    <input id="pos-form-1" name="Item_Pcs" type="text" class="form-control flex-1 uang" placeholder="Item Pcs">
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
                <div id="edit-item-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="edit" action="function/items?menu=edit" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    Edit Customer
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="pos-form-1" class="form-label">Name</label>
                                    <input id="edit-id" name="Item_ID" type="hidden">
                                    <input id="edit-name" name="Item_Name" type="text" class="form-control flex-1" placeholder="Item Name">
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-category" class="form-label">Category</label>
                                    <input id="edit-category" name="Item_Category" type="text" class="form-control flex-1" placeholder="Item Category">
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-price" class="form-label">Price</label>
                                    <input id="edit-price" name="Item_Price" type="text" class="form-control flex-1 uang" placeholder="Item Price">
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-pcs" class="form-label">Pcs</label>
                                    <input id="edit-pcs" name="Item_Pcs" type="text" class="form-control flex-1 uang" placeholder="Item Pcs">
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
                            url :"function/items?menu=data",
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

                    location.href='function/report?type=item&search='+search;
                }

                function btnEdit(id) {
                    $.ajax({
                        url : "function/items?menu=ajax",
                        type: "post",
                        data: "Item_ID="+id,
                            success: function(data) { // Jika berhasil
                                var json = data,
                                obj = JSON.parse(json);
                                $('#edit-id').val(obj.Item_ID);
                                $('#edit-name').val(obj.Item_Name);
                                $('#edit-category').val(obj.Item_Category);
                                $('#edit-price').val(obj.Item_Price);
                                $('#edit-pcs').val(obj.Item_Pcs);
                            }
                    });
                }    
                function btnDelete(id) {
                    location.href = "function/items?menu=delete&id="+id;
                }  

                $(document).ready(function(){
                    // Format mata uang.
                    $( '.uang' ).mask('000.000.000', {reverse: true});
                })  

                function uploadpic(st) {
                    document.getElementById(st).submit();
                }
            </script>

            