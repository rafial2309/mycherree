            <?php 
            $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='$_GET[invoice]'")); 
            ?>
            <div class="wrapper-box">
               
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            Transaction Details
                        </h2>
                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            <button class="btn btn-primary shadow-md mr-2"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print Invoice</button>
                            <button class="btn btn-primary shadow-md mr-2"><i data-lucide="edit" class="w-4 h-4 mr-2"></i> Edit</button>
                        </div>
                    </div>
                    <!-- BEGIN: Transaction Details -->
                    <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                            <div class="box p-5 rounded-md">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Transaction Details</div>
                                    <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Change Status </a>
                                </div>
                                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Invoice: <a href="" class="underline decoration-dotted ml-1">#INV-<?php echo $data['Inv_Number'] ?></a> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Transaction Date: <?php echo date('D, d-m-Y', strtotime($data['Inv_Tgl_Masuk'])); ?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Ready Date: <?php echo date('D, d-m-Y', strtotime($data['Inv_Tg_Selesai'])); ?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i> Payment Status: <?php if ($data['Status_Payment']=='N') { echo '<span class="bg-warning/20 text-warning rounded px-2 ml-1">UNPAID</span>'; }else{ echo '<span class="bg-success/20 text-success rounded px-2 ml-1">PAID</span>'; }?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i> Taken Status: <?php if ($data['Status_Taken']=='N') { echo '<span class="bg-warning/20 text-warning rounded px-2 ml-1">UNTAKEN</span>'; }else{ echo '<span class="bg-success/20 text-success rounded px-2 ml-1">TAKEN</span>';}?> </div>
                            </div>
                            <div class="box p-5 rounded-md mt-5">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Customer Details</div>
                                    <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Change Customer </a>
                                </div>
                                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Name: <a href="" class="underline decoration-dotted ml-1"><?php echo $data['Cust_Nama'] ?></a> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Phone Number: <?php echo $data['Cust_Telp'] ?> </div>
                                <div class="flex items-center mt-3"> <i data-lucide="map-pin" class="w-4 h-4 text-slate-500 mr-2"></i> Address: <?php echo $data['Cust_Alamat'] ?> </div>
                            </div>
                            <div class="box p-5 rounded-md mt-5">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Payment Details</div>
                                </div>
                                <div class="flex items-center">
                                    <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Payment Method: 
                                    <div class="ml-auto">
                                        <?php if ($data['Status_Payment']=='N') { echo '<span class="bg-warning/20 text-warning rounded px-2 ml-1">UNPAID</span>'; }else{ echo '<span class="bg-success/20 text-success rounded px-2 ml-1">PAID</span>'; }?>
                                    </div>
                                </div>
                                <div class="flex items-center mt-3">
                                    <i data-lucide="box" class="w-4 h-4 text-slate-500 mr-2"></i> Total Pcs: 
                                    <div class="ml-auto"><?php echo $data['Total_PCS'] ?> item(s)</div>
                                </div>

                                <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium">
                                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Total Payment: 
                                    <div class="ml-auto">Rp <?php echo number_format($data['Payment_Amount'] ,0,",",".")?></div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
                            <div class="box p-5 rounded-md">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    <div class="font-medium text-base truncate">Order Details</div>
                                    <!-- <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Notes </a> -->
                                </div>
                                <div class="overflow-auto lg:overflow-visible -mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="whitespace-nowrap" style="width:40px">No</th>
                                                <th class="whitespace-nowrap !py-5">Item(s) Description</th>
                                              
                                                <th class="whitespace-nowrap text-right">Qty</th>
                                                <th class="whitespace-nowrap text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $queryitem = mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='$data[Inv_Number]'");
                                            while($dataitem=mysqli_fetch_assoc($queryitem)){
                                            ?>
                                            <tr>
                                                <td><?php echo $dataitem['Item_No'] ?></td>
                                                <td>
                                                    <?php echo $dataitem['Deskripsi'] ?>
                                                </td>
                                               
                                                <td class="text-right"><?php echo $dataitem['Qty'] ?></td>
                                                <td class="text-right">Rp <?php echo number_format($dataitem['Total_Price'] ,0,",",".")?></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="3"><?php echo $dataitem['Item_Note'] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Transaction Details -->
                </div>
                <!-- END: Content -->
            </div>
            <?php include 'appjs.php'; ?>