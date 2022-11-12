<?php
session_start();
include '../config/configuration.php';

if ($_GET['type'] == 'invoice') {
	$id 	 = $_GET['invoice'];

	if (isset($_GET['rewash'])) {
		$sql 	 = mysqli_query($conn, "SELECT *FROM Invoice_Rewash WHERE Inv_Number = '$id'");	
		$query 	 = mysqli_query($conn, "SELECT *FROM Invoice_Rewash_Item WHERE Inv_Number='$id'");
		$link	 = 'transactions_rewash_detail';
	} else {
		$sql 	 = mysqli_query($conn, "SELECT *FROM Invoice WHERE Inv_Number = '$id'");
		$query 	 = mysqli_query($conn, "SELECT *FROM Invoice_Item WHERE Inv_Number='$id'");
		$link	 = 'transactions_detail';
	}
	
	$invoice = mysqli_fetch_assoc($sql);
	if ($invoice['Status_Payment'] == 'Y') {
		$sql_payment 	= mysqli_query($conn, "SELECT *FROM Invoice_Payment WHERE Inv_Number = '$invoice[Inv_Number]'");
		$payment 		= mysqli_fetch_assoc($sql_payment);
	}
	?>
	<!DOCTYPE html>
	<html moznomarginboxes mozdisallowselectionprint style="background-color: #fff">
	<head>
		<title>Print Invoice</title>
		<style type="text/css">
			body.receipt .sheet { width: 80mm; font-family: 'Calibri'; height: auto; margin: 0 auto;padding-right: 20px;padding-left: 5px; } /* change height as you like */
			@media print { body.receipt { width: 80mm } } /* this line is needed for fixing Chrome's bug */
			@media print { #printarea { width: 80mm } }
			.collapse { border: 1px solid black; border-collapse:collapse}
		</style>
	</head>
	<body style="font-size: 22px;" class="receipt" onload="printGO()" oncontextmenu="return false">
		<!-- <button onclick="saveSignat()">SAVE SIGNATURE</button>
		<button onclick="window.print()">PRINT</button> -->
		<div id="printarea" style="background-color: #fff;" class="sheet">
			<p style="text-align: center; font-size:14px">
				<img src="../src/images/logo-mycherree.png" style="width:50%" hidden><br>
			My Cherree Laundry  <br/>
			<?= ($_SESSION['cabang'] == 'MCL1') ? 'BGM PIK Blok G No 77':'Central Market PIK'?><br/>
			Jakarta Utara 14470<br/>
			
			Tel: (021) 22338540 | WA: <?= ($_SESSION['cabang'] == 'MCL1') ? '+62 877 2410 9018':'+62 812 9055 1743 '?>
			</p>
			============================
			<div style="width: 100%">
				<center>
				<div style="width: 100%;margin-top: -10px;margin-bottom: -10px;" onclick="window.print();">
					<div style="width: 100%">
					
					</div>
				</div>
				<div style="width: 100%;">
					<table style="font-size:16px; margin-top:10px">
						<tr>
							<td width="40%" align="left">Invoice</td>
							<td width="60%">: [#<?= $invoice['Inv_Number']?>] </td>
						</tr>
						<tr>
							<td width="40%" align="left">Customer</td>
							<td width="60%">: <?= $invoice['Cust_Nama']?></td>
						</tr>
						<tr>
							<td width="40%" align="left">Order</td>
							<td width="60%">: <?= date('d M Y', strtotime($invoice['Inv_Tgl_Masuk']))?> </td>
						</tr>
						<tr>
							<td width="40%" align="left">Ready</td>
							<td width="60%">: <?= date('d M Y', strtotime($invoice['Inv_Tg_Selesai']))?> </td>
						</tr>
						<tr>
							<td width="40%" align="left">Served By</td>
							<td width="60%">: <?= $invoice['Staff_Name']?> </td>
						</tr>
					</table>
					<!-- asd -->
				</div>

				</center>
				<center>
				
				</center>
			</div>
			============================
			<center>
				<b style="font-size:18px">
					Request Customer : <br><span style="font-weight:normal"><?= $invoice['Note']?></span>
				</b>
			</center>
			============================
			<?php
			$discount 	= $invoice['Discount_No'];
			$sql 		= mysqli_query($conn, "SELECT *FROM Discount WHERE Discount_No='$discount'");
			$promo		= mysqli_fetch_assoc($sql);
			?>

			<table width="100%" style="font-size:18px">
				<?php
				$total = 0;
				while ($item = mysqli_fetch_assoc($query)) {
					$as = $invoice['Cust_ID'];
					$cust = mysqli_query($conn, "SELECT *FROM Customer WHERE Cust_No='$as'");
					$customer = mysqli_fetch_assoc($cust);
					if ($invoice['Total_Diskon'] <> 0) {
						$afterDisc = number_format($item['Total_Price'] - ($item['Total_Price'] * ($promo['Persentase'] / 100)),0,',','.');
						$hargaMember = ($customer['Cust_Member_Name'] == 'MEMBERSHIP') ? $afterDisc : 'NON-MEMBER';
						$price = '<strike>'.number_format($item['Total_Price'],0,',','.').'</strike> '. $afterDisc;
					} elseif ($item['Disc_Amount'] <> 0){
						$price = '<strike>'.number_format($item['Item_Price'],0,',','.').'</strike> '. number_format($item['Total_Price'],0,',','.');
						$hargaMember = ($customer['Cust_Member_Name'] == 'MEMBERSHIP') ? $item['Total_Price'] : 'NON-MEMBER';
					} else {
						$price = number_format($item['Item_Price'],0,',','.');
						$hargaMember = ($customer['Cust_Member_Name'] == 'MEMBERSHIP') ? (10/100) * $item['Total_Price'] : 'NON-MEMBER';
					}

					echo '
					<tr> 	
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td align="left">'.number_format($item['Qty'],0,',','.').'</td>
						<td align="right">'.number_format($item['Total_Price'],0,',','.').'</td>
					</tr>
					<tr>
						<td align="left"></td>
						<td align="right">(Membership 10%) '.$hargaMember.'</td>
					</tr>

					<tr> 	
						<td colspan="2">'.$item['Deskripsi'].'</td>
					</tr>
					<tr> 	
						<td colspan="2"> 
							
						</td>
					</tr>
					<tr> 	
						<td colspan="2"><b>NOTE :</b> 
							'.$item['Item_Note'].' 
						</td>
					</tr>
					';
					$total += $item['Total_Price'];
				}
				?>     	
			</table>
			============================
			<br>
			<br>
			<table width="100%" style="font-size:18px"> 	
				<tr>
					<td align="left"><?= number_format($invoice['Total_PCS'],0,',','.')?> PIECE(S)</td>
					<td align="right"><?= number_format($total,0,',','.')?></td>
				</tr>
				
				<tr>
					<td align="left">Discount(<?= (mysqli_num_rows($sql) > 0) ? $promo['Discount_Nama'].' '.$promo['Persentase'].'%' : '-'?>) </td>
					<td align="right"><?= number_format($invoice['Total_Diskon'],0,',','.')?></td>
				</tr>
		

				<tr style="font-size: 20px;font-weight: bold;">
					<td align="left">TOTAL </td>
					<td align="right"><?= number_format($invoice['Payment_Amount'],0,',','.')?></td>
				</tr>
			</table>
			<br>
			============================
			<br><br>
			<div style="font-size:18px">
			Payment  : <?= ($invoice['Status_Payment'] == 'Y') ? 'PAID':'UNPAID' ?><br>
			Method : <?= ($invoice['Status_Payment'] == 'Y') ? $payment['Payment_Type']:'-'?><br>
			Date : <?= ($invoice['Status_Payment'] == 'Y') ? date('D, d M Y', strtotime($payment['Payment_Tgl'])):'-'?><br>
			</div>
			<br>
			============================
			<div style="font-size:18px">
			Print: <?= date('d M Y H:i:s')?> | <?= $_SESSION['Staff_Name']?>
			</div>
			&nbsp;
		
			<table class="collapse" style="font-size:15px">
				<tr class="collapse">
					<td class="collapse">&nbsp;Customer&nbsp;</td>
					<td class="collapse">&nbsp;Counter Staff&nbsp;</td>
					<td class="collapse">&nbsp;Penerima&nbsp;</td>
					<td class="collapse">&nbsp;Pengecek&nbsp;</td>
				</tr>
				<tr class="collapse" height="100">
					<td class="collapse"></td>
					<td class="collapse"></td>
					<td class="collapse"></td>
					<td class="collapse"></td>
				</tr>
			</table>
		</div>
<?php 
} elseif ($_GET['type'] == 'marker') {
	$id = $_GET['invoice'];
	$item_no = $_GET['item_no'];

	$sql = mysqli_query($conn, "SELECT *FROM Invoice_Item it JOIN Invoice i ON it.Inv_Number = i.Inv_Number 
								WHERE i.Inv_Number='$id' AND it.Item_No='$item_no'");
	$data = mysqli_fetch_assoc($sql);

	$query = mysqli_query($conn, "SELECT *FROM Invoice_Item WHERE Inv_Number='$id'");
	$total = mysqli_num_rows($query);
	
	if ($item_no <> $total) {
		$next = $item_no + 1;
		$link = 'print?type=marker&invoice=' . $id . '&item_no=' . $next;
	} else {
		$link = '';
	}
?>	
	<!DOCTYPE html>
	<html moznomarginboxes mozdisallowselectionprint style="background-color: #fff">
	<head>
		<title>Print Invoice</title>
		<style type="text/css">
			body.receipt .sheet { width: 80mm;  font-family: 'Calibri'; height: auto; margin: 0 auto;padding-right: 20px;padding-left: 5px; } /* change height as you like */
			@media print { body.receipt { width: 80mm; } } /* this line is needed for fixing Chrome's bug */
			@media print { #printarea { width: 80mm } }
			.collapse { border: 1px solid black; border-collapse:collapse}
		</style>
	</head>
	<body style="font-size: 22px;" class="receipt" onload="printGO()" oncontextmenu="return false">
		<!-- <button onclick="saveSignat()">SAVE SIGNATURE</button>
		<button onclick="window.print()">PRINT</button> -->
		<div id="printarea" style="background-color: #fff;" class="sheet">
			<h6>
				<span style="font-size:14px; font-weight: normal"><?= date('d F Y', strtotime($data['Inv_Tg_Selesai']))?> | <?= $data['Deskripsi']?>[#<?= $data['Inv_Number'] ?>][<?= $data['Item_No']?> / <?= $data['Total_PCS']?>]</span>
			</h6>
		</div>
	</body>
	</html>
<?php 
} elseif ($_GET['type'] == 'membership') {
	
	$id 		= $_GET['id'];
	$sql 		= mysqli_query($conn, "SELECT *FROM Registrasi_Member WHERE Registrasi_ID='$id'");
	$member		= mysqli_fetch_assoc($sql);

	$member_id	= $member['Discount_No'];
	$query 		= mysqli_query($conn, "SELECT *FROM Discount WHERE Discount_No='$member_id'");
	$discount	= mysqli_fetch_assoc($query);

	$link 		= '../app?p=membership';
	
?>

	
	<!DOCTYPE html>
	<html moznomarginboxes mozdisallowselectionprint style="background-color: #fff">
	<head>
		<title>Print Invoice</title>
		<style type="text/css">
			body.receipt .sheet { width: 80mm;  font-family: 'Calibri'; height: auto; margin: 0 auto;padding-right: 20px;padding-left: 5px; } /* change height as you like */
			@media print { body.receipt { width: 80mm; } } /* this line is needed for fixing Chrome's bug */
			@media print { #printarea { width: 80mm } }
			.collapse { border: 1px solid black; border-collapse:collapse}
		</style>
	</head>
	<body style="font-size: 22px;" class="receipt" onload="printGO()" oncontextmenu="return false">
		<!-- <button onclick="saveSignat()">SAVE SIGNATURE</button>
		<button onclick="window.print()">PRINT</button> -->
		<div id="printarea" style="background-color: #fff;" class="sheet">
			<p style="text-align: center; font-size:14px">
				<img src="../src/images/logo-mycherree.png" style="width:50%"><br>
			My Cherree Laundry  <br/>
			<?= ($_SESSION['cabang'] == 'MCL1') ? 'BGM PIK Blok G No 77':'Central Market PIK'?><br/>
			Jakarta Utara 14470<br/>
			
			Tel: (021) 22338540 | WA: <?= ($_SESSION['cabang'] == 'MCL1') ? '+62 877 2410 9018':'+62 812 9055 1743 '?>
			</p>
			============================
			<center>
				<b style="font-size:18px">
					Proof of Membership Member
				</b>
			</center>
			============================
			<br>
			<table width="100%" style="font-size:18px"> 	
				<tr>
					<td align="left">Name</td>
					<td align="left">: <?= $member['Cust_Nama'] ?></td>
				</tr>
				
				<tr>
					<td align="left">Discount </td>
					<td align="left">: <?= $discount['Persentase']?>%</td>
				</tr>
		
				<tr>
					<td align="left" colspan="2">Lifetime Member </td>
				</tr>
			</table>
			============================
			<table width="100%" style="font-size:18px"> 	
				<tr>
					<td align="left">Total</td>
					<td align="left">: <?= number_format($member['Registrasi_Payment'],0,',','.') ?></td>
				</tr>
				<tr>
					<td align="left">Payment </td>
					<td align="left">: PAID</td>
				</tr>		
				<tr>
					<td align="left">Method </td>
					<td align="left">: <?= $member['Payment_Type']?></td>
				</tr>
				<tr>
					<td align="left">Date </td>
					<td align="left">: <?= date('D, d M Y', strtotime($member['Registrasi_Tgl']))?></td>
				</tr>

			</table>
			============================
			<div style="font-size:18px">
			Print: <?= date('d M Y H:i:s')?> | <?= $_SESSION['Staff_Name']?>
			</div>
			&nbsp;
		</div>
	</html>
<?php } ?>

<form method="POST" enctype="multipart/form-data" action="simpanz" id="myForm">
	<input type="hidden" name="img_val" id="img_val" value="" />
</form>

<!-- <script src="../assets/js/signature_pad.umd.js"></script>
<script src="../assets/js/appsignature.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> -->
<script type="text/javascript">
	function saveSignat(){
		var element = document.getElementById("printarea");

			html2canvas(element).then(function(canvas) {
				// Export the canvas to its data URI representation
				var base64image = canvas.toDataURL("image/png");

				// Open the image in a new window
				window.open(base64image , "_blank");
			});
	}
</script>

<script type="text/javascript">
	
	function printGO() 
	{	
		let id = '<?= $id ?>';
		let link = '<?= $link ?>';
		let type = '<?= $_GET["type"] ?>';
		window.print();
	   	setTimeout(function () {
			   if (type != 'invoice') {
				   if (link == '') {
						window.close();
				   } else {
					    window.location.href = link; //will redirect to your blog page (an ex: blog.html)
				   }
			   } else {
				    window.location.href = "../app?p="+ link +"&invoice="+id; //will redirect to your blog page (an ex: blog.html)
			   }
		}, 3000); //will call the function after 2 secs.
	}


	document.onkeydown = function(e) {
	if(event.keyCode == 123) {
		return false;
	}
	if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
		return false;
	}
	if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
		return false;
	}
	if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
		return false;
	}
	if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
		return false;
	}
	}
	

</script>
</body>
</html>
<script>
	function test() {
		window.print();
	}
</script>