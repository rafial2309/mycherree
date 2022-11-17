<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$Staff_ID 			= $_SESSION['Staff_ID'];
$Staff_Name 		= $_SESSION['Staff_Name'];

function angka_pembulatan($angka,$digit,$minimal)
{
 if (substr($angka, -2)=='00') {
     return $angka;
 }else{
    $digitvalue=substr($angka,-($digit));  $bulat=0;
     $nolnol="";
     for($i=1;$i<=$digit;$i++)
     {
     $nolnol.="0";
     }
     if($digitvalue<$minimal && $digit!=$nolnol)
     {  $x1=$minimal-$digitvalue;
     $bulat=$angka+$x1;
     }else{
     $bulat=$angka;
     }
     return $bulat; 
 } 
}

if ($_GET['menu'] == 'getitem' ) {
	
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
		$query = mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='$id' AND Total_Price!='0'");
	} else {
		$query = mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='' AND Staff_ID='$Staff_ID'");
	}
	while($data = mysqli_fetch_assoc($query)){
	?>
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal-edit" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md" onclick="edititem('<?php echo $data['Inv_Item_No'] ?>')">
	    <div class="max-w-[50%]  mr-1" style="text-transform:uppercase;"><?php echo $data['Deskripsi'] ?></div>
	    <div class="text-slate-500">x <?php echo $data['Qty'] ?></div>
	    <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i> 
	    <div class="ml-auto font-medium">Rp <?php echo number_format($data['Total_Price'] ,0,",",".")?>&nbsp;&nbsp;
	    	<button class="btn btn-success shadow-md" onclick="modalpic('<?php echo $data['Inv_Item_No'] ?>')" data-tw-toggle="modal" data-tw-target="#pic-item-modal" style="color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="camera" data-lucide="camera" class="lucide lucide-camera block mx-auto w-4 h-4"><path d="M14.5 4h-5L7 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle></svg></button>
	    </div>
	</a>
	<?php
	}
} elseif ($_GET['menu'] == 'tampillistimage') { ?>
	<?php 
	$Inv_Item_No = $_GET['Inv_Item_No'];
    $queryfoto = mysqli_query($conn, "SELECT * FROM Invoice_Foto WHERE Inv_Item_No='$Inv_Item_No'");
    while($datafoto = mysqli_fetch_assoc($queryfoto)) { ?>
    <div class="col-span-2">
        <div class="card no-b">
            <div>
                <a onclick="openprev('<?php echo $datafoto['Inv_Item_No']; ?>/<?php echo $datafoto['foto']; ?>')" href="javascript:;" data-tw-toggle="modal" data-tw-target="#prev-item-modal"  class="progressive replace">
                    <img id="myImg" src="media/images/<?php echo $datafoto['Inv_Item_No']; ?>/<?php echo $datafoto['foto']; ?>" class="preview" alt="image" />
                 </a>
                 
            </div>
        </div>
    </div>
    <?php } ?> 
<?php }elseif ($_GET['menu'] == 'cekcust') { 
	$id = 	explode('+',$_POST['id']);
	$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Customer WHERE Cust_No='$id[0]'"));

	if ($data['Discount_No']!='0') {
		$member = $data['Cust_Member_Name'];
	}else{
		$member = 'NON-MEMBER';
	}
	$json = [ 
        'Cust_No' 		=> $data['Cust_No'],
	    'Cust_Nama'     => $data['Cust_Nama'],
	    'Cust_Alamat'   => $data['Cust_Alamat'],
	    'Cust_Telp'     => $data['Cust_Telp'],
	    'member'     	=> $member,
	];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();

} elseif ($_GET['menu'] == 'pilihcust') { 
	$id = 	explode('+',$_POST['id']);
	$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Cust_No,Cust_Nama,Discount_No from Customer WHERE Cust_No='$id[0]'"));

	$_SESSION['Cust_No'] 		= $data['Cust_No'];
	$_SESSION['Cust_Nama'] 		= $data['Cust_Nama'];
	$_SESSION['Cust_Telp'] 		= $_POST['Cust_Telp'];
	$_SESSION['Cust_Alamat'] 	= $_POST['Cust_Alamat'];
	$_SESSION['Discount_No'] 	= $data['Discount_No'];

	$json = [ 
        'Discount_No' => $data['Discount_No'],
	];
	echo json_encode($json);
    exit();

} elseif ($_GET['menu'] == 'totalan') { 

	if (isset($_POST['id'])) {
		$id = $_POST['id'];
		$invoice = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='$id'"));
		$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Total_Price) as Total_Price, sum(Item_Price) as Total_Item_Price from Invoice_Item WHERE Inv_Number='$id'"));
		$datapcs = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Item_Pcs*Qty) as Total_Pcs from Invoice_Item WHERE Inv_Number='$id'"));
	} else {
		$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Total_Price) as Total_Price, sum(Item_Price) as Total_Item_Price from Invoice_Item WHERE Inv_Number='' AND Staff_ID='$Staff_ID'"));
		$datapcs = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Item_Pcs*Qty) as Total_Pcs from Invoice_Item WHERE Inv_Number='' AND Staff_ID='$Staff_ID'"));
	}
	
	$subtotal 		= $data['Total_Price'];
	$totalItemPrice = $data['Total_Item_Price'];
	$charge			= 0;

	if (isset($_POST['persen'])) {
		$charge = ((int)$_POST['persen']/100) * $totalItemPrice;
	}
	
	if (isset($_SESSION['Cust_No'])) {
		$datadisc = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount.Persentase,Customer.Cust_Member_Name from Customer join Discount on Customer.Discount_No=Discount.Discount_No WHERE Customer.Discount_No!=0 AND Cust_No='$_SESSION[Cust_No]'"));
		if (isset($datadisc['Persentase'])) {
			$persentase = $datadisc['Persentase'];
			$namadiskon = $datadisc['Cust_Member_Name'];
			$diskon 	= round(($datadisc['Persentase']/100)*$totalItemPrice);
		}else{
			$persentase = '';
			$namadiskon = '';
			$diskon		= 0;
		}
		
	}else{
		$persentase = '';
		$namadiskon = '';
		$diskon		= 0;
	}

	if (isset($invoice)) {
		$customer = $invoice['Cust_ID'];
		$datadisc = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount.Persentase,Customer.Cust_Member_Name from Customer join Discount on Customer.Discount_No=Discount.Discount_No WHERE Customer.Discount_No!=0 AND Cust_No='$customer'"));
		$charge = ($invoice['Express_Charge'] <> 0) ? ($invoice['Express_Charge']/100) * $totalItemPrice : 0;
		$charge = (isset($_POST['persen'])) ? ((int)$_POST['persen'] / 100) * $totalItemPrice : $charge;
		
		if (isset($datadisc['Persentase'])) {
			$persentase = $datadisc['Persentase'];
			$namadiskon = $datadisc['Cust_Member_Name'];
			$diskon 	= round(($datadisc['Persentase']/100)*$totalItemPrice);
		}else{
			$persentase = '';
			$namadiskon = '';
			$diskon		= 0;
		}
	}
	
	$total 		= $subtotal - $diskon + $charge;
