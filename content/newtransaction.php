
<div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            New Invoice
                        </h2>

                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#new-order-modal" class="btn btn-primary shadow-md mr-2"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> <c id="tombolcust"><?php if (!isset($_SESSION['Cust_No'])) { echo "SELECT CUSTOMER";} else{ echo "UPDATE CUSTOMER"; } ?></c> </a> 
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
                                    $query = mysqli_query($conn,"SELECT * from Master_Item WHERE Item_Status='Y' order by Item_Name ASC LIMIT 8");
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
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                              
                                    <form method="POST" action="function/transaksi_item?menu=savetransaksi" id="simpantransaksi">
                                    <div class="box p-2 mt-5">
                                        <div class="flex items-center border-b border-slate-200 dark:border-darkmode-400 p-2">
                                            <div>
                                                <div class="text-slate-500">Customer</div>
                                                <div class="mt-1"><b style="font-size: 16px;" id="namacustomer"><?php if (isset($_SESSION['Cust_No'])) {
                                                    echo $_SESSION['Cust_Nama'];
                                                }else{ echo 'CUSTOMER NOT SELECTED'; } ?></b><br><c id="alamatcustomer"><?php if (isset($_SESSION['Cust_Alamat'])) {
                                                    echo $_SESSION['Cust_Alamat'];
                                                } ?></c><br><c id="telpcustomer"><?php if (isset($_SESSION['Cust_Telp'])) {
                                                    echo $_SESSION['Cust_Telp'];
                                                } ?></c></div>
                                                <input type="hidden" name="Cust_No" id="Cust_No_Data" value="<?php if (isset($_SESSION['Cust_No'])) {
                                                    echo $_SESSION['Cust_No'];
                                                } ?>">
                                                <input type="hidden" name="Cust_Nama" id="Cust_Nama_Data" value="<?php if (isset($_SESSION['Cust_No'])) {
                                                    echo $_SESSION['Cust_Nama'];
                                                } ?>">
                                                <input type="hidden" name="Cust_Telp" id="Cust_Telp_Data" value="<?php if (isset($_SESSION['Cust_Telp'])) {
                                                    echo $_SESSION['Cust_Telp'];
                                                } ?>">
                                                <input type="hidden" name="Cust_Alamat" id="Cust_Alamat_Data" value="<?php if (isset($_SESSION['Cust_Alamat'])) {
                                                    echo $_SESSION['Cust_Alamat'];
                                                } ?>">
                                                <input type="hidden" name="Discount_No" id="Discount_No_Data" value="<?php if (isset($_SESSION['Discount_No'])) {
                                                    echo $_SESSION['Discount_No'];
                                                } ?>">
                                            </div>
                                            <i data-lucide="user" class="w-4 h-4 text-slate-500 ml-auto"></i> 
                                        </div>
                                        <div class="mt-2" id="hasilcart">
                                            
                                        </div>
                                        
                                        
                                        
                                    </div>
                                  
                                    
                                    <div class="box p-5 mt-5" id="totalan">

                                        
                                    </div>
                                    <div class="box p-5 mt-5">
                                        <div style="width: 100%;">
                                            <div class="text-slate-500">Ready Date</div>
                                            <div class="mt-1">
                                                <input type="date" name="Inv_Tg_Selesai" class=" form-control block mx-auto" onchange="gantitgl()" data-single-mode="true" required> 
                                            </div>
                                            
                                        </div> 
                                        <div class="mt-2" style="width: 100%;">
                                            <div class="text-slate-500">Note Transaction</div>
                                            <div class="mt-1">
                                                <textarea id="Note" name="Note" class="form-control" style="width: 100%;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex mt-5">
                                        <button class="btn w-40 border-slate-300 dark:border-darkmode-400 text-slate-500">Cancel Transaction</button>
                                        <button class="btn btn-primary w-40 shadow-md ml-auto">Save Transaction</button>
                                    </div>
                                    </form>

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
                                        New Order Customer
                                    </h2>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12">
                                         <label class="form-label">Customers</label>
                                         <div class="mt-1">
                                             <select name="customer" id="customer" data-placeholder="Select Customers" class="tom-select w-full" onchange="cekcust()">
                                                <option>-- SELECT CUSTOMER --</option>
                                                <?php 
                                                    $querycust = mysqli_query($conn,"SELECT * from Customer WHERE Cust_Status='Y' order by Cust_Nama asc");
                                                    while($datacust = mysqli_fetch_assoc($querycust)){
                                                ?>
                                                    <option value="<?php echo $datacust['Cust_No'] ?>+<?php echo $datacust['Cust_Nama'] ?>"><?php echo $datacust['Cust_Nama'] ?> | <?php echo $datacust['Cust_Alamat'] ?></option>
                                                <?php } ?>
                                             </select> 
                                         </div>
                                    </div>
                                    <div class="col-span-12">
                                        <input type="text" name="telp" id="telp" class="form-control" placeholder="Input Phone">
                                    </div>
                                    <div class="col-span-12">
                                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Input Address">
                                    </div>
                                    <div class="col-span-12">
                                        <button class="btn btn-outline-primary w-full inline-block mr-1 mb-2" id="hasilcekmember">-</button>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer text-right">
                                    <button type="button" id="closemodalcustomer" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Cancel</button>
                                    <button type="button" onclick="pilihcust()" class="btn btn-primary w-32">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: New Order Modal -->
                    <!-- BEGIN: Add Item Modal -->
                    <div id="add-item-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" style="width: 600px;">
                            <form method="POST" action="function/transaksi_item?menu=savenew" id="simpanitem">
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
                                             <select name="colour" data-placeholder="Select Colour" class="tom-select w-full">
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
                                             <select name="brand" data-placeholder="Select Brand" class="tom-select w-full">
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
                                            <input type="text" name="size" id="item_size" autocomplete="off" class="form-control" placeholder="Input Size">
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
                                        <label for="regular-form-1" class="form-label">Discount</label>
                                        <div class="input-group">
                                            <input type="text" max="100" onkeyup="updateitempersen()" name="disc_persen" id="disc_persen" class="form-control uang" placeholder="10"  aria-describedby="input-group-email">                                             
                                            <div id="input-group-email" class="input-group-text">%</div> 
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                        <label for="regular-form-1" class="form-label text-white">Discount</label>
                                        <div class="input-group">
                                             <div id="input-group-email" class="input-group-text">Rp</div> 
                                             <input type="number" onkeyup="updateitemprice()" name="disc_rupiah" id="disc_rupiah" class="form-control uang" placeholder="50.000"  aria-describedby="input-group-email">                                             
                                        </div>
                                    </div>
                                    
                                    <div class="col-span-6">
                                        <label for="regular-form-1" class="form-label">Adjusment</label>
                                        <div class="input-group">
                                             <div id="input-group-email" class="input-group-text">Rp</div> 
                                             <input type="number" onkeyup="updateitemprice()" name="adjustment" id="adjustment" class="form-control uang" placeholder="50.000"  aria-describedby="input-group-email">                                             
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                       <label  for="regular-form-1" class="form-label text-white">Adjusment</label>
                                        <input id="note_adjustment" name="note_adjustment" type="text" class="form-control" placeholder="Note Adjustment">
                                       <!-- kirimdata -->
                                             
                                             
                                             <input type="hidden" name="Item_ID" id="Item_ID" value="">
                                             <input type="hidden" name="Item_Name" id="Item_Name" value="">
                                             <input type="hidden" name="Item_Price" id="Item_Price" value="">
                                             <input type="hidden" name="Item_Pcs" id="Item_Pcs" value="">
                                             <input type="hidden" name="Total_Price" id="Total_Price" value="">

                                            
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
                    <div id="add-item-modal-edit" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" style="width: 600px;">
                            <form method="POST" action="function/transaksi_item?menu=saveedit" id="simpanitemedit">
                            <div class="modal-content" id="hasiledit">
                                
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- END: Add Item Modal -->
                     <div class="text-center"> 
                        <a id="success-additem" href="javascript:;" style="opacity:0" data-tw-toggle="modal" data-tw-target="#success-modal-preview" class="btn btn-primary">-</a> 
                        <a id="danger-additem" href="javascript:;" style="opacity:0" data-tw-toggle="modal" data-tw-target="#danger-modal-preview" class="btn btn-danger">-</a> 
                     </div> <!-- END: Modal Toggle --> 
                     <!-- BEGIN: Modal Content --> 
                     <div id="success-modal-preview" class="modal" tabindex="-1" aria-hidden="true"> 
                        <div class="modal-dialog"> 
                            <div class="modal-content"> 
                                <div class="modal-body p-0"> 
                                    <div class="p-5 text-center"> 
                                        <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i> 
                                        <div class="text-3xl mt-5">Save Success!</div> 
                                        <div class="text-slate-500 mt-2">New item saved. Please wait a moment...</div> 
                                    </div> 
                                    <div class="px-5 pb-8 text-center"> 
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                     </div> 
                     <div id="danger-modal-preview" class="modal" tabindex="-1" aria-hidden="true"> 
                        <div class="modal-dialog"> 
                            <div class="modal-content"> 
                                <div class="modal-body p-0"> 
                                    <div class="p-5 text-center"> 
                                        <i data-lucide="check-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i> 
                                        <div class="text-3xl mt-5">Delete Success!</div> 
                                        <div class="text-slate-500 mt-2">Item deleted.</div> 
                                    </div> 
                                    <div class="px-5 pb-8 text-center"> 
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                     </div> 
                     <!-- END: Modal Content --> 
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

                function cekcust(){
                    var id = document.getElementById('customer').value;
                    $.ajax({
                        url:'function/transaksi_item?menu=cekcust',
                        type:'POST',
                        data:'id='+id,
                        dataType:'html',
                        success:function (response) {
                            var json = response,
                            obj = JSON.parse(json);
                            $('#telp').val(obj.Cust_Telp);
                            $('#alamat').val(obj.Cust_Alamat);
                            document.getElementById('hasilcekmember').innerHTML = obj.member;
                        },

                    })
                }
                function pilihcust(){
                    var id           = document.getElementById('customer').value;
                    var Cust_Telp    = document.getElementById('telp').value;
                    var Cust_Alamat  = document.getElementById('alamat').value;
                    var Cust_No_Data = id.split("+");
                    $.ajax({
                        url:'function/transaksi_item?menu=pilihcust',
                        type:'POST',
                        data:{
                          id: id,
                          Cust_Telp: Cust_Telp,
                          Cust_Alamat: Cust_Alamat,
                        },
                        success:function (response) {
                            var json = response,
                            obj = JSON.parse(json);
                            document.getElementById('closemodalcustomer').click();
                            document.getElementById('Cust_No_Data').value = Cust_No_Data[0];
                            document.getElementById('Cust_Nama_Data').value = Cust_No_Data[1];
                            document.getElementById('namacustomer').innerHTML = Cust_No_Data[1];
                            document.getElementById('Cust_Telp_Data').value = Cust_Telp;
                            document.getElementById('Cust_Alamat_Data').value = Cust_Alamat;
                            document.getElementById('Discount_No_Data').value = obj.Discount_No;
                            document.getElementById('alamatcustomer').innerHTML = Cust_Alamat;
                            document.getElementById('telpcustomer').innerHTML = Cust_Telp;
                            
                            
                            document.getElementById('tombolcust').innerHTML = "UPDATE CUSTOMER";

                            getcart();
                        },

                    })
                }


                function gantitgl(){
                    document.getElementById('Note').focus();
                }

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

                function updateitempersen(){
                    var Item_Price = document.getElementById('Item_Price').value;
                    var item_qty = document.getElementById('item_qty').value
                    var persen = document.getElementById('disc_persen').value;
                    if (persen=='') {persen='0';}
                    
                    var pengurang = (parseInt(Item_Price) * parseInt(item_qty) * (parseInt(persen.replace(".", "")) / parseInt(100)));
                    var priceupdate = (parseInt(Item_Price) * parseInt(item_qty) - pengurang);

                    document.getElementById('disc_rupiah').value = pengurang.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    document.getElementById('Total_Price').value = priceupdate;
                    document.getElementById('pricetampil').innerHTML = priceupdate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }

                function updateitemprice(){
                    var Item_Price = document.getElementById('Item_Price').value;
                    var item_qty = document.getElementById('item_qty').value
                    var rupiah = document.getElementById('disc_rupiah').value;
                    var adjustment = document.getElementById('adjustment').value;
                    
                    adjustment  = (adjustment == '') ? '0' : adjustment;
                    rupiah      = (rupiah == '') ? '0' : rupiah;
                    
                    var pengurang = parseInt(rupiah.replace(".", ""));
                    var priceupdate = (parseInt(Item_Price) * parseInt(item_qty) - pengurang) + parseInt(adjustment.replace(".", ""));

                    document.getElementById('Total_Price').value = priceupdate;
                    document.getElementById('pricetampil').innerHTML = priceupdate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
                
                function updateitemqty1(data){
                    if (data=='plus') {
                        var item_qty = document.getElementById('item_qty_edit').value;
                        var item_qty_update = parseInt(item_qty) + 1;
                        document.getElementById('item_qty_edit').value = item_qty_update;
                    }else if(data=='minus'){
                        var item_qty = document.getElementById('item_qty_edit').value;
                        var item_qty_update = parseInt(item_qty) - 1;
                        if(item_qty_update < 1){ item_qty_update = '1';}
                        document.getElementById('item_qty_edit').value = item_qty_update;
                    }
                    updateitemprice1();
                }

                function updateitemprice1(){
                    var Item_Price = document.getElementById('Item_Price_edit').value;
                    var item_qty = document.getElementById('item_qty_edit').value
                    var adjustment = document.getElementById('adjustment_edit').value;
                    if (adjustment=='') {adjustment='0';}

                    var priceupdate = (parseInt(Item_Price) * parseInt(item_qty) + parseInt(adjustment.replace(".", "")));

                    document.getElementById('Total_Price_edit').value = priceupdate;
                    document.getElementById('pricetampiledit').innerHTML = priceupdate.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");;
                }


                function getcart(){
                   
                    $.ajax({
                        url:'function/transaksi_item?menu=getitem',
                        type:'POST',
                        dataType:'html',
                        success:function (response) {
                            $('#hasilcart').html(response);

                        },

                    })

                    $.ajax({
                        url:'function/transaksi_item?menu=totalan',
                        type:'POST',
                        dataType:'html',
                        success:function (response) {
                            $('#totalan').html(response);

                        },

                    })
                }



           
                
                function hapusitem(id){
                   
                    $.ajax({
                        url:'function/transaksi_item?menu=hapusitem',
                        type:'POST',
                        data:'id='+id,
                        dataType:'html',
                        success:function (response) {
                            document.getElementById('closemodalitemnewedit').click();
                            getcart();
                            document.getElementById('danger-additem').click();
                        },

                    })
                }

                function edititem(id){
                    $.ajax({
                        url:'function/transaksi_item?menu=edititem',
                        type:'POST',
                        data:'id='+id,
                        dataType:'html',
                        success:function (response) {
                            $('#hasiledit').html(response);
                          
                            
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

                var frm2 = $('#simpanitemedit');
                frm2.submit(function (e) {
                  e.preventDefault(e);

                  var formData = new FormData(this);

                  $.ajax({
                    async: true,
                    type: frm2.attr('method'),
                    url: frm2.attr('action'),
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,

                    success: function (data) {
                      console.log("success");
                      document.getElementById('closemodalitemnewedit').click();
                      getcart();
                      document.getElementById('success-additem').click();
                    },
                    error: function(request, status, error) {
                      console.log("error")
                    }
                  });
                });

                var frm3 = $('#simpantransaksi');
                frm3.submit(function (e) {
                  e.preventDefault(e);

                  var formData = new FormData(this);

                  $.ajax({
                    async: true,
                    type: frm3.attr('method'),
                    url: frm3.attr('action'),
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,

                    success: function (data) {
                      if(data=='PILIHCUSTOMER'){
                        alert('Please select customer before save transaction');
                      }else{
                          console.log("success");
                          document.getElementById('success-additem').click();
                          setTimeout(function() { window.location.reload(); }, 2000);
                      }
                      
                    },
                    error: function(request, status, error) {
                      console.log("error")
                    }
                  });
                });
                
            </script>