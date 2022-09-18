            
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <h2 class="intro-y text-lg font-medium mt-5">
                        Transaction History
                    </h2>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
                            <div class="flex w-full sm:w-auto">
                                <div class="w-48 relative text-slate-500">
                                    <input type="text" class="form-control w-48 box pr-10" placeholder="Search by invoice...">
                                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
                                </div>
                                <select class="form-select box ml-2">
                                    <option>Status</option>
                                    <option>Unpaid</option>
                                    <option>Paid</option>
                                    <option>Taken</option>
                                </select>
                            </div>
                            <div class="hidden xl:block mx-auto text-slate-500">&nbsp;</div>
                            <div class="w-full xl:w-auto flex items-center mt-3 xl:mt-0">
                                
                                <button onclick="window.location='app?p=newtransaction'" class="btn btn-primary shadow-md mr-2"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> NEW TRANSACTION </button>
                               
                            </div>
                        </div>
                        <!-- BEGIN: Data List -->
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <table class="table table-report -mt-2">
                                <thead>
                                    <tr>
                                        
                                        <th class="whitespace-nowrap">INVOICE</th>
                                        <th class="whitespace-nowrap">BUYER NAME</th>
                                        <th class="whitespace-nowrap" style="width: 205px;">FINISH</th>
                                        <th class="whitespace-nowrap">STATUS</th>
                                        <th class="text-right whitespace-nowrap" style="width: 190px;">
                                            <div class="pr-16">PAYMENT</div>
                                        </th>
                                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = mysqli_query($conn,"SELECT * from Invoice order by Inv_No DESC LIMIT 20");
                                        while($data=mysqli_fetch_assoc($query)){
                                    ?>
                                    <tr class="intro-x">
                                        
                                        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap" style="font-size: 17px;">#INV-<?php echo $data['Inv_Number'] ?></a> </td>
                                        <td class="w-40">
                                            <a href="" class="font-medium whitespace-nowrap"><?php echo $data['Cust_Nama'] ?></a> 
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo $data['Cust_Alamat'] ?></div>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo $data['Cust_Telp'] ?></div>
                                        </td>
                                        <td>
                                            <div class="pr-16"><?php echo date('D, d-m-Y', strtotime($data['Inv_Tgl_Masuk'])); ?></div>
                                            <div class="pr-16"><?php echo date('D, d-m-Y', strtotime($data['Inv_Tg_Selesai'])); ?></div>
                                        </td>
                                        <td>
                                            <?php if ($data['Status_Payment']=='N') { ?>
                                                <div class="flex items-center whitespace-nowrap text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> UNPAID </div>
                                                
                                            <?php }else{ ?>
                                                <div class="flex items-center whitespace-nowrap text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Completed </div>
                                                <div class="whitespace-nowrap">Direct bank transfer</div>
                                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">25 March, 12:55</div>
                                            <?php } ?>
                                        </td>
                                        <td class="w-40 text-right">
                                            <div class="pr-16">Rp <?php echo number_format($data['Payment_Amount'] ,0,",",".")?></div>
                                        </td>
                                        <td class="table-report__action">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center text-primary whitespace-nowrap mr-5" href="app?p=transactions_detail&invoice=<?php echo $data['Inv_Number'] ?>"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> View Details </a>
                                                
                                                <div class="dropdown"> 
                                                    <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown"><i data-lucide="send" class="w-4 h-4 mr-2"></i> Process Invoice</button> 
                                                    <div class="dropdown-menu w-40"> 
                                                        <ul class="dropdown-content"> 
                                                            <li> <div class="dropdown-header">Process</div> </li> 
                                                            <li> <hr class="dropdown-divider"> </li> 
                                                            <li> <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print Invoice </a> </li> 
                                                            <li> <a href="" class="dropdown-item"> <i data-lucide="credit-card" class="w-4 h-4 mr-2"></i> Payment </a> 
                                                            </li> 
                                                            <li> <a href="" class="dropdown-item"> <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i> Cancel </a> </li> 
                                                            <li> <a href="" class="dropdown-item"> <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i> Rewash </a> </li> 
                                                            
                                                        </ul> 
                                                    </div> 
                                                </div> 
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END: Data List -->
                        
                    </div>
                    <!-- BEGIN: Delete Confirmation Modal -->
                    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="p-5 text-center">
                                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                                        <div class="text-3xl mt-5">Are you sure?</div>
                                        <div class="text-slate-500 mt-2">
                                            Do you really want to delete these records? 
                                            <br>
                                            This process cannot be undone.
                                        </div>
                                    </div>
                                    <div class="px-5 pb-8 text-center">
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                        <button type="button" class="btn btn-danger w-24">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Delete Confirmation Modal -->
                </div>
                <!-- END: Content -->
            </div>
            <?php include 'appjs.php'; ?>