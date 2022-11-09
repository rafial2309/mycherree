<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

if ($_GET['menu'] == 'data' ) {
	
	$tgl = $_POST['tgl'];

	$queryinv = mysqli_query($conn,"SELECT Inv_Number,Cust_Nama,Payment_Amount from Invoice WHERE Status_Inv!='C' AND Inv_Tgl_Masuk='$tgl'");

    while ($datainv = mysqli_fetch_assoc($queryinv)) { ?>

    	<div class="intro-x">
            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                    <img alt="Midone - HTML Admin Template" src="dist/images/receipt.png">
                </div>
                <div class="ml-4 mr-auto">
                    <div class="font-medium">#<?php echo $datainv['Inv_Number'] ?></div>
                    <div class="text-slate-500 text-xs mt-0.5"><?php echo $datainv['Cust_Nama'] ?></div>
                </div>
                <div class="text-success">
                    <button class="btn btn-primary shadow-md mr-2" id="tmark-<?php echo $datainv['Inv_Number'] ?>" onclick="isidetail('<?php echo $datainv['Inv_Number'] ?>')"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="tag" data-lucide="tag" class="lucide lucide-tag block mx-auto"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> &nbsp; MARK</button>
                </div>
            </div>
        </div>

    <?php }
} elseif ($_GET['menu'] == 'data-print' ) {
	$no         = 1;
	$invoice    = $_POST['invoice'];

	$queryinv = mysqli_query($conn,"SELECT * from Invoice_Item WHERE Inv_Number='$invoice'");

    echo "
    <table class='table table-bordered'>
        <tr>
            <th>No</th>
            <th>Nama Item</th>
            <th>Action</th>
        </tr>
    ";
    while ($data = mysqli_fetch_assoc($queryinv)) { 
        $invoice = $data['Inv_Number'];
        $item_no = $data['Item_No'];
        ?>

        <tr>
            <td><?= $no ?></td>
            <td><?= $data['Deskripsi'] ?></td>
            <td>
                <button class="btn btn-primary shadow-md mr-2" onclick="printItem('<?= $invoice ?>','<?= $item_no?>')" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="printer" data-lucide="printer" class="lucide lucide-printer w-4 h-4 mr-2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></button>
            </td>
        </tr>

    <?php 
        $no++;
    }
    echo "</table>";
} elseif ($_GET['menu'] == 'detail') {
	$data = $_POST['data'];

	$queryitem = mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='$data'");
    while($dataitem=mysqli_fetch_assoc($queryitem)){ ?>

    	<tr>
            <td><?php echo $dataitem['Item_No'] ?></td>
            <td>
                <?php echo $dataitem['Deskripsi'] ?>
            </td>
           
            <td class="text-right"><?php echo $dataitem['Qty'] ?></td>
            <td class="text-right">Rp <?php echo number_format($dataitem['Total_Price'] ,0,",",".")?></td>
            <td class="text-center">
                
                <button class="btn btn-success shadow-md mr-2" onclick="modalpic('<?php echo $dataitem['Inv_Number'] ?>','<?php echo $dataitem['Inv_Item_No'] ?>')" data-tw-toggle="modal" data-tw-target="#pic-item-modal" style="color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="camera" data-lucide="camera" class="lucide lucide-camera block mx-auto w-4 h-4 mr-2"><path d="M14.5 4h-5L7 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle></svg> IMAGE</button>
                
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4">
                <div class="row">
                    <div class="grid grid-cols-12 gap-4 gap-y-5">
                    
                        <?php 
                        $queryfoto = mysqli_query($conn, "SELECT foto FROM Invoice_Foto WHERE Inv_Item_No='$dataitem[Inv_Item_No]'");
                        while($datafoto = mysqli_fetch_assoc($queryfoto)) { ?>
                        <div class="col-span-2">
                            <div class="card no-b">
                                <div>
                                    <a onclick="openprev('<?php echo $dataitem['Inv_Item_No']; ?>/<?php echo $datafoto['foto']; ?>')" href="javascript:;" data-tw-toggle="modal" data-tw-target="#prev-item-modal"  class="progressive replace">
                                        <img id="myImg" src="media/images/<?php echo $dataitem['Inv_Item_No']; ?>/<?php echo $datafoto['foto']; ?>" class="preview" alt="image" />
                                     </a>
                                     
                                </div>
                            </div>
                        </div>
                        <?php } ?> 
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4">
            	<strong style="color: crimson;">Marking Note: </strong><br>
            	<input type="text" id="Item_Note-<?php echo $dataitem['Inv_Item_No']; ?>" onchange="ubahnote('<?php echo $dataitem['Inv_Item_No']; ?>-<?php echo $dataitem['Inv_Number']; ?>')" class="form-control mt-1" value="<?php echo $dataitem['Item_Note'] ?>"> <br>
            </td>
        </tr>

    <?php }
}elseif ($_GET['menu'] == 'ubahnote') {
	$data 	= $_POST['data'];
	$id 	= $_POST['id'];

	mysqli_query($conn,"UPDATE Invoice_Item SET Item_Note='$data' WHERE Inv_Item_No='$id'");

}elseif ($_GET['menu'] == 'simpangambar'){

        
        date_default_timezone_set('Asia/Jakarta'); 
        $datetimenow  = date('Y-m-d-H-i-s');
        $datetimenow2 = date('d-m-Y H:i:s');
        $Staff_Name   = $_SESSION['Staff_Name'];
          
          $Inv_Number   = $_POST['Inv_Number'];
          $Inv_Item_No  = $_POST['Inv_Item_No'];


        $img = $_POST['imgBase64'];
        
        $history = $Staff_Name . "-" . $datetimenow;


        if (!file_exists('../media/images/' . $Inv_Item_No)) {
            mkdir('../media/images/' . $Inv_Item_No, 0777, true);
        }
        // requires php5
        define('UPLOAD_DIR', '../media/images/' . $Inv_Item_No . '/');
        

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . $history . '.png';
        $success = file_put_contents($file, $data);
        //print $success ? $file : 'Unable to save the file.';

        $namafile = $history . ".png";


        mysqli_query($conn, "INSERT into Invoice_Foto values(0,'','$Inv_Number','$namafile','$Inv_Item_No')");
        echo $Inv_Number;
}