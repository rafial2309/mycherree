            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <h2 class="intro-y text-lg font-medium mt-5">
                        Rewash History
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
                                
                                <button class="btn btn-primary shadow-md mr-2"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> NEW TRANSACTION </button>
                               
                            </div>
                        </div>
                        <!-- BEGIN: Data List -->
                        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
                            <table class="table table-report -mt-2">
                                <thead>
                                    <tr>
                                        
                                        <th class="whitespace-nowrap">INVOICE</th>
                                        <th class="whitespace-nowrap">BUYER NAME</th>
                                        <th class="whitespace-nowrap">FINISH</th>
                                        <th class="whitespace-nowrap">PAYMENT</th>
                                        <th class="text-right whitespace-nowrap">
                                            <div class="pr-16">TOTAL TRANSACTION</div>
                                        </th>
                                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="intro-x">
                                        
                                        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap" style="font-size: 17px;">#INV-2200001</a> </td>
                                        <td class="w-40">
                                            <a href="" class="font-medium whitespace-nowrap">Mustafa Amien</a> 
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Jl. Merdeka Indah Jaya Sentosa, Jakarta</div>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">081263723</div>
                                        </td>
                                        <td>
                                            <div class="pr-16">Mon, 23 Sep 2022</div>
                                        </td>
                                        <td>
                                            <div class="flex items-center whitespace-nowrap text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Completed </div>
                                            <div class="whitespace-nowrap">Direct bank transfer</div>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">25 March, 12:55</div>
                                        </td>
                                        <td class="w-40 text-right">
                                            <div class="pr-16">Rp 370.000</div>
                                        </td>
                                        <td class="table-report__action">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center text-primary whitespace-nowrap mr-5" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> View Details </a>
                                                
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
                                    <tr class="intro-x">
                                        
                                        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap" style="font-size: 17px;">#INV-2200002</a> </td>
                                        <td class="w-40">
                                            <a href="" class="font-medium whitespace-nowrap">Aldiansyah A</a> 
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Jl. PIK Indah, Jakarta</div>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">01237823</div>
                                        </td>
                                        <td>
                                            <div class="pr-16">Tue, 24 Sep 2022</div>
                                        </td>
                                        <td>
                                            <div class="flex items-center whitespace-nowrap text-warning"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Unpaid </div>
                                            <button class="btn btn-sm btn-warning shadow-md mr-2 mt-2"> <i data-lucide="credit-card" class="w-4 h-4 mr-2"></i> MAKE A PAYMENT </button>

                                        </td>
                                        <td class="w-40 text-right">
                                            <div class="pr-16">Rp 370.000</div>
                                        </td>
                                        <td class="table-report__action">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center text-primary whitespace-nowrap mr-5" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> View Details </a>
                                                
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