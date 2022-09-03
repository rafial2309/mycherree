<div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            New Invoice
                        </h2>
                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-order-modal" class="btn btn-primary shadow-md mr-2">New Order</a> 
                            <div class="pos-dropdown dropdown ml-auto sm:ml-0">
                                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="chevron-down"></i> </span>
                                </button>
                                <div class="pos-dropdown__dropdown-menu dropdown-menu">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="" class="dropdown-item"> <i data-lucide="activity" class="w-4 h-4 mr-2"></i> <span class="truncate">INV-0206020 - Angelina Jolie</span> </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item"> <i data-lucide="activity" class="w-4 h-4 mr-2"></i> <span class="truncate">INV-0206022 - Edward Norton</span> </a>
                                        </li>
                                        <li>
                                            <a href="" class="dropdown-item"> <i data-lucide="activity" class="w-4 h-4 mr-2"></i> <span class="truncate">INV-0206021 - Johnny Depp</span> </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="intro-y grid grid-cols-12 gap-5 mt-5">
                        <!-- BEGIN: Item List -->
                        <div class="intro-y col-span-12 lg:col-span-8">
                            <div class="lg:flex intro-y">
                                <div class="relative" style="width: 100%;">
                                    <input style="width: 100%;" type="text" class="form-control py-3 px-4 w-full lg:w-64 box pr-10" placeholder="Search item...">
                                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-slate-500" data-lucide="search"></i> 
                                </div>
                                
                            </div>
                           
                            <div class="grid grid-cols-12 gap-5 mt-5 pt-5 border-t">
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3">
                                    <div class="box rounded-md p-3 relative zoom-in">
                                        <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                                            <div class="absolute top-0 left-0 w-full h-full image-fit">
                                                <img alt="Midone - HTML Admin Template" class="rounded-md" src="dist/images/food-beverage-16.jpg">
                                            </div>
                                        </div>
                                        <div class="block font-medium text-center truncate mt-3">Shirt / Kemeja</div>
                                    </div>
                                </a>
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3">
                                    <div class="box rounded-md p-3 relative zoom-in">
                                        <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                                            <div class="absolute top-0 left-0 w-full h-full image-fit">
                                                <img alt="Midone - HTML Admin Template" class="rounded-md" src="dist/images/food-beverage-13.jpg">
                                            </div>
                                        </div>
                                        <div class="block font-medium text-center truncate mt-3">Slack / Celana Panjang</div>
                                    </div>
                                </a>
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3">
                                    <div class="box rounded-md p-3 relative zoom-in">
                                        <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                                            <div class="absolute top-0 left-0 w-full h-full image-fit">
                                                <img alt="Midone - HTML Admin Template" class="rounded-md" src="dist/images/food-beverage-2.jpg">
                                            </div>
                                        </div>
                                        <div class="block font-medium text-center truncate mt-3">Jacket / Jaket</div>
                                    </div>
                                </a>
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3">
                                    <div class="box rounded-md p-3 relative zoom-in">
                                        <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                                            <div class="absolute top-0 left-0 w-full h-full image-fit">
                                                <img alt="Midone - HTML Admin Template" class="rounded-md" src="dist/images/food-beverage-14.jpg">
                                            </div>
                                        </div>
                                        <div class="block font-medium text-center truncate mt-3">Blouse</div>
                                    </div>
                                </a>
                                
                            </div>
                        </div>
                        <!-- END: Item List -->
                        <!-- BEGIN: Ticket -->
                        <div class="col-span-12 lg:col-span-4">
                            <div class="intro-y pr-1">
                                <div class="box p-2">
                                    <ul class="nav nav-pills" role="tablist">
                                        <li id="ticket-tab" class="nav-item flex-1" role="presentation">
                                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#ticket" type="button" role="tab" aria-controls="ticket" aria-selected="true" > Item(s) </button>
                                        </li>
                                        <li id="details-tab" class="nav-item flex-1" role="presentation">
                                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false" > Detail Transaction </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                                    <div class="box p-2 mt-5">
                                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                                            <div class="max-w-[50%] truncate mr-1">Kemeja</div>
                                            <div class="text-slate-500">x 1</div>
                                            <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i> 
                                            <div class="ml-auto font-medium">Rp 30.000</div>
                                        </a>
                                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                                            <div class="max-w-[50%] truncate mr-1">Jaket</div>
                                            <div class="text-slate-500">x 1</div>
                                            <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i> 
                                            <div class="ml-auto font-medium">Rp 120.000</div>
                                        </a>
                                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                                            <div class="max-w-[50%] truncate mr-1">Simple Dress</div>
                                            <div class="text-slate-500">x 1</div>
                                            <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i> 
                                            <div class="ml-auto font-medium">Rp 80.000</div>
                                        </a>
                                        
                                    </div>
                                    <div class="box flex p-5 mt-5">
                                         <input type="text" class="datepicker form-control w-56 block mx-auto" data-single-mode="true" style="width: 60%;"> 
                                        <button class="btn btn-primary ml-2" style="width: 40%;">Apply Date</button>
                                    </div>
                                    
                                    <div class="box p-5 mt-5">
                                        <div class="flex">
                                            <div class="mr-auto">Subtotal</div>
                                            <div class="font-medium">Rp 230.000</div>
                                        </div>
                                        <div class="flex mt-4">
                                            <div class="mr-auto">Discount</div>
                                            <div class="font-medium text-danger">-Rp0</div>
                                        </div>
                                        
                                        <div class="flex mt-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                                            <div class="mr-auto font-medium text-base">Total Charge</div>
                                            <div class="font-medium text-base">Rp 230.000</div>
                                        </div>
                                    </div>
                                    <div class="flex mt-5">
                                        <button class="btn w-40 border-slate-300 dark:border-darkmode-400 text-slate-500">Cancel Transaction</button>
                                        <button class="btn btn-primary w-40 shadow-md ml-auto">Save Transaction</button>
                                    </div>
                                </div>
                                <div id="details" class="tab-pane" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="box p-5 mt-5">
                                        
                                        <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                            <div>
                                                <div class="text-slate-500">Customer</div>
                                                <div class="mt-1">Mustafa Amien</div>
                                            </div>
                                            <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i> 
                                        </div>
                                        <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 py-5">
                                            <div>
                                                <div class="text-slate-500">Membership</div>
                                                <div class="mt-1">NONE</div>
                                            </div>
                                            <i data-lucide="users" class="w-4 h-4 text-slate-500 ml-auto"></i> 
                                        </div>
                                        <div class="flex items-center pt-5">
                                            <div style="width: 100%;">
                                                <div class="text-slate-500">Note Transaction</div>
                                                <div class="mt-1">
                                                    <textarea class="form-control" style="width: 100%;"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Ticket -->
                    </div>
                    <!-- BEGIN: New Order Modal -->
                    <div id="new-order-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">
                                        New Order
                                    </h2>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12">
                                        <label for="pos-form-1" class="form-label">Name</label>
                                        <input id="pos-form-1" type="text" class="form-control flex-1" placeholder="Customer name">
                                    </div>
                                    <div class="col-span-12">
                                        <label for="pos-form-2" class="form-label">Table</label>
                                        <input id="pos-form-2" type="text" class="form-control flex-1" placeholder="Customer table">
                                    </div>
                                    <div class="col-span-12">
                                        <label for="pos-form-3" class="form-label">Number of People</label>
                                        <input id="pos-form-3" type="text" class="form-control flex-1" placeholder="People">
                                    </div>
                                </div>
                                <div class="modal-footer text-right">
                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                    <button type="button" class="btn btn-primary w-32">Create Ticket</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: New Order Modal -->
                    <!-- BEGIN: Add Item Modal -->
                    <div id="add-item-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">
                                        Crispy Mushroom
                                    </h2>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12">
                                        <label for="pos-form-4" class="form-label">Quantity</label>
                                        <div class="flex mt-2 flex-1">
                                            <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 mr-1">-</button>
                                            <input id="pos-form-4" type="text" class="form-control w-24 text-center" placeholder="Item quantity" value="2">
                                            <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 ml-1">+</button>
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <label for="pos-form-5" class="form-label">Notes</label>
                                        <textarea id="pos-form-5" class="form-control w-full mt-2" placeholder="Item notes"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer text-right">
                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                    <button type="button" class="btn btn-primary w-24">Add Item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Add Item Modal -->
                </div>
                <!-- END: Content -->
            </div>
            <?php include 'appjs.php'; ?>