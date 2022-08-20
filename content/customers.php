            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Customers
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-customer-modal">Add New Customer</button>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Membership</th>
                                        <th>Join Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $sql = mysqli_query($conn, "SELECT c.id, c.name as nama, m.name as member, join_date, address 
                                                                FROM customer c JOIN membership m 
                                                                ON c.membership=m.id ORDER BY nama");
                                    while($data = mysqli_fetch_assoc($sql)){
                                        echo "
                                            <tr>
                                                <td>".$data['nama']."</td>
                                                <td>".$data['address']."</td>
                                                <td>".$data['member']."</td>
                                                <td>".date('d F Y', strtotime($data['join_date']))."</td>
                                                <td>
                                                    <a href='#' onclick='editButton({$data['id']})' data-tw-toggle='modal' data-tw-target='#edit-customer-modal' >edit</a> | 
                                                    <a href='#' onclick='deleteButton({$data['id']})'>delete</a>
                                                </td>
                                            </tr>                                        
                                        ";
                                    }
                                    ?>
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
                                    <input id="pos-form-1" name="name" type="text" class="form-control flex-1" placeholder="Customer name">
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-2" class="form-label">Address</label>
                                    <textarea id="pos-form-2" name="address" class="form-control flex-1" placeholder="Jl Mayjend Sungkono"></textarea>
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-3" class="form-label">Memberhip</label>
                                    <select for="pos-form-3" class="form-select mt-2 sm:mr-2" name="membership">
                                    <?php
                                    $sql = mysqli_query($conn, 'SELECT *FROM membership');
                                    while ($data = mysqli_fetch_assoc($sql)) {
                                        echo "<option value='{$data["id"]}'>{$data['name']}</option>";
                                    }
                                    ?>
                                    </select>
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
                                    <label for="edit-name" class="form-label">Name</label>
                                    <input type="hidden" id="edit-id" name="id">
                                    <input id="edit-name" name="name" type="text" class="form-control flex-1" placeholder="Customer name">
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-address" class="form-label">Address</label>
                                    <textarea id="edit-address" name="address" class="form-control flex-1" placeholder="Jl Mayjend Sungkono"></textarea>
                                </div>
                                <div class="col-span-12">
                                    <label for="edit-membership" class="form-label">Memberhip</label>
                                    <select id="edit-membership" class="form-select mt-2 sm:mr-2" name="membership">
                                    <?php
                                    $sql = mysqli_query($conn, 'SELECT *FROM membership');
                                    while ($data = mysqli_fetch_assoc($sql)) {
                                        echo "<option value='{$data["id"]}'>{$data['name']}</option>";
                                    }
                                    ?>
                                    </select>
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
<script>
    function deleteButton(id){
        let text = "Are you sure?";
        if (confirm(text) == true) {
            location.href="function/customers?menu=delete&id="+id;
        } else {
            text = "You canceled!";
        }
    }
    function editButton(id){
        $.ajax({
            type:'POST',
            url:'function/customers?menu=ajax',
            data:'id='+id,
            success: function(data) { // Jika berhasil
                var json = data,
                obj = JSON.parse(json);
                $('#edit-id').val(obj.id);
                $('#edit-name').val(obj.name);
                $('#edit-address').val(obj.address);
                $('#edit-membership').val(obj.membership);
             }
        });
    }
</script>

            