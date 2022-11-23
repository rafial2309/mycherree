            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Integration
                        </h2>
                        <!-- <button class="ml-auto btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-customer-modal"><i data-lucide='plus-circle' class='w-5 h-5'></i> &nbsp; Add New Customer</button> -->
                        
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            
                            <input type="date"  name="" id="tanggal1">
                            <button class="btn btn-primary mr-1 mb-2" onclick="ambildata()">Generate Summary CSV</button>
                            <button class="btn btn-primary mr-1 mb-2" onclick="ambildata2()">Send (Via API)</button>
                            <br>
                            <hr>
                            <br>
                            <div id="hasilajax">
                                
                            </div>
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


                function ambildata() {
                    var tgl1 = document.getElementById("tanggal1").value;

                    if (tgl1=='') {
                        
                    }else{
                        document.getElementById("tanggal1").blur();
                        
                        $.ajax({
                        url:'function/integrationcsv.php?tgl1='+tgl1,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajax').html(response);
                        },

                        })    
                    }
                }


                function ambildata2() {
                    var tgl1 = document.getElementById("tanggal1").value;

                    if (tgl1=='') {
                        
                    }else{
                        document.getElementById("tanggal1").blur();
                        
                        $.ajax({
                        url:'function/integrationapi.php?tgl1='+tgl1,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajax').html(response);
                        },

                        })                       
                    }
                }

                

            </script>

            