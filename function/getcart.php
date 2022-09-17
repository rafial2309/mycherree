<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php"; 

$Staff_ID 			= $_SESSION['Staff_ID'];

$query = mysqli_query($conn,"SELECT * from Invoice_Item where Inv_Number='' AND Staff_ID='$Staff_ID'");
while($data = mysqli_fetch_assoc($query)){
?>
<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
    <div class="max-w-[50%] truncate mr-1" style="text-transform:uppercase;"><?php echo $data['Deskripsi'] ?></div>
    <div class="text-slate-500">x <?php echo $data['Qty'] ?></div>
    <i data-lucide="edit" class="w-4 h-4 text-slate-500 ml-2"></i> 
    <div class="ml-auto font-medium">Rp <?php echo number_format($data['Total_Price'] ,0,",",".")?></div>
</a>
<?php } ?>