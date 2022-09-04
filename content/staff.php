            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Staff Data
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-staff-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Staff</button>
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Staff ID</th>
                                        <th>Staff Name</th>
                                        <th>TTL</th>
                                        <th>Telp</th>
                                        <th>Address</th>
                                        <th>Access</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="hasil">
                                    
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
                <div id="new-staff-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="create" action="function/staffs?menu=create" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    New Item
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-12">
                                <div class="col-span-12">
                                    <label for="pos-form-1" class="form-label">Name</label>
                                    <input id="pos-form-1" name="Staff_Name" type="text" class="form-control flex-1" placeholder="Staff Name">
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-1" class="form-label">Staff ID</label>
                                    <input id="pos-form-1" name="Staff_ID" type="text" class="form-control flex-1" placeholder="Staff ID">
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-2" class="form-label">PIN</label>
                                    <input id="pos-form-2" name="Staff_PIN" type="password" class="form-control flex-1" placeholder="Staff PIN">
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-3" class="form-label">Tempat Lahir</label>
                                    <input id="pos-form-3" name="Staff_Tempat_Lahir" type="text" class="form-control flex-1" placeholder="Staff Tempat Lahir">
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-4" class="form-label">Tanggal Lahir</label>
                                    <input id="pos-form-4" name="Staff_Tgl_Lahir" type="date" class="form-control flex-1" placeholder="Staff Tanggal Lahir">
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-5" class="form-label">Telepon</label>
                                    <input id="pos-form-5" name="Staff_Telp" type="text" class="form-control flex-1" placeholder="Staff Telp">
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-6" class="form-label">Access</label>
                                    <select for="pos-form-6" class="form-select" name="Staff_Access">
                                        <option value="STORE">STORE</option>
                                        <option value="PRODUCTION">PRODUCTION</option>
                                    </select>
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-7" class="form-label">Alamat</label>
                                    <textarea id="pos-form-7" name="Staff_Alamat" class="form-control flex-1" placeholder="Jl Mayjend Sungkono"></textarea>
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
                <div id="edit-staff-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="edit" action="function/staffs?menu=edit" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    Edit Staff
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-12">
                                <div class="col-span-12">
                                    <label for="edit-name" class="form-label">Name</label>
                                    <input id="edit-id" name="Staff_No" type="hidden" class="form-control flex-1">
                                    <input id="edit-name" name="Staff_Name" type="text" class="form-control flex-1" placeholder="Staff Name">
                                </div>
                                <div class="col-span-6">
                                    <label for="edit-staff-id" class="form-label">Staff ID</label>
                                    <input id="edit-staff-id" name="Staff_ID" type="text" class="form-control flex-1" placeholder="Staff ID">
                                </div>
                                <div class="col-span-6">
                                    <label for="edit-pin" class="form-label">PIN</label>
                                    <input id="edit-pin" name="Staff_PIN" type="password" class="form-control flex-1" placeholder="Staff PIN">
                                </div>
                                <div class="col-span-6">
                                    <label for="edit-tempat-lahir" class="form-label">Tempat Lahir</label>
                                    <input id="edit-tempat-lahir" name="Staff_Tempat_Lahir" type="text" class="form-control flex-1" placeholder="Staff Tempat Lahir">
                                </div>
                                <div class="col-span-6">
                                    <label for="edit-tanggal-lahir" class="form-label">Tanggal Lahir</label>
                                    <input id="edit-tanggal-lahir" name="Staff_Tgl_Lahir" type="date" class="form-control flex-1" placeholder="Staff Tanggal Lahir">
                                </div>
                                <div class="col-span-6">
                                    <label for="edit-telp" class="form-label">Telepon</label>
                                    <input id="edit-telp" name="Staff_Telp" type="text" class="form-control flex-1" placeholder="Staff Telp">
                                </div>
                                <div class="col-span-6">
                                    <label for="edit-access" class="form-label">Access</label>
                                    <select for="edit-access" id="edit-access" class="form-select" name="Staff_Access">
                                        <option value="STORE">STORE</option>
                                        <option value="PRODUCTION">PRODUCTION</option>
                                    </select>
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-alamat" class="form-label">Alamat</label>
                                    <textarea id="edit-alamat" name="Staff_Alamat" class="form-control flex-1" placeholder="Jl Mayjend Sungkono"></textarea>
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
                    $('#example').DataTable({
                        "ajax":{
                            url :"function/staffs?menu=data",
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
                    });     
                });

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
                        url : "function/staffs?menu=ajax",
                        type: "post",
                        data: "Staff_No="+id,
                            success: function(data) { // Jika berhasil
                                var json = data,
                                obj = JSON.parse(json);
                                $('#edit-id').val(obj.Staff_No);
                                $('#edit-name').val(obj.Staff_Name);
                                $('#edit-pin').val(obj.Staff_PIN);
                                $('#edit-staff-id').val(obj.Staff_ID);
                                $('#edit-tempat-lahir').val(obj.Staff_Tempat_Lahir);
                                $('#edit-tanggal-lahir').val(obj.Staff_Tgl_Lahir);
                                $('#edit-access').val(obj.Staff_Access);
                                $('#edit-telp').val(obj.Staff_Telp);
                                $('#edit-alamat').val(obj.Staff_Alamat);
                            }
                    });
                }    
                function btnDelete(id) {
                    location.href = "function/staffs?menu=delete&id="+id;
                }    
            </script>

            