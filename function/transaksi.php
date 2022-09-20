

<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$Staff_ID 			= $_SESSION['Staff_ID'];
$Staff_Name 		= $_SESSION['Staff_Name'];

if ($_GET['menu'] == 'cari' ) {
	
	$keyword 	= $_POST['keyword'];
	$status 	= $_POST['status'];
	if ($status=='ALL') {
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' order by Inv_No DESC LIMIT 15");
	}elseif($status=='UNPAID'){
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Status_Payment='N' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}elseif($status=='PAID'){
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Status_Payment='Y' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}elseif($status=='UNTAKEN'){
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Status_Taken='N' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}elseif($status=='TAKEN'){
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Status_Taken='Y' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}
	

	while($data = mysqli_fetch_assoc($query)){
	?>
	<tr class="intro-x">
                                        
        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap" style="font-size: 17px;">#INV-<?php echo $data['Inv_Number'] ?></a> </td>
        <td class="w-40">
            <a href="" class="font-medium whitespace-nowrap"><?php echo $data['Cust_Nama'] ?></a> 
            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo $data['Cust_Alamat'] ?></div>
            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo $data['Cust_Telp'] ?></div>
        </td>
        <td>
            <div class="pr-16"><?php echo date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?></div>
            <div class="pr-16"><?php echo date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])); ?></div>
        </td>
        <td>
            <?php if ($data['Status_Payment']=='N') { ?>
                <div class="flex items-center whitespace-nowrap text-warning"> <img src="plugin/lucide/check-square.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(78%) sepia(61%) saturate(588%) hue-rotate(331deg) brightness(99%) contrast(96%);"> UNPAID </div>
                
            <?php }else{ 
                $cekpay = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Payment where Inv_Number='$data[Inv_Number]'"));
                ?>
                <div class="flex items-center whitespace-nowrap text-success"> <img src="plugin/lucide/check-square.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(28%) sepia(73%) saturate(3769%) hue-rotate(160deg) brightness(102%) contrast(90%);"> PAID </div>
                <div class="whitespace-nowrap"><?php echo $cekpay['Payment_Type'] ?></div>
                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo date('d M Y H:i:s', strtotime($cekpay['Payment_Tgl'])); ?>
                    <br>
                    <?php if ($data['Status_Taken']=='N') {
                        echo "<b class='text-danger'>UNTAKEN</b>";
                    }else{
                        echo "<b class='text-success'>".$data['Status_Taken']."</b>"; 
                    }?>
                </div>
            <?php } ?>
        </td>
        <td class="w-40 text-right">
            <div class="pr-16">Rp <?php echo number_format($data['Payment_Amount'] ,0,",",".")?></div>
        </td>
        <td class="table-report__action">
            <div class="flex justify-center items-center">
                <a class="flex items-center text-primary whitespace-nowrap mr-5" href="app?p=transactions_detail&invoice=<?php echo $data['Inv_Number'] ?>"> <img src="plugin/lucide/check-square.svg" class="w-4 h-4 mr-1 text-primary" style="box-shadow: none;filter: invert(15%) sepia(89%) saturate(1755%) hue-rotate(215deg) brightness(102%) contrast(96%);"> View Details </a>
                
                <div class="dropdown"> 
                    <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown"><img src="plugin/lucide/send.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(100%) sepia(0%) saturate(7500%) hue-rotate(70deg) brightness(99%) contrast(107%);"> Process Invoice</button> 
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
	<?php
	}
}