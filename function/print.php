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
				<img src="../src/images/logo-mycherree.png" style="width:50%"><br>
			My Cherree Laundry  <br/>
			BGM PIK Blog G No 77<br/>
			Jakarta Utara, DKI Jakarta 14470<br/>
			WA : 0877 2410 9018<br>
			Telp : (021) 22338540 
			</p>
			---------------------------------------------
			<div style="width: 100%">
				<center>
				<div style="width: 100%;margin-top: -10px;margin-bottom: -10px;" onclick="window.print();">
					<div style="width: 100%">
					
					</div>
				</div>
				<div style="width: 100%;">
				
					<b style="font-size: 28px;line-height: 25px;">

						<a onclick="test()" style="text-decoration: none;color: black;">
							<br>
						[#<?= $invoice['Inv_Number']?>] 
						</a><br>
						<a style="font-size: 22px;">
							<?= $invoice['Cust_Nama']?> <br/>	
						</a>
						<a style="font-size: 30px;display: none;" id="errorinv">
							<hr>
							INVOICE ERROR
							<hr>
						</a>
						<a style="font-size: 30px;display: none;" id="errorconflic">
							<hr>
							INVOICE CONFLIC - REPAIRING
							<hr>
						</a>
						<i style="font-size: 16px;line-height: 0.5;">
							<?= $invoice['Cust_Alamat']?>  <br>	
						</i>
					</b>
					<!-- asd -->
				</div>

				<p style="text-align: center;font-size: 16px;">	
				<?= date('d-m-Y', strtotime($invoice['Inv_Tgl_Masuk']))?> &middot;  
				<i align="left"></i> Served by <?= $invoice['Staff_Name']?> 
				</p>
				</center>
				<center>
				
				</center>
				---------------------------------------------
				<center>			

				<b style="font-size:18px">
				Available at store <br>
				<?= date('D, d M Y', strtotime($invoice['Inv_Tg_Selesai']))?>
				</b>
				</center>
			</div>

			<?php
			$discount 	= $invoice['Discount_No'];
			$sql 		= mysqli_query($conn, "SELECT *FROM Discount WHERE Discount_No='$discount'");
			$promo		= mysqli_fetch_assoc($sql);
			?>

			<table width="100%" style="font-size:18px">
				<?php
				$total = 0;
				while ($item = mysqli_fetch_assoc($query)) {
					if ($invoice['Total_Diskon'] <> 0) {
						$afterDisc = number_format($item['Total_Price'] - ($item['Total_Price'] * ($promo['Persentase'] / 100)),0,',','.');
						$price = '<strike>'.number_format($item['Total_Price'],0,',','.').'</strike> '. $afterDisc;
					} else {
						$price = number_format($item['Total_Price'],0,',','.');
					}
					echo '
					<tr> 	
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td align="left">'.number_format($item['Qty'],0,',','.').'</td>
						<td align="right">'.$price.'</td>
					</tr>

					<tr> 	
						<td colspan="2">'.$item['Deskripsi'].'</td>
					</tr>
					<tr> 	
						<td colspan="2"> 
							
						</td>
					</tr>
					<tr> 	
						<td colspan="2"><b>Notes:</b> 
							'.$item['Item_Note'].' 
						</td>
					</tr>
					';
					$total += $item['Total_Price'];
				}
				?>     	
			</table>
			---------------------------------------------
			<br>
			<br>
			<table width="100%" style="font-size:18px"> 	
				<tr>
					<td align="left"><?= number_format($invoice['Total_PCS'],0,',','.')?> PIECE(S)</td>
					<td align="right"><?= number_format($total,0,',','.')?></td>
				</tr>
				
				<tr>
					<td align="left">Discount(<?= (mysqli_num_rows($sql) > 0) ? $promo['Persentase'].'%' : '-'?>) </td>
					<td align="right"><?= number_format($invoice['Total_Diskon'],0,',','.')?></td>
				</tr>
		

				<tr style="font-size: 20px;font-weight: bold;">
					<td align="left">TOTAL </td>
					<td align="right"><?= number_format($invoice['Payment_Amount'],0,',','.')?></td>
				</tr>
			</table>
			<br>
			---------------------------------------------
			<div style="font-size:18px">
			Printed on: <br>
			<?= date('d-m-Y H:i:s')?><br>
			by <?= $_SESSION['Staff_Name']?>
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
	$invoice = $_GET['invoice'];
	$item_no = $_GET['item_no'];

	$sql = mysqli_query($conn, "SELECT *FROM Invoice_Item it JOIN Invoice i ON it.Inv_Number = i.Inv_Number 
								WHERE i.Inv_Number='$invoice' AND it.Item_No='$item_no'");
	$data = mysqli_fetch_assoc($sql);
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
				<span style="font-size:14px; font-weight: normal"><?= date('d F Y', strtotime($data['Inv_Tg_Selesai']))?>] <?= $data['Deskripsi']?>[#<?= $data['Inv_Number'] ?>][<?= $data['Item_No']?> / <?= $data['Total_PCS']?>]</span>
			</h6>
		</div>
	</body>
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
	
	function printGO() {
		//Android.printPage();
		//window.print();
	//    setTimeout(function () {
		//       window.location.href = "transaction"; //will redirect to your blog page (an ex: blog.html)
		// }, 3000); //will call the function after 2 secs.
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