?>

	<div class="flex">
        <div class="mr-auto">Subtotal</div>
        <div class="font-medium">Rp <c id="subtotal"><?php echo number_format($subtotal ,0,",",".")?></c></div>
    </div>
    <div class="flex mt-4">
        <div class="mr-auto">Discount (<?php echo $namadiskon . " " . $persentase ?>%)</div>
        <div class="font-medium text-danger">-Rp <c id="diskon"><?php echo number_format($diskon ,0,",",".")?></c></div>
    </div>
	 <div class="flex mt-4">
        <div class="mr-auto">Total PCS</div>
        <div class="font-medium text-danger"><c id="totalpcs"><?php echo number_format($datapcs['Total_Pcs'],0,",",".")?></c></div>
    </div>
	 <div class="flex mt-4">
        <div class="mr-auto">Express Charge</div>
        <div class="font-medium text-danger"><c id="charge"><?php echo number_format($charge,0,",",".")?></c></div>
    </div>
    
    
    <div class="flex mt-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
        <div class="mr-auto font-medium text-base">Total</div>
        <div class="font-medium text-base">Rp <c id="total"><?php echo number_format($total ,0,",",".")?></c></div>
    </div>
    <input type="hidden" name="totalpcs" id="totalpcsdata" value="<?php echo $datapcs['Total_Pcs']; ?>">
    <input type="hidden" name="subtotal" id="subtotaldata" value="<?php echo $subtotal; ?>">
    <input type="hidden" name="diskon" id="diskondata" value="<?php echo $diskon; ?>">
    <input type="hidden" name="total" id="totaldata" value="<?php echo $total; ?>">

