            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Master Data - Colour
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-colour-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Colour</button>
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Colour Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="hasil">
                                    
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
                <div id="new-colour-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="create" action="function/colours?menu=create" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    New Colour
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="pos-form-1" class="form-label">Name</label>
                                    <input id="pos-form-1" name="Colour_Name" type="text" class="form-control flex-1" placeholder="Colour name">
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
                <div id="edit-colour-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="edit" action="function/colours?menu=edit" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    Edit Colour
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="edit-name" class="form-label">Name</label>
                                    <input type="hidden" id="edit-id" name="Colour_ID">
                                    <input id="edit-name" name="Colour_Name" type="text" class="form-control flex-1" placeholder="Customer name">
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
                            url :"function/colours?menu=data",
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

                setTimeout(function(){ 
                    var buttons = document.getElementsByClassName("buttons-excel"),
                        len = buttons !== null ? buttons.length : 0,
                        i = 0;
                    for(i; i < len; i++) {
                        buttons[i].className += " btn btn-primary mr-1 mb-2"; 
                    }

                    $('.buttons-excel span').text('Export Data - Excel');

                }, 500);

                function btnEdit(id) {
                    $.ajax({
                        url : "function/colours?menu=ajax",
                        type: "post",
                        data: "Colour_ID="+id,
                            success: function(data) { // Jika berhasil
                                var json = data,
                                obj = JSON.parse(json);
                                $('#edit-id').val(obj.Colour_ID);
                                $('#edit-name').val(obj.Colour_Name);
                            }
                    });
                }    
                function btnDelete(id) {
                    location.href = "function/colours?menu=delete&id="+id;
                }    
            </script>

            