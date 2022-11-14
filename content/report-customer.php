            
            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Report Customer
                        </h2>
                        <!-- <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-customer-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Customer</button> -->
                        
                    </div>
                    <div class="grid grid-cols-12 gap-3 mt-5">
                        <div class="col-span-3">
                            <input type="date"   name="" id="tanggal1">
                            <input type="date"  name="" id="tanggal2">
                        </div>
                        <div class="col-span-2">
                            <select class="form-control" id="payment">
                                <option value="Y">PAID</option>
                                <option value="N">UNPAID</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <select class="form-control" id="taken">
                                <option value="Y">TAKEN</option>
                                <option value="N">UNTAKEN</option>
                            </select>
                        </div>
                        
                        <div class="col-span-12">
                            <c id="tampilcust"></c>
                        </div>
                    </div>
                        <button class="btn btn-primary mr-1 mb-2" onclick="ambildata()">Generate</button>
                        
                        <br>
                        <hr>
                        <br>
                        <div id="hasilajax">
                            
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


                setTimeout(function(){ tampilcust() }, 500); 

                function tampilcust() {
                    $.ajax({
                        url:'function/report-customer.php?menu=tampilcustomer',
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#tampilcust').html(response);
                        },

                        })   
                }


                function ambildata() {
                    var tgl1 = document.getElementById("tanggal1").value;
                    var tgl2 = document.getElementById("tanggal2").value;
                    var payment = document.getElementById("payment").value;
                    var taken = document.getElementById("taken").value;
                    var pilihcustomer = document.getElementById("pilihcustomer").value;

                    if (tgl1=='') {
                        
                    }else{
                        document.getElementById("tanggal1").blur();
                        
                        $.ajax({
                        url:'function/report-customer.php?tgl1='+tgl1+'&tgl2='+tgl2+'&cust='+pilihcustomer+'&menu=tampil&payment='+payment+'&taken='+taken,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajax').html(response);
                        },

                        })                       
                    }
                }

                

            </script>

            