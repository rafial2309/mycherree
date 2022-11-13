<?php

date_default_timezone_set("Asia/Jakarta");
$hariini        = date('Y-m-d');
$bulanini       = date('m');
$tahunini       = date('Y');
$cabang         = $_SESSION['cabang'];
$totalsales     = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Payment_Amount) as total from Invoice WHERE Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND YEAR(Inv_Tgl_Masuk)='$tahunini' AND MONTH(Inv_Tgl_Masuk)='$bulanini'"));

$totalpcs       = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Total_PCS) as total from Invoice WHERE Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND YEAR(Inv_Tgl_Masuk)='$tahunini' AND MONTH(Inv_Tgl_Masuk)='$bulanini'"));

$totalcust      = mysqli_fetch_assoc(mysqli_query($conn,"SELECT count(Cust_ID) as total from Invoice WHERE Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND YEAR(Inv_Tgl_Masuk)='$tahunini' AND MONTH(Inv_Tgl_Masuk)='$bulanini' GROUP BY Cust_ID"));

$totalpayment   = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Payment_Total) as total from Invoice_Payment WHERE Inv_Number LIKE '%$cabang%' AND YEAR(Payment_Tgl)='$tahunini' AND MONTH(Payment_Tgl)='$bulanini'"));


$todaysales     = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Payment_Amount) as total from Invoice WHERE Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND Inv_Tgl_Masuk='$hariini'"));

$todaypcs       = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Total_PCS) as total from Invoice WHERE Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND Inv_Tgl_Masuk='$hariini'"));

$todaycust      = mysqli_fetch_assoc(mysqli_query($conn,"SELECT count(Cust_ID) as total from Invoice WHERE Inv_Number LIKE '%$cabang%' AND Status_Inv!='C' AND Inv_Tgl_Masuk='$hariini' GROUP BY Cust_ID"));

$todaypayment   = mysqli_fetch_assoc(mysqli_query($conn,"SELECT sum(Payment_Total) as total from Invoice_Payment WHERE Inv_Number LIKE '%$cabang%' AND Payment_Tgl='$hariini'"));
?>

<div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 2xl:col-span-9">
                            <div class="grid grid-cols-12 gap-6">
                                <!-- BEGIN: General Report -->
                                <div class="col-span-12 mt-8">
                                    <div class="intro-y flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-5">
                                            Report Month to Date
                                        </h2>
                                        <a href="app" class="ml-auto flex items-center text-primary"> <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                                    </div>
                                    <div class="grid grid-cols-12 gap-6 mt-5">
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6"><?php if (isset($todaysales['total'])) {
                                                        echo number_format($todaysales['total'] ,0,",",".");
                                                    } ?></div>
                                                    <div class="text-base text-slate-500 mt-1">Today Sales</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6"><?php if (isset($todaypayment['total'])) {
                                                        echo number_format($todaypayment['total'] ,0,",",".");
                                                    } ?></div>
                                                    <div class="text-base text-slate-500 mt-1">Today Payment</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6"><?php if (isset($todaypcs['total'])) {
                                                        echo number_format($todaypcs['total'] ,0,",",".");
                                                    } ?></div>
                                                    <div class="text-base text-slate-500 mt-1">Today Pcs</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="user" class="report-box__icon text-success"></i> 
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6"><?php if (isset($todaycust['total'])) {
                                                        echo number_format($todaycust['total'] ,0,",",".");
                                                    } ?></div>
                                                    <div class="text-base text-slate-500 mt-1">Today Customers</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: General Report -->
                               
                                <!-- BEGIN: General Report -->
                                <div class="col-span-12 mt-3">

                                    <div class="grid grid-cols-12 gap-6 mt-3">
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="shopping-cart" class="report-box__icon text-primary"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6"><?php if (isset($totalsales['total'])) {
                                                        echo number_format($totalsales['total'] ,0,",",".");
                                                    } ?></div>
                                                    <div class="text-base text-slate-500 mt-1">Total Sales</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="credit-card" class="report-box__icon text-pending"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6"><?php if (isset($totalpayment['total'])) {
                                                        echo number_format($totalpayment['total'] ,0,",",".");
                                                    } ?></div>
                                                    <div class="text-base text-slate-500 mt-1">Total Payment</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="monitor" class="report-box__icon text-warning"></i>
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6"><?php if (isset($totalpcs['total'])) {
                                                        echo number_format($totalpcs['total'] ,0,",",".");
                                                    } ?></div>
                                                    <div class="text-base text-slate-500 mt-1">Total Pcs</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                            <div class="report-box zoom-in">
                                                <div class="box p-5">
                                                    <div class="flex">
                                                        <i data-lucide="user" class="report-box__icon text-success"></i> 
                                                    </div>
                                                    <div class="text-3xl font-medium leading-8 mt-6"><?php if (isset($totalcust['total'])) {
                                                        echo number_format($totalcust['total'] ,0,",",".");
                                                    } ?></div>
                                                    <div class="text-base text-slate-500 mt-1">Total Customers</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: General Report -->
                            </div>
                        </div>
                        <div class="col-span-12 2xl:col-span-3">
                            <div class="2xl:border-l -mb-10 pb-10">
                                <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                                    <!-- BEGIN: Transactions -->
                                    <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                                        <div class="intro-x flex items-center h-10">
                                            <h2 class="text-lg font-medium truncate mr-5">
                                                Transactions
                                            </h2>
                                        </div>
                                        <div class="mt-5">
                                            <?php
                                                $queryinv = mysqli_query($conn,"SELECT Inv_Number,Cust_Nama,Payment_Amount from Invoice WHERE Status_Inv!='C' order by Inv_No DESC LIMIT 6");
                                                while ($datainv = mysqli_fetch_assoc($queryinv)) {
                                                 
                                            ?>
                                            <div class="intro-x">
                                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                                        <img alt="Midone - HTML Admin Template" src="dist/images/receipt.png">
                                                    </div>
                                                    <div class="ml-4 mr-auto">
                                                        <div class="font-medium">#INV-<?php echo $datainv['Inv_Number'] ?></div>
                                                        <div class="text-slate-500 text-xs mt-0.5"><?php echo $datainv['Cust_Nama'] ?></div>
                                                    </div>
                                                    <div class="text-success">Rp <?php echo number_format($datainv['Payment_Amount'] ,0,",",".")?></div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <a href="app?p=transactions" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View Transaction Invoice</a> 
                                        </div>
                                    </div>
                                    <!-- END: Transactions -->
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Content -->
            </div>
            <?php include 'appjs.php'; ?>
           