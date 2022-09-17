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
                                    <input style="width: 100%;" type="text" class="form-control py-3 px-4 w-full lg:w-64 box pr-10" placeholder="Search item..." id="inputcari">
                                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-slate-500" data-lucide="search"></i> 
                                </div>
                                
                            </div>
                           
                            <div class="grid grid-cols-12 gap-5 mt-5 pt-5 border-t" id="hasilcari">
                                <?php
                                    $query = mysqli_query($conn,"SELECT * from Master_Item order by Item_Name ASC LIMIT 8");
                                    while ($dataitem = mysqli_fetch_array($query)) {
                                    
                                ?>
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3" onclick="tambahitem('<?php echo $dataitem['Item_ID'] ?>','<?php echo $dataitem['Item_Name'] ?>','<?php echo $dataitem['Item_Price'] ?>','<?php echo $dataitem['Item_Pcs'] ?>')">
                                    <div class="box rounded-md p-3 relative zoom-in">
                                        <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                                            <div class="absolute top-0 left-0 w-full h-full image-fit">
                                                <img alt="My Cherree Laundry" class="rounded-md" src="src/images/item/<?php echo $dataitem['Item_ID'] ?>.webp" onerror="this.onerror=null; this.src='src/images/item/noimage.svg'">
                                            </div>
                                        </div>
                                        <div class="block font-medium text-center mt-3"><?php echo $dataitem['Item_Name'] ?></div>
                                        <center>
                                        <button class="btn btn-sm btn-outline-primary inline-block mt-1"><?php echo $dataitem['Item_Category'] ?></button>
                                        </center>
                                        
                                    </div>
                                </a>

                                <?php } ?>
                                
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
                                    <div class="box p-2 mt-5" id="hasilcart">

                                        
                                        
                                        
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
                        <div class="modal-dialog" style="width: 600px;">
                            <form method="POST" action="function/saveitem_new" id="simpanitem">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto" id="Item_Name_Tampil">
                                        -
                                    </h2>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-6">
                                        <label for="pos-form-4" class="form-label">Quantity</label>
                                        <div class="flex mt-1 flex-1">
                                            <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 mr-1" onclick="updateitemqty('minus')">-</button>
                                            <input id="item_qty" name="item_qty" type="text" class="form-control w-24 text-center" placeholder="Item quantity" onchange="updateitemprice()" value="1">
                                            <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 ml-1" onclick="updateitemqty('plus')">+</button>
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                         <!-- BEGIN: Basic Select -->
                                         <label class="form-label">Colour</label>
                                         <div class="mt-1">
                                             <select name="colour" data-placeholder="Select your favorite actors" class="tom-select w-full">
                                                <?php 
                                                    $querycolor = mysqli_query($conn,"SELECT * from Master_Colour WHERE Colour_Status='Y' order by Colour_Name asc");
                                                    while($datacolour = mysqli_fetch_assoc($querycolor)){
                                                ?>
                                                    <option value="<?php echo $datacolour['Colour_ID'] ?>+<?php echo $datacolour['Colour_Name'] ?>"><?php echo $datacolour['Colour_Name'] ?></option>
                                                <?php } ?>
                                             </select> 
                                         </div>
                                    </div>
                                    <div class="col-span-6">
                                         <!-- BEGIN: Basic Select -->
                                         <label class="form-label">Brand</label>
                                         <div class="mt-1">
                                             <select name="brand" data-placeholder="Select your favorite actors" class="tom-select w-full">
                                                <?php 
                                                    $querybrand = mysqli_query($conn,"SELECT * from Master_Brand WHERE Brand_Status='Y' order by Brand_Name asc");
                                                    while($databrand = mysqli_fetch_assoc($querybrand)){
                                                ?>
                                                    <option value="<?php echo $databrand['Brand_ID'] ?>+<?php echo $databrand['Brand_Name'] ?>"><?php echo $databrand['Brand_Name'] ?></option>
                                                <?php } ?>
                                             </select> 
                                         </div>
                                    </div>
                                    <div class="col-span-6">
                                        <label for="regular-form-1" class="form-label">Size</label> 
                                        <div class="mt-1">
                                            <input type="text" name="size" id="item_size" class="form-control" placeholder="Input Size">
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <label for="pos-form-5" class="form-label">Condition</label>
                                        <textarea id="item_note" name="note" class="form-control w-full mt-2" placeholder="Item notes"></textarea>
                                    </div>
                                    <div class="col-span-12">
                                        <hr>
                                    </div>
                                    
                                    <div class="col-span-6">
                                        <div class="input-group">
                                             <div id="input-group-email" class="input-group-text">Rp</div> 
                                             <input type="number" onchange="updateitemprice()" name="adjustment" id="adjustment" class="form-control uang" placeholder="50.000"  aria-describedby="input-group-email">

                                             
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                       <input id="note_adjustment" name="note_adjustment" type="text" class="form-control" placeholder="Note Adjustment">
                                       <!-- kirimdata -->
                                             
                                             
                                             <input type="hidden" name="Item_ID" id="Item_ID" value="">
                                             <input type="hidden" name="Item_Name" id="Item_Name" value="">
                                             <input type="hidden" name="Item_Price" id="Item_Price" value="">
                                             <input type="hidden" name="Item_Pcs" id="Item_Pcs" value="">
                                             <input type="text" name="Total_Price" id="Total_Price" value="">

                                            
                                             <!-- kirimdata -->
                                    </div>
                                </div>
                                
                                <div class="modal-footer text-right">
                                    <button class="btn btn-outline-success inline-block mr-1 mb-2" style="float: left;">Price Rp <c id="pricetampil">300.000</c></button>
                                    <button type="button" id="closemodalitemnew" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                    <button type="submit" class="btn btn-primary w-24">Add Item</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- END: Add Item Modal -->
                     <div class="text-center"> 
                        <a id="success-additem" href="javascript:;" style="opacity:0" data-tw-toggle="modal" data-tw-target="#success-modal-preview" class="btn btn-primary">-</a> 
                     </div> <!-- END: Modal Toggle --> 
                     <!-- BEGIN: Modal Content --> 
                     <div id="success-modal-preview" class="modal" tabindex="-1" aria-hidden="true"> 
                        <div class="modal-dialog"> 
                            <div class="modal-content"> 
                                <div class="modal-body p-0"> 
                                    <div class="p-5 text-center"> 
                                        <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i> 
                                        <div class="text-3xl mt-5">Save Success!</div> 
                                        <div class="text-slate-500 mt-2">New item saved.</div> 
                                    </div> 
                                    <div class="px-5 pb-8 text-center"> 
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                     </div> <!-- END: Modal Content --> 
                </div>
                <!-- END: Content -->
            </div>

            <?php include 'appjs.php'; ?>
            <script type="text/javascript">
                getcart();

                $(document).ready(function(e) {
                    var timeout;
                    var delay = 600;   // 2 seconds

                    $('#inputcari').keyup(function(e) {
                        //$('#status').html("User started typing!");
                        if(timeout) {
                            clearTimeout(timeout);
                        }
                        timeout = setTimeout(function() {
                            myFunction();
                        }, delay);
                    });

                    function myFunction() {
                        var keyword = document.getElementById('inputcari').value;
                        $.ajax({
                            url:'function/items?menu=cariitem',
                            type:'POST',
                            dataType:'html',
                            data:'keyword='+keyword,
                            success:function (response) {
                                $('#hasilcari').html(response);
                            },

                        })
                    }
                });

                $(document).ready(function(){
                    // Format mata uang.
                    $( '.uang' ).mask('000.000.000', {reverse: true});
                }) 


                function tambahitem(Item_ID,Item_Name,Item_Price,Item_Pcs){
                    // RESET DATA
                    document.getElementById('item_qty').value = '1';
                    document.getElementById('item_size').value = '';
                    document.getElementById('item_note').value = '';
                    document.getElementById('adjustment').value = '';
                    document.getElementById('note_adjustment').value = '';
                    //RESET DATA

                    document.getElementById('Item_ID').value = Item_ID;
                    document.getElementById('Item_Name').value = Item_Name;
                    document.getElementById('Item_Price').value = Item_Price;
                    document.getElementById('Item_Pcs').value = Item_Pcs;
                    document.getElementById('Total_Price').value = Item_Price;
                    document.getElementById('Item_Name_Tampil').innerHTML = Item_Name;
                    document.getElementById('pricetampil').innerHTML = Item_Price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");;
                }

                function updateitemqty(data){
                    if (data=='plus') {
                        var item_qty = document.getElementById('item_qty').value;
                        var item_qty_update = parseInt(item_qty) + 1;
                        document.getElementById('item_qty').value = item_qty_update;
                    }else if(data=='minus'){
                        var item_qty = document.getElementById('item_qty').value;
                        var item_qty_update = parseInt(item_qty) - 1;
                        if(item_qty_update < 1){ item_qty_update = '1';}
                        document.getElementById('item_qty').value = item_qty_update;
                    }
                    updateitemprice();
                }

                function updateitemprice(){
                    var Item_Price = document.getElementById('Item_Price').value;
                    var item_qty = document.getElementById('item_qty').value
                    var adjustment = document.getElementById('adjustment').value;
                    if (adjustment=='') {adjustment='0';}

                    var priceupdate = (parseInt(Item_Price) * parseInt(item_qty) + parseInt(adjustment.replace(".", "")));

                    document.getElementById('Total_Price').value = priceupdate;
                    document.getElementById('pricetampil').innerHTML = priceupdate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");;
                }

                function getcart(){
                   
                    $.ajax({
                        url:'function/getcart',
                        type:'POST',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilcart').html(response);
                        },

                    })
                }

                
                var frm = $('#simpanitem');
                frm.submit(function (e) {
                  e.preventDefault(e);

                  var formData = new FormData(this);

                  $.ajax({
                    async: true,
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,

                    success: function (data) {
                      console.log("success");
                      document.getElementById('closemodalitemnew').click();
                      getcart();
                      document.getElementById('success-additem').click();
                    },
                    error: function(request, status, error) {
                      console.log("error")
                    }
                  });
                });
                
            </script>