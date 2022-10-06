
<div class="wrapper-box">
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 2xl:col-span-12">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-4 row-start-4 lg:row-start-4 xl:row-start-auto mt-6 xl:mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Sales Report
                            </h2>
                        </div>
                        <div class="report-box-2 before:hidden xl:before:block intro-y mt-5">
                            <form action="function/report?type=daily-invoice" method="POST">
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
                                        <button class="btn btn-primary" type="submit"><i data-lucide="refresh-cw"></i>&emsp;Generate</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <form action="function/report?type=monthly-invoice" method="POST">
                            <div class="box p-5">
                                    <div class="grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12 xl:col-span-8">
                                        <label for="modal-datepicker-2" class="form-label">Monthly</label>
                                        <input type="text" id="month" name="month" class="datepicker form-control" data-single-mode="true">
                                    </div>
                                    <div class="col-span-12 xl:col-span-4">
                                        <label class="form-label">&nbsp;</label><br>
                                        <button class="btn btn-primary" type="submit"><i data-lucide="refresh-cw"></i>&emsp;Generate</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <form action="function/report?type=yearly-invoice" method="POST">
                            <div class="box p-5">
                                    <div class="grid grid-cols-12 gap-4 gap-y-3">
                                        <div class="col-span-12 xl:col-span-8">
                                        <label for="modal-datepicker-2" class="form-label">Yearly</label>
                                        <input type="text" id="year" name="year" class="datepicker form-control" data-single-mode="true">
                                    </div>
                                    <div class="col-span-12 xl:col-span-4">
                                        <label class="form-label">&nbsp;</label><br>
                                        <button class="btn btn-primary" type="submit"><i data-lucide="refresh-cw"></i>&emsp;Generate</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-8 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                General Report
                            </h2>
                        </div>
                        <div class="report-box-2 intro-y mt-5">
                            <div class="box grid grid-cols-12">
                                <div class="col-span-12 lg:col-span-12 p-8 border-t lg:border-t-0 lg:border-l border-slate-200 dark:border-darkmode-300 border-dashed">
                                    <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                                        <table id="example" class="display" style="width:100%" hidden>
                                            <thead>
                                                <tr>
                                                    <th>Invoice</th>
                                                    <th>Customer</th>
                                                    <th>Telp</th>
                                                    <th>Tanggal</th>
                                                    <th>PCS</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="hasil">
                                                <tr><th colspan="6">Tidak ada data untuk ditampilkan</th></tr>
                                            </tbody>
                                        </table>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content -->
</div>
<?php include 'appjs.php'; ?>
<script type="text/javascript">
    function btnGenerate () {
        var send;
        if (option == 'daily') {
            var start   = document.getElementById('start').value;
            var end     = document.getElementById('end').value;
            
            send = start+ "|" +end;
        } else if (option == 'monthly') {
            send = document.getElementById('month').value;
        } else {
            send = document.getElementById('year').value;
        }
        
        destroyTable('example');
        
        $.ajax({
            url : "function/daily_invoice,
            type: "post",
            data: "option="+option+"&send="+send,
            success: function(dataSet) { // Jika berhasil                               
                var data = JSON.parse(dataSet);
                
                $('#example').show();
                $('#example').DataTable({
                    searching: false,
                    paging: false,   
                    data: data,
                });
            }
        });     
    }

    function destroyTable (tableId) {
        if ($.fn.dataTable.isDataTable('#' + tableId)) {
            $('#' + tableId).DataTable().destroy();
            $('#' + tableId).addClass('dataTable no-footer');
        }
    }
</script>