<?php } elseif ($_GET['menu'] == 'savenew') {
	
	if (isset($_POST['invoice'])) {
		$invoice = $_POST['invoice'];
		$cekitemno = mysqli_num_rows(mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='$invoice'"));		
	} else {
		$cekitemno = mysqli_num_rows(mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='' AND Staff_ID='$Staff_ID'"));
	}

	$colour 			= explode('+',$_POST['colour']);
	$brand 				= explode('+',$_POST['brand']);

	$Item_No 			= $cekitemno+1;
	$Deskripsi 			= $_POST['Item_Name'] . " " . $colour[1] . " " . $brand[1] . " (" . $_POST['size'] . ")";

	$Item_ID 			= $_POST['Item_ID'];
	$Colour_ID 			= $colour[0];
	$Brand_ID 			= $brand[0];
	$Size 				= $_POST['size'];
	$Item_Note 			= $_POST['note'];
	$Adjustment 		= str_replace(".","",$_POST['adjustment']);
	$Adjustment_Note 	= $_POST['note_adjustment'];
	$Item_Price 		= $_POST['Item_Price'];
	$Qty 				= $_POST['item_qty'];
	$Item_Pcs 			= $_POST['Item_Pcs'];
	$Total_Price 		= $_POST['Total_Price'];
	$request 			= $_POST['request'];
	$disc_persen		= ($_POST['disc_persen']) ? true : false;
	$disc_rupiah		= str_replace(".","",$_POST['disc_rupiah']);

	if (isset($_POST['invoice'])) {
		mysqli_query($conn,"INSERT into Invoice_Item VALUES(0,'$invoice','$Item_No','$Deskripsi','$Item_ID','$Colour_ID','$Brand_ID','$Size','$Item_Note','$Item_Price','$Item_Pcs','$Adjustment','$Adjustment_Note','$Qty','$Total_Price','','','$Staff_ID','$Staff_Name','','$disc_persen','$disc_rupiah','$request')");	
	} else {
		mysqli_query($conn,"INSERT into Invoice_Item VALUES(0,'','$Item_No','$Deskripsi','$Item_ID','$Colour_ID','$Brand_ID','$Size','$Item_Note','$Item_Price','$Item_Pcs','$Adjustment','$Adjustment_Note','$Qty','$Total_Price','','','$Staff_ID','$Staff_Name','','$disc_persen','$disc_rupiah','$request')");	
	}
} elseif ($_GET['menu'] == 'getcharge') {
	
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
		$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Total_Price) as Total_Price, sum(Item_Price) as Total_Item_Price from Invoice_Item WHERE Inv_Number='$id'"));
	} else {
		$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Total_Price) as Total_Price, sum(Item_Price) as Total_Item_Price from Invoice_Item WHERE Inv_Number='' AND Staff_ID='$Staff_ID'"));
	}
	
	$totalItemPrice = $data['Total_Item_Price'];
	$charge			= ($_POST['persen'] / 100) * $data['Total_Item_Price'];
	
	echo number_format($charge,0,',','.');
	exit();

} elseif ($_GET['menu'] == 'edititem') { 
	$id = $_POST['id'];
	$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Item WHERE Inv_Item_No='$id'"));
	$databrand = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Brand_ID,Brand_Name from Master_Brand WHERE Brand_ID='$data[Brand_ID]'"));
	$datacolour = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Colour_ID,Colour_Name from Master_Colour WHERE Colour_ID='$data[Colour_ID]'"));
	$persen = ($data['Disc_Persen'] == true) ? ($data['Disc_Amount'] / $data['Item_Price']) * 100 : 0;

 ?>
 		<link rel="stylesheet" href="plugin/selectize/selectize.css" />
 		<script type="text/javascript" src="plugin/selectize/selectize.min.js"></script>
		<div class="modal-header">
            <h2 class="font-medium text-base mr-auto" id="Item_Name_Tampil_Edit">
                <?php echo $data['Deskripsi'] ?>
            </h2>
        </div>
        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
            <div class="col-span-6">
                <label for="pos-form-4" class="form-label">Quantity</label>
                <div class="flex mt-1 flex-1">
                    <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 mr-1" onclick="updateitemqty1('minus')">-</button>
                    <input id="item_qty_edit" name="item_qty_edit" type="text" class="form-control w-24 text-center" placeholder="Item quantity" onchange="updateitemprice1()" value="<?php echo $data['Qty'] ?>">
                    <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 ml-1" onclick="updateitemqty1('plus')">+</button>
                </div>
            </div>
            <div class="col-span-6">
                 <!-- BEGIN: Basic Select -->
                 <label class="form-label">Colour</label>
                 <div class="mt-1">
                     <select id="colour_edit" name="colour" data-placeholder="Select Colour" class="tom-select w-full colour">
                     	<option value="<?php echo $datacolour['Colour_ID'] ?>+<?php echo $datacolour['Colour_Name'] ?>"><?php echo $datacolour['Colour_Name'] ?></option>
                        <?php 
                            $querycolor = mysqli_query($conn,"SELECT * from Master_Colour WHERE Colour_Status='Y' order by Colour_Name asc");
                            while($datacolour = mysqli_fetch_assoc($querycolor)){
                        ?>
                            <option value="<?php echo $datacolour['Colour_ID'] ?>+<?php echo $datacolour['Colour_Name'] ?>"><?php echo $datacolour['Colour_Name'] ?></option>
                        <?php } ?>
                     </select> 
                     <script type="text/javascript">
                     	$('#colour_edit').selectize();
                     </script>
                 </div>
            </div>
            <div class="col-span-6">
                 <!-- BEGIN: Basic Select -->
                 <label class="form-label">Brand</label>
                 <div class="mt-1">
                     <select id="brand_edit" name="brand" data-placeholder="Select Brand" class="tom-select w-full">
                     	<option value="<?php echo $databrand['Brand_ID'] ?>+<?php echo $databrand['Brand_Name'] ?>"><?php echo $databrand['Brand_Name'] ?></option>
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
                    <input type="text" name="size" id="item_size_edit" class="form-control" placeholder="Input Size" value="<?php echo $data['Size'] ?>">
                </div>
            </div>
            <div class="col-span-12">
                <label for="pos-form-5" class="form-label">Condition</label>
                <textarea id="item_note_edit" name="note" class="form-control w-full mt-2" placeholder="Item notes"><?php echo $data['Item_Note'] ?></textarea>
            </div>
			<div class="col-span-12" hidden>
				<label for="regular-form-1" class="form-label">Request Customer</label> 
				<div class="mt-1">
					<input type="text" name="request" id="request" autocomplete="off" class="form-control" placeholder="Input Request Customer" value="<?= $data['Request_Customer']?>">
				</div>
			</div>
			
            <div class="col-span-12">
                <hr>
            </div>
            <div class="col-span-6">
				<label for="regular-form-1" class="form-label">Discount</label>
				<div class="input-group">
					<input type="text" max="100" onkeyup="updateitempersen1()" name="disc_persen" id="disc_persen_edit" class="form-control uang" placeholder="10"  aria-describedby="input-group-email" value="<?= number_format($persen,0,',','.')?>">                                             
					<div id="input-group-email" class="input-group-text">%</div> 
				</div>
			</div>
			<div class="col-span-6">
				<label for="regular-form-1" class="form-label text-white">Discount</label>
				<div class="input-group">
						<div id="input-group-email" class="input-group-text">Rp</div> 
						<input type="text" onkeyup="updateitemprice1()" name="disc_rupiah" id="disc_rupiah_edit" class="form-control uang" placeholder="50.000"  aria-describedby="input-group-email"  value="<?= number_format($data['Disc_Amount'],0,',','.')?>">                                             
				</div>
			</div>
			
            <div class="col-span-6">
                <label for="regular-form-1" class="form-label">Adjustment</label>
				<div class="input-group">
					<div id="input-group-email" class="input-group-text">Rp</div> 
                    <input type="text" onkeyup="updateitemprice1()" name="adjustment" id="adjustment_edit" class="form-control uang" placeholder="50.000"  aria-describedby="input-group-email" value="<?php echo $data['Adjustment'] ?>">

                     
                </div>
            </div>
            <div class="col-span-6">
				<label for="regular-form-1" class="form-label text-white">Adjusment</label>
                                        
               <input id="note_adjustment_edit" name="note_adjustment" type="text" class="form-control" placeholder="Note Adjustment" value="<?php echo $data['Adjustment_Note'] ?>">
               <!-- kirimdata -->    
                
                <input type="hidden" name="Inv_Item_No" id="Inv_Item_No_Edit" value="<?php echo $data['Inv_Item_No'] ?>">
                <input type="hidden" name="Item_ID" id="Item_ID_Edit" value="<?php echo $data['Item_ID'] ?>">
                <input type="hidden" name="Item_Price" id="Item_Price_edit" value="<?php echo $data['Item_Price'] ?>">
                <input type="hidden" name="Item_Pcs" id="Item_Pcs_edit" value="<?php echo $data['Item_Pcs'] ?>">
                <input type="hidden" name="Total_Price" id="Total_Price_edit" value="<?php echo $data['Total_Price'] ?>">

                    
                     <!-- kirimdata -->
            </div>
        </div>
        
        <div class="modal-footer text-right">
            <button class="btn btn-outline-success inline-block mr-1 mb-2" style="float: left;">Price Rp <c id="pricetampiledit"><?php echo number_format($data['Total_Price'] ,0,",",".")?></c></button>
            <button type="button" id="closemodalitemnewedit" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
            <button type="button" onclick="hapusitem('<?php echo $data['Inv_Item_No']; ?>')" class="btn btn-danger w-24">Delete</button>
            <button type="submit" class="btn btn-primary w-24">Update</button>
        </div>

		<script type="text/javascript">
			$(document).ready(function(){
				// Format mata uang.
				$( '.uang' ).mask('000.000.000', {reverse: true});
			});
			$('#brand_edit').selectize();
		</script>
<?php 
	exit();
} elseif ($_GET['menu'] == 'hapusitem') { 
	$id = $_POST['id'];

	mysqli_query($conn,"DELETE from Invoice_Item WHERE Inv_Item_No='$id'");
	
	if (isset($_POST['invoice'])) {
		$invoice 	= $_POST['invoice'];	
		$query 		= mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='$invoice'");
	} else {
		$query = mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='' AND Staff_ID='$Staff_ID'");
	}
	
	$no=1;
	while($data=mysqli_fetch_assoc($query)){
		mysqli_query($conn,"UPDATE Invoice_Item SET Item_No='$no' WHERE Inv_Item_No='$data[Inv_Item_No]'");
		$no++;
	}
	exit();
} elseif ($_GET['menu'] == 'saveedit') { 
	

	$Inv_Item_No 		= $_POST['Inv_Item_No'];

	$colour 			= explode('+',$_POST['colour']);
	$brand 				= explode('+',$_POST['brand']);

	$dataitem = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Item_Name from Master_Item WHERE Item_ID='$_POST[Item_ID]'"));
	
	$Deskripsi 			= $dataitem['Item_Name'] . " " . $colour[1] . " " . $brand[1] . " (" . $_POST['size'] . ")";

	$Item_ID 			= $_POST['Item_ID'];
	$Colour_ID 			= $colour[0];
	$Brand_ID 			= $brand[0];
	$Size 				= $_POST['size'];
	$Item_Note 			= $_POST['note'];
	$Adjustment 		= str_replace(".","",$_POST['adjustment']);
	$Adjustment_Note 	= $_POST['note_adjustment'];
	$Item_Price 		= $_POST['Item_Price'];
	$Qty 				= $_POST['item_qty_edit'];
	$Item_Pcs 			= $_POST['Item_Pcs'];
	$Total_Price 		= $_POST['Total_Price'];
	$request 			= $_POST['request'];
	$disc_persen		= ($_POST['disc_persen']) ? true : false;
	$disc_rupiah		= str_replace(".","",$_POST['disc_rupiah']);

	mysqli_query($conn,"UPDATE Invoice_Item SET Deskripsi='$Deskripsi', Colour_ID='$Colour_ID',Brand_ID='$Brand_ID',Size='$Size',Item_Note='$Item_Note',Adjustment='$Adjustment',Adjustment_Note='$Adjustment_Note',Qty='$Qty',Total_Price='$Total_Price', Request_Customer='$request', Disc_Amount='$disc_rupiah', Disc_Persen='$disc_persen' WHERE Inv_Item_No='$Inv_Item_No'");

	exit();
} elseif ($_GET['menu'] == 'savetransaksi') { 

	if (isset($_POST['invoice'])) {
		$invoice 		= $_POST['invoice'];
		$Inv_Tg_Selesai	= $_POST['Inv_Tg_Selesai'];
		$Note			= $_POST['Note'];
		$Cust_ID		= $_POST['Cust_No'];
		$Cust_Nama		= $_POST['Cust_Nama'];
		$Cust_Alamat	= $_POST['Cust_Alamat'];
		$Cust_Telp		= $_POST['Cust_Telp'];
		
		$Express_Charge		= $_POST['Express_Charge'];
		$Discount_No		= $_POST['Discount_No'];
		$Total_PCS			= $_POST['totalpcs'];
		$Total_Diskon		= $_POST['diskon'];
		$Total_Voucher		= 0;
		$Payment_Before		= round($_POST['total']);
		$Payment_Amount		= angka_pembulatan($Payment_Before,2,100);
		$Payment_Rounding	= $Payment_Amount-$Payment_Before;

		mysqli_query($conn, "UPDATE Invoice SET Cust_ID='$Cust_ID', Cust_Nama='$Cust_Nama', Cust_Alamat='$Cust_Alamat', Cust_Telp='$Cust_Telp', Note='$Note', Inv_Tg_Selesai='$Inv_Tg_Selesai', Discount_No='$Discount_No', Total_PCS='$Total_PCS', Total_Diskon='$Total_Diskon', Total_Voucher='$Total_Voucher', Payment_Before='$Payment_Before', Payment_Amount='$Payment_Amount', Payment_Rounding='$Payment_Rounding', Express_Charge='$Express_Charge' WHERE Inv_Number='$invoice'");
		echo $invoice;
		exit();
	}

	if (!isset($_SESSION["Cust_No"])) {
		echo "PILIHCUSTOMER";
		exit();
	}

	$cabang				= $_SESSION['cabang'];
	
	$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUBSTRING(Inv_Number, 6, 8) as Inv_Number from Invoice WHERE Inv_Number like '%$cabang%' order by Inv_No DESC LIMIT 1"));

	if (!isset($data['Inv_Number'])) {
		$inv_terakhir 	= 1;
		$numbernew 		= sprintf('%05d',$inv_terakhir);
		$inv_baru 		= date("y").$numbernew;
	}else{

		$inv_terakhir   = intval(substr($data['Inv_Number'],-5))+1;
		$numbernew 		= sprintf('%05d',$inv_terakhir);
		$inv_baru 		= date("y").$numbernew;
	}
	

	$Inv_Number			= $cabang . "-".$inv_baru;
	$Inv_Tgl_Masuk		= date('Y-m-d');
	$Inv_Tg_Selesai		= $_POST['Inv_Tg_Selesai'];
	$Cust_ID			= $_POST['Cust_No'];
	$Cust_Nama			= $_POST['Cust_Nama'];
	$Cust_Alamat		= $_POST['Cust_Alamat'];
	$Cust_Telp			= $_POST['Cust_Telp'];
	$Discount_No		= $_POST['Discount_No'];
	$Express_Charge		= $_POST['Express_Charge'];
	$Total_PCS			= $_POST['totalpcs'];
	$Total_Diskon		= $_POST['diskon'];
	$Total_Voucher		= 0;
	$Payment_Before		= round($_POST['total']);
	$Payment_Amount		= angka_pembulatan($Payment_Before,2,100);
	$Payment_Rounding	= $Payment_Amount-$Payment_Before;
	$Status_Payment		= 'N';
	$Status_Taken		= 'N';
	$Status_Inv			= 'Y';
	$Status_Marking		= 'N';
	$Note 				= $_POST['Note'];
	$Staff_Name			= $Staff_Name;
	$Staff_ID			= $Staff_ID;
	$Point_Transaksi	= 0;


	mysqli_query($conn,"INSERT into Invoice VALUES(0,'$Inv_Number','$Inv_Tgl_Masuk','$Inv_Tg_Selesai','$Cust_ID','$Cust_Nama','$Cust_Alamat','$Cust_Telp','$Discount_No','$Total_PCS','$Total_Diskon','$Total_Voucher','$Payment_Before','$Payment_Rounding','$Payment_Amount','$Status_Payment','$Status_Taken','$Status_Inv','$Status_Marking','$Note','$Staff_Name','$Staff_ID','$Point_Transaksi','$Express_Charge')");

	mysqli_query($conn,"UPDATE Invoice_Item SET Inv_Number='$Inv_Number' WHERE Inv_Number='' AND Staff_ID='$Staff_ID'");

	unset($_SESSION["Cust_No"]);
	unset($_SESSION["Cust_Nama"]);
	unset($_SESSION["Cust_Telp"]);
	unset($_SESSION["Cust_Alamat"]);
	unset($_SESSION["Discount_No"]);
	echo $Inv_Number;
	exit();
}elseif ($_GET['menu'] == 'showformcust') { ?>
	<link rel="stylesheet" href="plugin/selectize/selectize.css" />
    <script type="text/javascript" src="plugin/selectize/selectize.min.js"></script>
	<label class="form-label">Customers</label>
     <div class="mt-1">
         <select name="customer" id="customer" data-placeholder="Select Customers" class="w-full customer" onchange="cekcust()">
            <option></option>
            <?php 
                $querycust = mysqli_query($conn,"SELECT * from Customer WHERE Cust_Status='Y' order by Cust_Nama asc");
                while($datacust = mysqli_fetch_assoc($querycust)){
            ?>
                <option value="<?php echo $datacust['Cust_No'] ?>+<?php echo $datacust['Cust_Nama'] ?>"><?php echo $datacust['Cust_Nama'] ?> | <?php echo $datacust['Cust_Alamat'] ?></option>
            <?php } ?>
         </select> 
    </div>
    <script type="text/javascript">
        $('#customer').selectize();
    </script>
<?php }elseif ($_GET['menu'] == 'savetransaksirewash') { 

	$Inv_Number 	= $_POST['Inv_Number'];
	$Inv_Number_R 	= $_POST['Inv_Number']."R";
	$Inv_Tg_Selesai = $_POST['Inv_Tg_Selesai'];
	$Note 			= $_POST['Note'];
	$Inv_Item_No 	= $_POST['Inv_Item_No'];
	$QTY 			= $_POST['QTY'];
	$Inv_Tgl_Masuk	= date('Y-m-d');
	$Total_PCS 		= count($Inv_Item_No);


	$datainv = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice WHERE Inv_Number='$Inv_Number'"));

	mysqli_query($conn,"INSERT into Invoice_Rewash VALUES(0,'$Inv_Number_R','$Inv_Tgl_Masuk','$Inv_Tg_Selesai','$datainv[Cust_ID]','$datainv[Cust_Nama]','$datainv[Cust_Alamat]','$datainv[Cust_Telp]','$datainv[Discount_No]','$Total_PCS','0','0','0','0','0','$datainv[Status_Payment]','N','$datainv[Status_Inv]','$Note','$Staff_Name','$Staff_ID','0')");

	$non = 1;$ar = 0;
	foreach($Inv_Item_No as $datanya) {
		$dataitem = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Item WHERE Inv_Item_No='$datanya'"));

	   	mysqli_query($conn,"INSERT into Invoice_Rewash_Item VALUES(0,'$Inv_Number_R','$non','$dataitem[Deskripsi]','$dataitem[Item_ID]','$dataitem[Colour_ID]','$dataitem[Brand_ID]','$dataitem[Size]','$dataitem[Item_Note]','$dataitem[Item_Price]','$dataitem[Item_Pcs]','$dataitem[Adjustment]','$dataitem[Adjustment_Note]','$QTY[$ar]','$dataitem[Total_Price]','$dataitem[Marking_Note]','$dataitem[Marking_Note_Revisi]','$Staff_ID','$Staff_Name','$dataitem[Inv_Tgl_Masuk]')");
	   	$non++;
	   	$ar++;
	}

	$totalpcsdata = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Qty * Item_Pcs) as total from Invoice_Rewash_Item WHERE Inv_Number='$Inv_Number_R'"));
	mysqli_query($conn,"UPDATE Invoice_Rewash SET Total_PCS='$totalpcsdata[total]' where Inv_Number='$Inv_Number_R'");
	
	exit();

	
}