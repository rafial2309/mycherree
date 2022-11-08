            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Transaction - Membership
                        </h2>
                        <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-membership-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Registration Membership</button>
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <button class="btn btn-primary mr-1 mb-2" onclick="btnExcel()">Export Data - Excel</button>
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Payment</th>
                                        <th>Amount</th>
                                        <th>Join-Expired</th>
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
                <div id="new-membership-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="create" action="function/memberships?menu=create" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    New Customer
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="pos-form-1" class="form-label">Customer</label>
                                    <select name="Customer" id="pos-form-1" data-placeholder="Select Customers" class="tom-select w-full">
                                        <option>-- SELECT CUSTOMER --</option>
                                        <?php 
                                            $querycust = mysqli_query($conn,"SELECT * from Customer WHERE Cust_Status='Y' order by Cust_Nama asc");
                                            while($datacust = mysqli_fetch_assoc($querycust)){
                                        ?>
                                            <option value="<?php echo $datacust['Cust_No'] ?> - <?php echo $datacust['Cust_Nama'] ?>"><?php echo $datacust['Cust_Nama'] ?> | <?php echo $datacust['Cust_Alamat'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                 <div class="col-span-12">
                                    <label for="pos-form-2" class="form-label">Discount</label>
                                    <select name="Discount_No" id="pos-form-2" data-placeholder="Select Customers" class="tom-select w-full">
                                        <option>-- SELECT DISCOUNT --</option>
                                        <?php 
                                            $query = mysqli_query($conn,"SELECT * from Discount WHERE Discount_Status='Y' order by Discount_Nama asc");
                                            while($disc = mysqli_fetch_assoc($query)){
                                        ?>
                                            <option value="<?php echo $disc['Discount_No'] ?>"><?php echo $disc['Discount_Nama'] ?> (<?php echo $disc['Persentase'] ?>%)</option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-span-12">
                                    <label for="pos-form-3" class="form-label">Jumlah Pembayaran</label>
                                    <div class="input-group">    
                                        <div id="input-group-uang" class="input-group-text">Rp</div> 
                                        <input type="number" name="Registrasi_Payment" id="pos-form-3" class="form-control flex-1 uang" placeholder="50.000"  aria-describedby="input-group-uang">
                                    </div>
                                </div>
                                <div class="col-span-6">
                                    <label for="pos-form-4" class="form-label">Start Date</label>
                                    <input id="pos-form-4" type="date" name="Cust_Member_Join" class="form-control flex-1" onchange="fillExpired(this.valueAsDate)">
                                </div>
                                <div class="col-span-6">
                                    <label for="expired" class="form-label">Expired Date</label>
                                    <input id="expired" type="date" name="Cust_Member_Exp" class="form-control flex-1" readonly>
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
                <div id="payment-member-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="payment" action="function/memberships?menu=payment" method="post">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">
                                    Payment Update
                                </h2>
                            </div>
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="col-span-12">
                                    <label for="payment-status" class="form-label">Payment Status</label>
                                    <input id="registrasi-id" type="hidden" name="Registrasi_ID">
                                    <select id="payment-status" name="Status_Payment" class="form-control flex-1">
                                        <option value="N">UNPAID</option>
                                        <option value="Y">PAID</option>
                                    </select>
                                </div>
                                <div class="col-span-12">
                                    <label for="payment-type" class="form-label">Payment Type</label>
                                    <select id="payment-type" name="Payment_Type" class="form-control flex-1">
                                        <option value="">--- SELECT PAYMENT TYPE ---</option>
                                        <option value="CASH">CASH</option>
                                        <option value="TRANSFER">TRANSFER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer text-right">
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                <button type="button" onclick="document.getElementById('payment').submit()" class="btn btn-primary w-32">Save</button>
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
                            url :"function/memberships?menu=data",
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
                    });     
                });

                function btnExcel () {
                    let search = $('#example_filter :input').val();

                    location.href='function/report?type=membership&search='+search;
                }

                function btnEdit(id) {
                    $.ajax({
                        url : "function/memberships?menu=ajax",
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
                
                function fillExpired(value){
                    var expired = value.setDate(value.getDate() + 30); 
                    
                    // if (edit == null) {
                        document.getElementById('expired').value = new Date(value).toISOString().split('T')[0];
                    // } else {
                    //     document.getElementById('edit-expired').value = expired;
                    // }
                }

                function btnPayment(id) {
                     $.ajax({
                        url : "function/memberships?menu=get_payment",
                        type: "post",
                        data: "Registrasi_ID="+id,
                            success: function(data) { // Jika berhasil
                                var json = data,
                                obj = JSON.parse(json);
                                $('#registrasi-id').val(obj.Registrasi_ID);
                                $('#payment-status').val(obj.Status_Payment);
                                $('#payment-type').val(obj.Payment_Type);
                            }
                    });
                }    

                $(document).ready(function(){
                    // Format mata uang.
                    $( '.uang' ).mask('000.000.000', {reverse: true});
                })  
            </script>
            </script>

            