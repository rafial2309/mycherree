            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 2xl:col-span-12">
                            <div class="grid grid-cols-12 gap-6">
                                <div class="col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-4 row-start-4 lg:row-start-4 xl:row-start-auto mt-6 xl:mt-8">
                                    <div class="intro-y flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-5">
                                            Daily Invoice Report
                                        </h2>
                                    </div>
                                    <div class="report-box-2 before:hidden xl:before:block intro-y mt-5">
                                        <form id="form-daily" action="function/report?type=daily-invoice" method="POST">
                                        <div class="box p-5">
                                                <div class="grid grid-cols-12 gap-4 gap-y-3">
                                                <div class="col-span-12 sm:col-span-4">
                                                    <label for="modal-datepicker-1" class="form-label">From</label>
                                                    <input type="text" id="start" name="start" class="datepicker form-control" data-single-mode="true">
                                                </div>
                                                <div class="col-span-12 sm:col-span-4">
                                                    <label for="modal-datepicker-2" class="form-label">To</label>
                                                    <input type="text" id="end" name="end" class="datepicker form-control" data-single-mode="true">
                                                </div>
                                                <div class="col-span-12 sm:col-span-4">
                                                    <label class="form-label">&nbsp;</label><br>
                                                    <button class="btn btn-primary" type="button" onclick="btnGenerate('daily')"><i data-lucide="refresh-cw"></i>&emsp;Generate</button>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                        <form id="form-monthly" action="function/report?type=monthly-invoice" method="POST">
                                        <div class="box p-5">
                                                <div class="grid grid-cols-12 gap-4 gap-y-3">
                                                <div class="col-span-12 xl:col-span-8">
                                                    <label for="modal-datepicker-2" class="form-label">Monthly</label>
                                                    <input type="text" id="month" name="month" class="datepicker form-control" data-single-mode="true">
                                                </div>
                                                <div class="col-span-12 xl:col-span-4">
                                                    <label class="form-label">&nbsp;</label><br>
                                                    <button class="btn btn-primary" type="button" onclick="btnGenerate('monthly')"><i data-lucide="refresh-cw"></i>&emsp;Generate</button>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                        <form id="form-yearly" action="function/report?type=yearly-invoice" method="POST">
                                        <div class="box p-5">
                                                <div class="grid grid-cols-12 gap-4 gap-y-3">
                                                    <div class="col-span-12 xl:col-span-8">
                                                    <label for="modal-datepicker-2" class="form-label">Yearly</label>
                                                    <input type="text" id="year" name="year" class="datepicker form-control" data-single-mode="true">
                                                </div>
                                                <div class="col-span-12 xl:col-span-4">
                                                    <label class="form-label">&nbsp;</label><br>
                                                    <button class="btn btn-primary" type="button" onclick="btnGenerate('yearly')"><i data-lucide="refresh-cw"></i>&emsp;Generate</button>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-span-12 xl:col-span-8 mt-8">
                                    <div class="intro-y flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-5">
                                            Display Report Data
                                        </h2>
                                    </div>
                                    <div class="report-box-2 intro-y mt-5">
                                        <div class="box grid grid-cols-12">
                                            <div class="col-span-12 lg:col-span-12 p-8 border-t lg:border-t-0 lg:border-l border-slate-200 dark:border-darkmode-300 border-dashed">
                                                <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                                                    <div class="intro-y flex items-center h-10 mb-5" id="div-button">
                                                        <h2 class="intro-y text-lg font-medium" id="header-invoice" hidden>
                                                            Daily Invoice
                                                        </h2>
                                                        <input type="hidden" id="type-value">
                                                        <button id="btn-download" class="ml-auto btn btn-primary shadow-md mr-2 hidden" onclick="btnDownload()">Download</button>
                                                    </div>
                                                    <table id="example" class="display" style="width:100%" hidden>
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice</th>
                                                                <th>Tanggal Masuk</th>
                                                                <th>Tanggal Selesai</th>
                                                                <th>Customer</th>
                                                                <th>Alamat</th>
                                                                <th>Total PCS</th>
                                                                <th>Amount</th>
                                                                <th>Staff</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="hasil">
                                                            <tr><th colspan="6">Tidak ada data untuk ditampilkan</th></tr>
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <p id="total-pcs"></p>
                                                    <p id="total-amount"></p>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'appjs.php'; ?>
            <script type="text/javascript">

                function btnGenerate (type) {
                    let url;
                    let start   = $('#start').val();
                    let end     = $('#end').val();
                    let month   = $('#month').val();
                    let year    = $('#year').val();
                    
                    let data = {
                        start: start,
                        end: end,
                        month: month,
                        year: year,
                        type: type
                    }

                    $('#example').show();
                    destroyTable('example');
                    
                    $('#example').DataTable({
                        ajax: {
                            url: 'function/report?type=data&data=daily-invoice',
                            type: 'POST',
                            data: data,
                            dataType: 'json',
                            dataSrc: function(json) {
                                return json.data
                            }
                        },
                        columns: [
                            { data: 'Inv_Number' },
                            { data: 'Inv_Tgl_Masuk' },
                            { data: 'Inv_Tg_Selesai' },
                            { data: 'Cust_Nama' },
                            { data: 'Cust_Alamat' },
                            { data: 'Total_PCS' },
                            { data: 'Payment_Amount' },
                            { data: 'Staff_Name' },
                        ],
                        "language" : {
                            "emptyTable" : "Data Tidak Ditemukan"
                        },
                        "initComplete": function() {
                            $('#header-invoice').show();
                            $('#btn-download').removeClass('hidden');
                        
                            if (type == 'daily') 
                                $('#header-invoice').text('Daily Invoice')
                            else if (type == 'monthly') 
                                $('#header-invoice').text('Monthly Invoice')
                            else 
                                $('#header-invoice').text('Yearly Invoice')
                            
                            $('#type-value').val(type);
                            showTotal();
                        }
                    });
                }

                function showTotal() {
                    let url;
                    let start   = $('#start').val();
                    let end     = $('#end').val();
                    let month   = $('#month').val();
                    let year    = $('#year').val();
                    let type    = $('#type-value').val();
                    
                    let data = {
                        start: start,
                        end: end,
                        month: month,
                        year: year,
                        type: type
                    }

                    $.ajax({
                        type:'POST',
                        url:'function/report?type=get-total',
                        data:data,
                        success: function(data) { // Jika berhasil
                            var json = data,
                            obj = JSON.parse(json);
                            $('#total-pcs').html(obj.Total_PCS);
                            $('#total-amount').html(obj.Total_Amount);
                        }
                    });

                }

                function btnDownload() {
                    let type = $('#type-value').val();
                    
                    if (type == 'daily') {
                        $('#form-daily').submit();
                    } else if (type == 'monthly') {
                        $('#form-monthly').submit();
                    } else {
                        $('#form-yearly').submit();
                    } 
                }

                function destroyTable (tableId) {
                    if ($.fn.dataTable.isDataTable('#' + tableId)) {
                        $('#' + tableId).DataTable().destroy();
                        $('#' + tableId).addClass('dataTable no-footer');
                    }
                }
            </script>

            