            <script src="plugin/instascan.min.js"></script>
            <div class="wrapper-box">
               
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            Marking Process
                        </h2>
                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            <button class="btn btn-primary shadow-md mr-2" onclick="getdataprint()" data-tw-toggle="modal" data-tw-target="#print-modal-preview"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print Marking Tag</button>
                            
                        </div>
                    </div>
                    <!-- BEGIN: Transaction Details -->
                    <input type="hidden" id="invoice">
                    <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                            
                            <div class="box p-5 rounded-md ">
                                <div class="font-medium text-base truncate mb-2">INVOICE DATE</div>
                                <input type="date" name="tgl" id="tgl" class="form-control" onchange="getdata()">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                                    
                                    
                                </div>
                                <div id="hasilnya">
                                    
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
                                                <th class="whitespace-nowrap text-center" style="width:150px">PIC</th>
                                            </tr>
                                        </thead>
                                        <tbody id="isidetail">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Transaction Details -->
                </div>
                <!-- END: Content -->

                <!-- END: Add Item Modal -->

                

                     <div class="text-center"> 
                        <a id="success-additem" href="javascript:;" style="opacity:0" data-tw-toggle="modal" data-tw-target="#success-modal-preview" class="btn btn-primary">-</a> 
                        <a id="danger-additem" href="javascript:;" style="opacity:0" data-tw-toggle="modal" data-tw-target="#danger-modal-preview" class="btn btn-danger">-</a> 
                        <a id="danger-pic" href="javascript:;" style="opacity:0" data-tw-toggle="modal" data-tw-target="#pic-item-modal" class="btn btn-danger">-</a> 
                     </div> <!-- END: Modal Toggle --> 

                    <div id="pic-item-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" style="width: 80%;">
                            <div class="modal-content">
                                <form id="savepic" action="#" method="post">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">
                                        <button type="button" style="float: right;" class="btn btn-primary btn-lg btn-block" id="snap">Shoot a picture</button>
                                    </h2>
                                    <div class="text-right">
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Close</button>
                                        <button type="submit" class="btn btn-primary w-32">Save</button>
                                    </div>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3" style="height:400px">
                                    <div class="col-span-6">
                                        <input type="hidden" name="imgBase64" id='dataimage' value="">
                                        <input type="hidden" name="Inv_Number" id="Inv_Number">
                                        <input type="hidden" name="Inv_Item_No" id="Inv_Item_No">
                                        <video id="preview" style="width: 560px; border:2px solid #fff;height: 315px;"></video>
                                        <div style="width: 100% !important;border: 1px solid #1a3176;margin-top: 10px;text-align: center;color: #1a3176;padding: 5px;">LIVE CAMERA</div>
                                            <script type="text/javascript">
                                              let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
                                              scanner.addListener('scan', function (content) {
                                                //alert(content);
                                                var res = content.replace("#:#", "");
                                                //window.location = "../login.php?token="+res;
                                              });
                                              Instascan.Camera.getCameras().then(function (cameras) {
                                                if (cameras.length > 0) {
                                                  if(cameras[1]){ scanner.start(cameras[1]); } else { scanner.start(cameras[0]); }
                                                } else {
                                                  console.error('No cameras found.');
                                                }
                                              }).catch(function (e) {
                                                console.error(e);
                                              });
                                            </script>
                                        
                                    </div>
                                    <div class="col-span-6">
                                        <canvas id="canvas" width="560" height="315"></canvas>
                                        <div style="width: 100% !important;border: 1px solid #1a3176;margin-top: 10px;text-align: center;color: #1a3176;padding: 5px;">RESULT</div>
                                    </div>

                                   
                                  
                                </div>
                                
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="prev-item-modal" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="savepic" action="#" method="post">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">
                                        <button type="button" style="float: right;" class="btn btn-primary btn-lg btn-block">PREVIEW</button>
                                    </h2>
                                    <div class="text-right">
                                        <input type="hidden" id="urlpic" name="">
                                        <input type="hidden" id="urlpicinv" name="">
                                        <button onclick="deletepic()" type="button" class="btn btn-outline-danger w-32 mr-1">DELETE</button>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-32 mr-1">Close</button>
                                    </div>
                                </div>
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3" style="height:auto">
                                    <div class="col-span-12" >
                                        
                                        <div id="imageya"></div>
                                    </div>
                                  

                                   
                                  
                                </div>
                                
                                </form>
                            </div>
                        </div>
                    </div>
                     <!-- BEGIN: Modal Content --> 
                     <div id="print-modal-preview" class="modal" tabindex="-1" aria-hidden="true"> 
                        <div class="modal-dialog"> 
                            <div class="modal-content"> 
                                <div class="modal-body p-0"> 
                                    <div class="p-5 text-center"> 
                                        <div id="data-print"></div> 
                                    </div> 
                                    <div class="px-5 pb-8 text-center"> 
                                        <button type="button" class="btn btn-primary w-36" onclick="printAll()" target="_blank"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print All </button> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                     </div> 
                    
                     <div id="success-modal-preview" class="modal" tabindex="-1" aria-hidden="true"> 
                        <div class="modal-dialog"> 
                            <div class="modal-content"> 
                                <div class="modal-body p-0"> 
                                    <div class="p-5 text-center"> 
                                        <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i> 
                                        <div class="text-3xl mt-5">Save Success!</div> 
                                        <div class="text-slate-500 mt-2">Data saved</div> 
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
            <?php include 'appjs.php'; ?>
            <script type="text/javascript">
                
               function getdata(){
                    var tgl     = document.getElementById('tgl').value;
                    $.ajax({
                        url:'function/marking?menu=data',
                        type:'POST',
                        dataType:'html',
                        data:{
                          tgl: tgl,
                        },
                        success:function (response) {
                            $('#hasilnya').html(response);
                        },

                    })
                }

                function deletepic(){
                    var urlpic     = document.getElementById('urlpic').value;
                    var urlpicinv     = document.getElementById('urlpicinv').value;
                    $.ajax({
                        url:'function/marking?menu=deletepic',
                        type:'POST',
                        dataType:'html',
                        data:{
                          urlpic: urlpic,
                        },
                        success:function (response) {
                            document.getElementById('success-additem').click();
                            document.getElementById('tmark-'+urlpicinv).click();
                        },

                    })
                }
                
                function printAll() {
                    var invoice = document.getElementById('invoice').value;
                    window.open('function/print?type=marker&invoice='+invoice+'&item_no=1', '_blank');
                }

                function printItem(invoice, item_no) {
                    window.open('function/print?type=marker&invoice='+invoice+'&item_no='+item_no, '_blank');
                }

                function getdataprint(){
                    var invoice = document.getElementById('invoice').value;
                    $.ajax({
                        url:'function/marking?menu=data-print',
                        type:'POST',
                        dataType:'html',
                        data:{
                          invoice: invoice,
                        },
                        success:function (response) {
                            $('#data-print').html(response);
                        },

                    })
                }
                
                function isidetail(data){
                    $.ajax({
                        url:'function/marking?menu=detail',
                        type:'POST',
                        dataType:'html',
                        data:{
                          data: data,
                        },
                        success:function (response) {
                            $('#invoice').val(data);
                            $('#isidetail').html(response);
                        },

                    })
                }
                function ubahnote(data){
                    const myArray   = data.split("-");
                    var data        = document.getElementById('Item_Note-'+myArray[0]).value;
                    var inv         = myArray[1];
                    var id          = myArray[0];
                    $.ajax({
                        url:'function/marking?menu=ubahnote',
                        type:'POST',
                        dataType:'html',
                        data:{
                          data: data,
                          id: id
                        },
                        success:function (response) {
                            isidetail(inv);
                        },

                    })
                }

                function modalpic(inv, item){
                    document.getElementById('Inv_Number').value = inv;
                    document.getElementById('Inv_Item_No').value = item;
                }

                 function openprev(barcode,inv){

                    document.getElementById('imageya').innerHTML = "<img style='width:100%' alt='testImage' src='media/images/"+barcode+"'> </img>";
                    document.getElementById('urlpic').value = "media/images/"+barcode;
                    document.getElementById('urlpicinv').value = inv;
                    //document.getElementById('openprev').click();
                 }


                var frm = $('#savepic');
                frm.submit(function (e) {
                  e.preventDefault(e);

                  var formData = new FormData(this);

                  var dd = JSON.stringify(Object.fromEntries(formData));
                  obj = JSON.parse(dd);
                  var jenismod = obj.jenismod;

                  var url = 'function/marking?menu=simpangambar';

                  $.ajax({
                    async: true,
                    type: frm.attr('method'),
                    url: url,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,

                    success: function (data) {
                      console.log("success");
                      document.getElementById('success-additem').click();
                      document.getElementById('tmark-'+data).click();
                    },
                    error: function(request, status, error) {
                      console.log("error")
                    }
                  });
                });
            </script>


            <script>
                'use strict';

                const video = document.getElementById('preview');
                const canvas = document.getElementById('canvas');
                const snap = document.getElementById("snap");
                const errorMsgElement = document.querySelector('span#errorMsg');
                
                const constraints = {
                  audio: true,
                  video: {
                    width: 1280, height: 720
                  }
                };
                
                // Access webcam
                async function init() {
                  try {
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    handleSuccess(stream);
                  } catch (e) {
                    errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
                  }
                }
                
                // Success
                function handleSuccess(stream) {
                  window.stream = stream;
                  video.srcObject = stream;
                }
                
                // Load init
                init();
                
                // Draw image
                var context = canvas.getContext('2d');
                snap.addEventListener("click", function() {
                    context.drawImage(video, 0, 0, 560, 315);
                    var dataURL = canvas.toDataURL();
                    document.getElementById("dataimage").value = dataURL;
                });
            </script>