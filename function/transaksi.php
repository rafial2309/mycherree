<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";
$Staff_ID 			= $_SESSION['Staff_ID'];
$Staff_Name 		= $_SESSION['Staff_Name'];
$cabang             = $_SESSION['cabang'];

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

if ($_GET['menu'] == 'cari' ) {
	
	$keyword 	= $_POST['keyword'];
	$status 	= $_POST['status'];
	if ($status=='ALL') {
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}elseif($status=='UNPAID'){
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND Status_Payment='N' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}elseif($status=='PAID'){
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND Status_Payment='Y' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}elseif($status=='UNTAKEN'){
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND Status_Taken='N' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}elseif($status=='TAKEN'){
		$query 		= mysqli_query($conn,"SELECT * from Invoice where Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND Status_Taken!='N' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");
	}
	

	while($data = mysqli_fetch_assoc($query)){
	?>
	<tr class="intro-x">
                                        
        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap" style="font-size: 17px;"><?php echo $data['Inv_Number'] ?></a> </td>
        <td class="w-40">
            <a href="" class="font-medium whitespace-nowrap"><?php echo $data['Cust_Nama'] ?></a> 
            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo $data['Cust_Alamat'] ?></div>
            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5"><?php echo $data['Cust_Telp'] ?></div>
            <?php if ($data['Discount_No']=='1') { ?>
                <small class="text-success">MEMBER</small>
            <?php  }else{ ?>
                <small class="text-warning">NON-MEMBER</small>
            <?php } ?>
        </td>
        <td>
            <div class="pr-16"><?php echo date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])); ?></div>
            <div class="pr-16"><?php echo date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])); ?></div>
        </td>
        <td>
            <?php if ($data['Status_Payment']=='N') { ?>
                <div class="flex items-center whitespace-nowrap text-warning"> <img src="plugin/lucide/check-square.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(78%) sepia(61%) saturate(588%) hue-rotate(331deg) brightness(99%) contrast(96%);"> UNPAID </div>
                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                
                    <?php if ($data['Status_Taken']=='N') {
                       
                    }else{
                        echo "<b class='text-success'>".$data['Status_Taken']."</b>"; 
                    }?>
                </div>
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
                    <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown"><img src="plugin/lucide/send.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(100%) sepia(0%) saturate(7500%) hue-rotate(70deg) brightness(99%) contrast(107%);"> Process</button> 
                    <div class="dropdown-menu w-40"> 
                        <ul class="dropdown-content"> 
                            <li> <div class="dropdown-header">Process</div> </li> 
                            <li> <hr class="dropdown-divider"> </li> 
                            <li> <a href="javascript:;" onclick="printInvoice('<?= $data['Inv_Number']?>')" class="dropdown-item"> <img src="plugin/lucide/printer.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(0%) sepia(0%) saturate(7500%) hue-rotate(327deg) brightness(96%) contrast(104%);"> Print Invoice </a> </li> 
                            <?php if ($data['Status_Payment']=='N') { ?>
                            <li> <a href="javascript:;" onclick="gopayment('<?php echo $data['Inv_Number']  ?>###<?php echo $data['Payment_Amount']  ?>')" data-tw-toggle="modal" data-tw-target="#payment-modal" class="dropdown-item" class="dropdown-item"> <img src="plugin/lucide/credit-card.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(0%) sepia(0%) saturate(7500%) hue-rotate(327deg) brightness(96%) contrast(104%);"> Payment </a> 
                            </li> 
                            <?php } ?>
                            <?php if ($data['Status_Taken']=='N') { ?>
                            <li> <a href="javascript:;" onclick="gotaken('<?php echo $data['Inv_Number']  ?>###<?php echo $data['Payment_Amount']  ?>')" data-tw-toggle="modal" data-tw-target="#payment-modal" class="dropdown-item" class="dropdown-item" class="dropdown-item"> <img src="plugin/lucide/box.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(0%) sepia(0%) saturate(7500%) hue-rotate(327deg) brightness(96%) contrast(104%);"> Taken </a> 
                            </li> 
                            <?php } ?>

                            <?php if ($data['Status_Taken']=='N') { ?>
                            <li> <a href="javascript:;" onclick="cancelinvoice('<?php echo $data['Inv_Number'] ?>')" class="dropdown-item"> <img src="plugin/lucide/x-circle.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(0%) sepia(0%) saturate(7500%) hue-rotate(327deg) brightness(96%) contrast(104%);"> Cancel </a> </li> 
                            <?php } ?>

                            <li> <a href="app?p=rewash-start&invoice=<?php echo $data['Inv_Number'] ?>" class="dropdown-item"> <img src="plugin/lucide/refresh-cw.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(0%) sepia(0%) saturate(7500%) hue-rotate(327deg) brightness(96%) contrast(104%);"> Rewash </a> </li> 
                            
                        </ul> 
                    </div> 
                </div> 
            </div>
        </td>
    </tr>
	<?php
	}
}else if ($_GET['menu'] == 'cancel' ) {
    $id = $_POST['id'];
    

    $query = mysqli_query($conn,"UPDATE Invoice_Item SET Deskripsi=concat(Deskripsi, ' (CANCEL)'), Total_Price='0' WHERE Inv_Item_No='$id'");

    $datadetail = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Item_No='$id'"));
    $datainv    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice where Inv_Number='$datadetail[Inv_Number]'"));
    $discount   = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Discount where Discount_No='$datainv[Discount_No]'"));

    $total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Total_Price) as tot from Invoice_Item where Inv_Number='$datadetail[Inv_Number]'"));
    $subtotal = $total['tot'];

    if ($discount['Persentase']>0) {
        $persen   = ($discount['Persentase']/100) * intval($subtotal);
        $subtotal = round(intval($subtotal) - intval($persen));
    }

    $Payment_Before     = round($subtotal);
    $Payment_Amount     = angka_pembulatan($Payment_Before,2,100);
    $Payment_Rounding   = $Payment_Amount-$Payment_Before;

    $query = mysqli_query($conn,"UPDATE Invoice SET Payment_Before='$Payment_Before',Payment_Rounding='$Payment_Rounding',Payment_Amount='$Payment_Amount' WHERE Inv_Number='$datadetail[Inv_Number]'");

    echo 'Y';
    exit();
}else if ($_GET['menu'] == 'cancelinvoice' ) {
    $id = $_POST['id'];
    
    $Tgl        = date('Y-m-d');
    $notecancel = " (CANCEL) Date: " . $Tgl. "  (by ".$Staff_Name.")";

    $query = mysqli_query($conn,"UPDATE Invoice SET Note=concat(Note, ' (CANCEL) Date: $Tgl  (by $Staff_Name)'),Inv_Number=concat(Inv_Number, 'C'), Payment_Before='0', Payment_Amount='0', Payment_Rounding='0', Status_Inv='C' WHERE Inv_Number='$id'");
    $query = mysqli_query($conn,"UPDATE Invoice_Item SET Inv_Number=concat(Inv_Number, 'C') WHERE Inv_Number='$id'");


    
    echo 'Y';
    exit();
}else if ($_GET['menu'] == 'caricancel' ) {
    $keyword    = $_POST['keyword'];
    $status     = $_POST['status'];
    $query      = mysqli_query($conn,"SELECT * from Invoice where Inv_Number LIKE '%$cabang%' AND Status_Inv='C' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");

    while($data = mysqli_fetch_assoc($query)){
        $invoice = $data['Inv_Number'];
    ?>

    <tr class="intro-x">
                                        
        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap" style="font-size: 17px;"><?php echo $data['Inv_Number'] ?></a> </td>
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
                
                <button onclick="printInvoice('<?= $invoice ?>')" class="btn btn-primary shadow-md mr-2"> <img src="plugin/lucide/printer.svg" class="w-4 h-4 mr-1 text-primary" style="box-shadow: none;filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(288deg) brightness(102%) contrast(102%);"> PRINT </button>
            </div>
        </td>
    </tr>
    <?php
    }
}else if ($_GET['menu'] == 'carirewash' ) {
    $keyword    = $_POST['keyword'];
    $status     = $_POST['status'];
    $query      = mysqli_query($conn,"SELECT * from Invoice_Rewash where Inv_Number LIKE '%$cabang%' AND (Inv_Number LIKE '%$keyword%' OR Cust_Nama LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%' OR Cust_Alamat LIKE '%$keyword%') order by Inv_No DESC LIMIT 15");

    while($data = mysqli_fetch_assoc($query)){
        $invoice = $data['Inv_Number'];
    ?>

    <tr class="intro-x">
                                        
        <td class="w-40 !py-4"> <a href="" class="underline decoration-dotted whitespace-nowrap" style="font-size: 17px;"><?php echo $data['Inv_Number'] ?></a> </td>
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
            <?php if ($data['Status_Taken']=='N') { ?>
                <div onclick="taken('<?php echo $data['Inv_Number'] ?>')" class="flex items-center whitespace-nowrap text-warning"> <img src="plugin/lucide/check-square.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(78%) sepia(61%) saturate(588%) hue-rotate(331deg) brightness(99%) contrast(96%);"> UNTAKEN </div>
                
            <?php }else{ 
                $cekpay = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from Invoice_Payment where Inv_Number='$data[Inv_Number]'"));
                ?>
                <div class="flex items-center whitespace-nowrap text-success"> <img src="plugin/lucide/check-square.svg" class="w-4 h-4 mr-2" style="box-shadow: none;filter: invert(28%) sepia(73%) saturate(3769%) hue-rotate(160deg) brightness(102%) contrast(90%);"> <?php echo $data['Status_Taken'] ?> </div>
               
            <?php } ?>
        </td>
        <td class="w-40 text-right">
            <div class="pr-16">Rp <?php echo number_format($data['Payment_Amount'] ,0,",",".")?></div>
        </td>
        <td class="table-report__action">
            <div class="flex justify-center items-center">
                <a class="flex items-center text-primary whitespace-nowrap mr-5" href="app?p=transactions_rewash_detail&invoice=<?php echo $data['Inv_Number'] ?>"> <img src="plugin/lucide/check-square.svg" class="w-4 h-4 mr-1 text-primary" style="box-shadow: none;filter: invert(15%) sepia(89%) saturate(1755%) hue-rotate(215deg) brightness(102%) contrast(96%);"> View Details </a>
                
                <button onclick="printInvoice('<?= $invoice ?>')" class="btn btn-primary shadow-md mr-2"> <img src="plugin/lucide/printer.svg" class="w-4 h-4 mr-1 text-primary" style="box-shadow: none;filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(288deg) brightness(102%) contrast(102%);"> PRINT </button>
            </div>
        </td>
    </tr>
    <?php
    }
}else if ($_GET['menu'] == 'simpantaken' ) {
    $nama       = $_POST['doc'];
    $Inv_Number = $_POST['data'];
    
    $payer_name             = $nama;
    $pay_tgl_taken          = date('d M Y H:i:s');

    $isitaken = "TAKEN#BY ". $payer_name . " #".$pay_tgl_taken;
    mysqli_query($conn,"UPDATE Invoice_Rewash SET Status_Taken='$isitaken' where Inv_Number='$Inv_Number'");


    
    echo 'Y';
    exit();
}else if ($_GET['menu'] == 'updatecust') { 
    $id     = explode('+',$_POST['id']);
    $Invnya = $_POST['invoice'];
    $data   = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Cust_No,Cust_Nama,Discount_No from Customer WHERE Cust_No='$id[0]'"));

    $Cust_No        = $data['Cust_No'];
    $Cust_Nama      = $data['Cust_Nama'];
    $Cust_Telp      = $_POST['Cust_Telp'];
    $Cust_Alamat    = $_POST['Cust_Alamat'];
    $Discount_No    = $data['Discount_No'];

    mysqli_query($conn,"UPDATE Invoice SET Cust_ID='$Cust_No',Cust_Nama='$Cust_Nama',Cust_Alamat='$Cust_Alamat',Cust_Telp='$Cust_Telp',Discount_No='$Discount_No' WHERE Inv_Number='$Invnya'");


    $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Total_Price) as Total_Price from Invoice_Item WHERE Inv_Number='$Invnya'"));

    $subtotal   = $data['Total_Price'];

    if (isset($Cust_No)) {
        $datadisc = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Discount.Persentase,Customer.Cust_Member_Name from Customer join Discount on Customer.Discount_No=Discount.Discount_No WHERE Customer.Discount_No!=0 AND Cust_No='$Cust_No'"));
        if (isset($datadisc['Persentase'])) {
            $persentase = $datadisc['Persentase'];
            $namadiskon = $datadisc['Cust_Member_Name'];
            $diskon     = round(($datadisc['Persentase']/100)*$subtotal);
        }else{
            $diskon     = 0;
        }    
    }else{
        $diskon     = 0;
    }
    
    $total      = $subtotal - $diskon;

    $Total_Diskon       = $diskon;
    $Payment_Before     = round($total);
    $Payment_Amount     = angka_pembulatan($Payment_Before,2,100);
    $Payment_Rounding   = $Payment_Amount-$Payment_Before;

    mysqli_query($conn,"UPDATE Invoice SET Total_Diskon='$Total_Diskon',Payment_Before='$Payment_Before',Payment_Rounding='$Payment_Rounding',Payment_Amount='$Payment_Amount' WHERE Inv_Number='$Invnya'");

    echo 'Y';
    exit();

}else if ($_GET['menu'] == 'updatestatus') { 
    $status     = $_POST['status'];
    $invoice    = $_POST['invoice'];

    if ($status=='pay') {
        $paid    = $_POST['paid'];
        if ($paid=='N') {
            mysqli_query($conn,"UPDATE Invoice SET Status_Payment='N' WHERE Inv_Number='$invoice'");
            mysqli_query($conn,"DELETE FROM Invoice_Payment WHERE Inv_Number='$invoice'");
        }
        
    }else{
        $taken    = $_POST['taken'];
        if ($taken=='N') {
            mysqli_query($conn,"UPDATE Invoice SET Status_Taken='N' WHERE Inv_Number='$invoice'");
        }else{
            $name    = $_POST['name'];
            mysqli_query($conn,"UPDATE Invoice SET Status_Taken='$name' WHERE Inv_Number='$invoice'");
        }
    }
    echo 'Y';
    exit();
}