<div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 2xl:col-span-9">
                            <div class="grid grid-cols-12 gap-6">
                                <!-- BEGIN: General Report -->
                                <div class="col-span-12 mt-8">
                                    <div class="intro-y flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-5">
                                            General Report
                                        </h2>
                                        <a href="" class="ml-auto flex items-center text-primary"> <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                                    </div>
                                    <div class="grid grid-cols-12 gap-6 mt-5">
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6">35.000.000</div>
                                                    <div class="text-base text-slate-500 mt-1">Total Sales</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6">32.000.000</div>
                                                    <div class="text-base text-slate-500 mt-1">Total Payment</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6">2.149</div>
                                                    <div class="text-base text-slate-500 mt-1">Total Pcs</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="user" class="report-box__icon text-success"></i> 
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6">152.040</div>
                                                    <div class="text-base text-slate-500 mt-1">Total Customers</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: General Report -->
                                <!-- BEGIN: Sales Report -->
                                <div class="col-span-12 lg:col-span-6 mt-8">
                                    <div class="intro-y block sm:flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-5">
                                            Sales Report
                                        </h2>
                                        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                            <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i> 
                                            <input type="text" class="datepicker form-control sm:w-56 box pl-10">
                                        </div>
                                    </div>
                                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                                        <div class="flex flex-col md:flex-row md:items-center">
                                            <div class="flex">
                                                <div>
                                                    <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">$15,000</div>
                                                    <div class="mt-0.5 text-slate-500">This Month</div>
                                                </div>
                                                <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                                                <div>
                                                    <div class="text-slate-500 text-lg xl:text-xl font-medium">$10,000</div>
                                                    <div class="mt-0.5 text-slate-500">Last Month</div>
                                                </div>
                                            </div>
                                            <div class="dropdown md:ml-auto mt-5 md:mt-0">
                                                <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown"> Filter by Category <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content overflow-y-auto h-32">
                                                        <li><a href="" class="dropdown-item">PC & Laptop</a></li>
                                                        <li><a href="" class="dropdown-item">Smartphone</a></li>
                                                        <li><a href="" class="dropdown-item">Electronic</a></li>
                                                        <li><a href="" class="dropdown-item">Photography</a></li>
                                                        <li><a href="" class="dropdown-item">Sport</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="report-chart">
                                            <div class="h-[275px]">
                                                <canvas id="report-line-chart" class="mt-6 -mb-6"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Sales Report -->
                                <!-- BEGIN: Weekly Top Seller -->
                                <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                                    <div class="intro-y flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-5">
                                            Weekly Top Seller
                                        </h2>
                                        <a href="" class="ml-auto text-primary truncate">Show More</a> 
                                    </div>
                                    <div class="intro-y box p-5 mt-5">
                                        <div class="mt-3">
                                            <div class="h-[213px]">
                                                <canvas id="report-pie-chart"></canvas>
                                            </div>
                                        </div>
                                        <div class="w-52 sm:w-auto mx-auto mt-8">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                                                <span class="truncate">17 - 30 Years old</span> <span class="font-medium ml-auto">62%</span> 
                                            </div>
                                            <div class="flex items-center mt-4">
                                                <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                                                <span class="truncate">31 - 50 Years old</span> <span class="font-medium ml-auto">33%</span> 
                                            </div>
                                            <div class="flex items-center mt-4">
                                                <div class="w-2 h-2 bg-warning rounded-full mr-3"></div>
                                                <span class="truncate">>= 50 Years old</span> <span class="font-medium ml-auto">10%</span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Weekly Top Seller -->
                                <!-- BEGIN: Sales Report -->
                                <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                                    <div class="intro-y flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-5">
                                            Sales Report
                                        </h2>
                                        <a href="" class="ml-auto text-primary truncate">Show More</a> 
                                    </div>
                                    <div class="intro-y box p-5 mt-5">
                                        <div class="mt-3">
                                            <div class="h-[213px]">
                                                <canvas id="report-donut-chart"></canvas>
                                            </div>
                                        </div>
                                        <div class="w-52 sm:w-auto mx-auto mt-8">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                                                <span class="truncate">17 - 30 Years old</span> <span class="font-medium ml-auto">62%</span> 
                                            </div>
                                            <div class="flex items-center mt-4">
                                                <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                                                <span class="truncate">31 - 50 Years old</span> <span class="font-medium ml-auto">33%</span> 
                                            </div>
                                            <div class="flex items-center mt-4">
                                                <div class="w-2 h-2 bg-warning rounded-full mr-3"></div>
                                                <span class="truncate">>= 50 Years old</span> <span class="font-medium ml-auto">10%</span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Sales Report -->
                              
                            </div>
                        </div>
                        <div class="col-span-12 2xl:col-span-3">
                            <div class="2xl:border-l -mb-10 pb-10">
                                <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                                    <!-- BEGIN: Transactions -->
                                    <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                                        <div class="intro-x flex items-center h-10">
                                            <h2 class="text-lg font-medium truncate mr-5">
                                                Transactions
                                            </h2>
                                        </div>
                                        <div class="mt-5">
                                            <div class="intro-x">
                                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                                        <img alt="Midone - HTML Admin Template" src="dist/images/profile-1.jpg">
                                                    </div>
                                                    <div class="ml-4 mr-auto">
                                                        <div class="font-medium">#INV-2200003</div>
                                                        <div class="text-slate-500 text-xs mt-0.5">Mustafa Asikin</div>
                                                    </div>
                                                    <div class="text-success">Rp 600.000</div>
                                                </div>
                                            </div>
                                            <div class="intro-x">
                                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                                        <img alt="Midone - HTML Admin Template" src="dist/images/profile-1.jpg">
                                                    </div>
                                                    <div class="ml-4 mr-auto">
                                                        <div class="font-medium">#INV-2200002</div>
                                                        <div class="text-slate-500 text-xs mt-0.5">Shodiqul Aldiansyah</div>
                                                    </div>
                                                    <div class="text-success">Rp 200.000</div>
                                                </div>
                                            </div>
                                            <div class="intro-x">
                                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                                        <img alt="Midone - HTML Admin Template" src="dist/images/profile-1.jpg">
                                                    </div>
                                                    <div class="ml-4 mr-auto">
                                                        <div class="font-medium">#INV-2200001</div>
                                                        <div class="text-slate-500 text-xs mt-0.5">Kemal Amien</div>
                                                    </div>
                                                    <div class="text-success">Rp 300.000</div>
                                                </div>
                                            </div>
                                            <a href="" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View Transaction Invoice</a> 
                                        </div>
                                    </div>
                                    <!-- END: Transactions -->
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Content -->
            </div>