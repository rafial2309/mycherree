            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex items-center h-10 mt-5">
                        <h2 class="intro-y text-lg font-medium">
                            Report Data
                        </h2>
                        &nbsp; &nbsp; 
                       <select name="jenis_report" data-placeholder="Select Report" id="jenis_report">
                            <option>-- Select Report --</option>
                            <option value="Top Customer">Top Customer (PALING BANYAK)</option>
                            <option value="Customer Retention">Customer Retention (GAK CUCI)</option>
                            <option value="Customer UNPAID">Customer UNPAID (BELUM BAYAR)</option>
                            <option value="Customer UNTAKEN">Customer UNTAKEN (PENDINGAN)</option>
                            <option value="Customer JOIN">Customer Join (BARU TERDAFTAR)</option>
                            <option value="Member JOIN">Member Join (BARU TERDAFTAR)</option>
                        </select>
                        &nbsp; &nbsp; 
                        <button class="btn btn-primary mr-1" onclick="ambildata()">Show</button>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-3">
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            
                            <hr class="mb-3">

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
                    var jenis_report = document.getElementById("jenis_report").value;

                    $.ajax({
                        url:'function/report-all.php?menu='+jenis_report,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajax').html(response);
                        },

                    }) 
                }


                function ambildata1() {
                    var tgl1 = document.getElementById("tanggal1").value;
                    var tgl2 = document.getElementById("tanggal2").value;

                    if (tgl1=='' || tgl2=='') {
                        
                    }else{
                        document.getElementById("tanggal1").blur();
                        document.getElementById("tanggal2").blur();
                        
                        $.ajax({
                        url:'function/report-all.php?menu=ambildata1&tgl1='+tgl1+'&tgl2='+tgl2,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajaxreport').html(response);
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
                        url:'function/report-all.php?menu=ambildata2&tgl1='+tgl1,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajaxreport').html(response);
                        },

                        })                       
                    }
                }

                function ambildata3() {
                    var tgl1 = document.getElementById("tanggal1").value;

                    if (tgl1=='') {
                        
                    }else{
                        document.getElementById("tanggal1").blur();
                        
                        $.ajax({
                        url:'function/report-all.php?menu=ambildata3&tgl1='+tgl1,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajaxreport').html(response);
                        },

                        })                       
                    }
                }


                function ambildata4() {
                    var tgl1 = document.getElementById("tanggal1").value;

                    if (tgl1=='') {
                        
                    }else{
                        document.getElementById("tanggal1").blur();
                        
                        $.ajax({
                        url:'function/report-all.php?menu=ambildata4&tgl1='+tgl1,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajaxreport').html(response);
                        },

                        })                       
                    }
                }

                function ambildata5() {
                    var tgl1 = document.getElementById("tanggal1").value;
                    var tgl2 = document.getElementById("tanggal2").value;
                    var cabang5 = document.getElementById("cabang5").value;

                    if (tgl1=='' || tgl2=='' || cabang5=='') {
                        
                    }else{
                        document.getElementById("tanggal1").blur();
                        document.getElementById("tanggal2").blur();
                        
                        $.ajax({
                        url:'function/report-all.php?menu=ambildata5&tgl1='+tgl1+'&tgl2='+tgl2+'&cabang='+cabang5,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajaxreport').html(response);
                        },

                        })                       
                    }
                }

                function ambildata6() {
                    var tgl1 = document.getElementById("tanggal1").value;
                    var tgl2 = document.getElementById("tanggal2").value;
                    var cabang6 = document.getElementById("cabang6").value;

                    if (tgl1=='' || tgl2=='' || cabang6=='') {
                        
                    }else{
                        document.getElementById("tanggal1").blur();
                        document.getElementById("tanggal2").blur();
                        
                        $.ajax({
                        url:'function/report-all.php?menu=ambildata6&tgl1='+tgl1+'&tgl2='+tgl2+'&cabang='+cabang6,
                        type:'GET',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilajaxreport').html(response);
                        },

                        })                       
                    }
                }


                

            </script>

            