<?php
require '../config/configuration.php';
require '../vendor/autoload.php';
session_start();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\{Alignment, Border, Color, Fill, NumberFormat};

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->mergeCells('A1:G1');
$sheet->mergeCells('A2:G2');
$sheet->setCellValue('A1', 'My Cherree Laundry');
$sheet->setCellValue('A2', 'Bukit Golf Mediterania RT.7/RW.2, Kamal Muara, Kec. Penjaringan, Kota Jkt Utara, DKI Jakarta 14470');

if ($_GET['type'] == 'customer') {
    $judul  = 'Customer';
    $search = $_GET['search'];
    
    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Nama');
    $sheet->setCellValue('C3', 'Telepon');
    $sheet->setCellValue('D3', 'Alamat');
    $sheet->setCellValue('E3', 'Status Membership');
    $sheet->setCellValue('F3', 'Tanggal Join');
    $sheet->setCellValue('G3', 'Last Order');
    $sheet->setCellValue('H3', 'Total Amount');
    $sheet->setCellValue('I3', 'Total Order');
    
    $sheet->getStyle('A3:I3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:I3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:I3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;
    $init   = 0;
    
    $additionalQuery = ($search <> '') ? "AND (Cust_Nama like '%$search%' OR Cust_Alamat like '%$search%' OR Cust_Telp like '%$search%' OR Cust_Member_Name like '%$search%')" : '';
    
    $sql  = mysqli_query($conn, "SELECT Customer.*, (SELECT SUM(Payment_Amount) FROM Invoice WHERE Invoice.Cust_ID = Customer.Cust_No) as Total_Amount, (SELECT SUM(Total_PCS) FROM Invoice WHERE Invoice.Cust_ID = Customer.Cust_No) as Total_PCS, Invoice.Inv_Tgl_Masuk FROM Customer LEFT JOIN Invoice ON Customer.Cust_No = Invoice.Cust_ID WHERE Cust_Status ='Y' $additionalQuery ORDER BY Total_PCS DESC");
    while ($data = mysqli_fetch_assoc($sql)) {
        $last   = ($data['Inv_Tgl_Masuk'] == '') ? '-' : date('D, d M Y', strtotime($data['Inv_Tgl_Masuk']));
        $amount = ($data['Total_Amount'] == null) ? 0 : $data['Total_Amount'];
        $pcs    = ($data['Total_PCS'] == null) ? $init.' pcs' : number_format($data['Total_PCS'],0,',','.').' pcs';
        
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('C' . $baris, $data['Cust_Telp']);
        $sheet->setCellValue('D' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('E' . $baris, ($data['Cust_Member_Name'] <> '') ? 'MEMBER' : 'NONMEMBER');
        $sheet->setCellValue('F' . $baris, date('D, d M Y', strtotime($data['Cust_Tgl_Join'])));
        $sheet->setCellValue('G' . $baris, $last);
        $sheet->setCellValue('H' . $baris, $amount);
        $sheet->setCellValue('I' . $baris, $pcs);
        $baris++;
        $no++;
    }
    
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    
    $akhir = $baris - 1; 
    $sheet->getStyle('C4:C' . $akhir)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
    $sheet->getStyle('A4:I' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('H4:H' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');

} elseif ($_GET['type'] == 'membership') {
    $judul  = 'Membership';
    $search = $_GET['search'];

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Tanggal');
    $sheet->setCellValue('C3', 'Nama');
    $sheet->setCellValue('D3', 'Status');
    $sheet->setCellValue('E3', 'Tipe Pembayaran');
    $sheet->setCellValue('F3', 'Jumlah');
    $sheet->setCellValue('G3', 'Join - Expired');
    
    $sheet->getStyle('A3:G3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:G3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:G3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;
    
    $additionalQuery = ($search <> '') ? "WHERE Cust_Nama like '%$search%' OR Payment_Type like '%$search%'" : '';
    
    $sql = mysqli_query($conn, "SELECT *FROM Registrasi_Member $additionalQuery");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, date('D, d M Y', strtotime($data['Registrasi_Tgl'])));
        $sheet->setCellValue('C' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('D' . $baris, ($data['Status_Payment'] == 'Y') ? 'LUNAS' : 'BELUM BAYAR');
        $sheet->setCellValue('E' . $baris, $data['Payment_Type']);
        $sheet->setCellValue('F' . $baris, $data['Registrasi_Payment']);
        $sheet->setCellValue('G' . $baris, date('D, d M Y', strtotime($data['Cust_Member_Join'])).' - '.date('D, d M Y', strtotime($data['Cust_Member_Join'])));
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('A4:G' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('F4:F' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');

}  elseif ($_GET['type'] == 'item') {
    $judul  = 'Master Item';
    $search = $_GET['search'];

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Nama Item');
    $sheet->setCellValue('C3', 'Kategori');
    $sheet->setCellValue('D3', 'Harga');
    $sheet->setCellValue('E3', 'Jumlah');
    
    $sheet->getStyle('A3:E3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:E3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:E3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;
   
    $additionalQuery = ($search <> '') ? "AND (Item_Name like '%$search%' OR Item_Category like '%$search%' OR Item_Price like '%$search%' OR Item_Pcs like '%$search%')" : ''; 
   
    $sql = mysqli_query($conn, "SELECT *FROM Master_Item WHERE Item_Status='Y' $additionalQuery");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Item_Name']);
        $sheet->setCellValue('C' . $baris, $data['Item_Category']);
        $sheet->setCellValue('D' . $baris, $data['Item_Price']);
        $sheet->setCellValue('E' . $baris, $data['Item_Pcs']);
        $baris++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('A4:E' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('D4:E' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');

}  elseif ($_GET['type'] == 'colour') {
    $judul  = 'Master Colour';
    $search = $_GET['search'];

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Colour Name');
    
    $sheet->getStyle('A3:B3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:B3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:B3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;

    $additionalQuery = ($search <> '') ? "AND Colour_Name like '%$search%'" : ''; 
    
    $sql = mysqli_query($conn, "SELECT *FROM Master_Colour WHERE Colour_Status='Y' $additionalQuery");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Colour_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('A4:B' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

}   elseif ($_GET['type'] == 'brand') {
    $judul  = 'Master Brand';
    $search = $_GET['search'];

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Brand Name');
    
    $sheet->getStyle('A3:B3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:B3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:B3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;

    $additionalQuery = ($search <> '') ? "AND Brand_Name like '%$search%'" : ''; 
    
    $sql = mysqli_query($conn, "SELECT *FROM Master_Brand WHERE Brand_Status='Y' $additionalQuery");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Brand_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('A4:B' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

} elseif ($_GET['type'] == 'discount') {
    $judul  = 'Promo & Discount';
    $search = $_GET['search'];

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Discount Name');
    $sheet->setCellValue('C3', 'Discount Type');
    $sheet->setCellValue('D3', 'Presentase');
    
    $sheet->getStyle('A3:D3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:D3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:D3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;
    
    $additionalQuery = ($search <> '') ? "AND (Discount_Nama like '%$search%' OR Discount_Type like '%$search%' OR Persentase like '%$search%')" : '';
    
    $sql = mysqli_query($conn, "SELECT *FROM Discount WHERE Discount_Status='Y' $additionalQuery");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Discount_Nama']);
        $sheet->setCellValue('C' . $baris, $data['Discount_Type']);
        $sheet->setCellValue('D' . $baris, $data['Persentase'].'%');
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('A4:D' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

} elseif ($_GET['type'] == 'staff') {
    $judul  = 'Staff & Karyawan';
    $search = $_GET['search'];

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Staff ID');
    $sheet->setCellValue('C3', 'Staff Name');
    $sheet->setCellValue('D3', 'TTL');
    $sheet->setCellValue('E3', 'Telp');
    $sheet->setCellValue('F3', 'Address');
    $sheet->setCellValue('G3', 'Access');
    
    $sheet->getStyle('A3:G3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:G3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:G3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris = 4;
    $no = 1;

    $additionalQuery = ($search <> '') ? "AND (Staff_ID like '%$search%' OR Staff_Name like '%$search%' OR Staff_Tempat_Lahir like '%$search%' OR Staff_Alamat like '%$search%' OR Staff_Access like '%$search%')" : ''; 
    
    $sql = mysqli_query($conn, "SELECT *FROM Staff WHERE Staff_Status='Y' $additionalQuery");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Staff_ID']);
        $sheet->setCellValue('C' . $baris, $data['Staff_Name']);
        $sheet->setCellValue('D' . $baris, $data['Staff_Tempat_Lahir'].', '. date('d-m-Y', strtotime($data['Staff_Tgl_Lahir'])));
        $sheet->setCellValue('E' . $baris, $data['Staff_Telp']);
        $sheet->setCellValue('F' . $baris, $data['Staff_Alamat']);
        $sheet->setCellValue('G' . $baris, $data['Staff_Access']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('A4:G' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

} elseif ($_GET['type'] == 'daily-invoice') {
    $start  = date('Y-m-d', strtotime($_POST['start']));
    $end    = date('Y-m-d', strtotime($_POST['end']));
    $judul  = 'Daily Invoice';

    $sheet->setCellValue('A3', 'Report Invoice ' . date('D, d M Y', strtotime($start)).' - '.date('D, d M Y', strtotime($end)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Masuk');
    $sheet->setCellValue('D4', 'Tanggal Selesai');
    $sheet->setCellValue('E4', 'Nama Customer');
    $sheet->setCellValue('F4', 'Alamat');
    $sheet->setCellValue('G4', 'Total PCS');
    $sheet->setCellValue('H4', 'Total Pembayaran');
    $sheet->setCellValue('I4', 'Status');
    $sheet->setCellValue('J4', 'Payment');
    $sheet->setCellValue('K4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:K4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:K4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:K4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;
    $cabang = $_SESSION['cabang'];

    $sql = mysqli_query($conn, "SELECT *FROM Invoice JOIN Customer ON Invoice.Cust_ID = Customer.Cust_No WHERE Invoice.Inv_Number LIKE '%$cabang%' AND Invoice.Inv_Tgl_Masuk BETWEEN '$start' AND '$end'");
    while ($data = mysqli_fetch_assoc($sql)) {
        if ($data['Status_Payment'] == 'Y') {
            $cektipe = mysqli_fetch_assoc(mysqli_query($conn,"SELECT Payment_Type from Invoice_Payment WHERE Inv_Number='$data[Inv_Number]'"));
        }
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])));
        $sheet->setCellValue('D' . $baris, date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])));
        $sheet->setCellValue('E' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('F' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('G' . $baris, $data['Total_PCS']);
        $sheet->setCellValue('H' . $baris, $data['Payment_Amount']);
        $sheet->setCellValue('I' . $baris, ($data['Cust_Member_Name'] == 'MEMBER') ? 'MEMBER' : 'NONMEMBER');
        $sheet->setCellValue('J' . $baris, ($data['Status_Payment'] == 'Y') ? 'PAID '.$cektipe['Payment_Type'] : 'UNPAID');
        $sheet->setCellValue('K' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    $akhir = $baris - 1; 

    $query = mysqli_query($conn, "SELECT sum(Payment_Amount) as Total_Amount, sum(Total_PCS) as Total_PCS, Inv_Tgl_Masuk FROM Invoice WHERE Inv_Number LIKE '%$cabang%' AND Inv_Tgl_Masuk BETWEEN '$start' AND '$end'");
    $total = mysqli_fetch_assoc($query);
    
    $mulai = $akhir + 3;
    $after = $mulai + 1;

    $sheet->setCellValue('G' . $mulai, 'Total PCS');
    $sheet->setCellValue('H' . $mulai, 'Total Amount');
    
    $sheet->setCellValue('G' . $after, $total['Total_PCS']);
    $sheet->setCellValue('H' . $after, $total['Total_Amount']);
    
    $sheet->getStyle('G'.$mulai.':H' . $after)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G'.$after.':H' . $after)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
      
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:K' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G5:H' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);
    $sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(15);

} elseif ($_GET['type'] == 'monthly-invoice') {
    $month  = date('Y-m-d', strtotime($_POST['month']));
    $judul  = 'Monthly Invoice';
    
    $sheet->setCellValue('A3', 'Report Invoice ' . date('M Y', strtotime($month)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Masuk');
    $sheet->setCellValue('D4', 'Tanggal Selesai');
    $sheet->setCellValue('E4', 'Nama Customer');
    $sheet->setCellValue('F4', 'Alamat');
    $sheet->setCellValue('G4', 'Total PCS');
    $sheet->setCellValue('H4', 'Total Pembayaran');
    $sheet->setCellValue('I4', 'Status');
    $sheet->setCellValue('J4', 'Payment');
    $sheet->setCellValue('K4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:K4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:K4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:K4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;

    $bulan = substr($month, 5, 2);
    $tahun = substr($_POST['month'], -4);
    $cabang = $_SESSION['cabang'];
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice JOIN Customer ON Invoice.Cust_ID = Customer.Cust_No WHERE Invoice.Inv_Number LIKE '%$cabang%' AND MONTH(Invoice.Inv_Tgl_Masuk)='$bulan' AND YEAR(Invoice.Inv_Tgl_Masuk)='$tahun'");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])));
        $sheet->setCellValue('D' . $baris, date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])));
        $sheet->setCellValue('E' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('F' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('G' . $baris, $data['Total_PCS']);
        $sheet->setCellValue('H' . $baris, $data['Payment_Amount']);
        $sheet->setCellValue('I' . $baris, ($data['Cust_Member_Name'] == 'MEMBER') ? 'MEMBER' : 'NONMEMBER');
        $sheet->setCellValue('J' . $baris, ($data['Status_Payment'] == 'Y') ? 'PAID' : 'UNPAID');
        $sheet->setCellValue('K' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }

    $akhir = $baris - 1; 

    $query = mysqli_query($conn, "SELECT sum(Payment_Amount) as Total_Amount, sum(Total_PCS) as Total_PCS, Inv_Tgl_Masuk FROM Invoice WHERE Inv_Number LIKE '%$cabang%' AND MONTH(Inv_Tgl_Masuk)='$bulan' AND YEAR(Inv_Tgl_Masuk)='$tahun'");
    $total = mysqli_fetch_assoc($query);
    
    $mulai = $akhir + 3;
    $after = $mulai + 1;

    $sheet->setCellValue('G' . $mulai, 'Total PCS');
    $sheet->setCellValue('H' . $mulai, 'Total Amount');
    
    $sheet->setCellValue('G' . $after, $total['Total_PCS']);
    $sheet->setCellValue('H' . $after, $total['Total_Amount']);
    
    $sheet->getStyle('G'.$mulai.':H' . $after)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G'.$after.':H' . $after)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:K' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G5:H' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);
    $sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(15);

} elseif ($_GET['type'] == 'yearly-invoice') {
    $year   = date('Y-m-d', strtotime($_POST['year']));
    $judul  = 'Yearly Invoice';

    $sheet->setCellValue('A3', 'Report Invoice ' . date('Y', strtotime($year)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Masuk');
    $sheet->setCellValue('D4', 'Tanggal Selesai');
    $sheet->setCellValue('E4', 'Nama Customer');
    $sheet->setCellValue('F4', 'Alamat');
    $sheet->setCellValue('G4', 'Total PCS');
    $sheet->setCellValue('H4', 'Total Pembayaran');
    $sheet->setCellValue('I4', 'Status');
    $sheet->setCellValue('J4', 'Payment');
    $sheet->setCellValue('K4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:K4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:K4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:K4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;

    $tahun  = substr($_POST['year'], -4);
    $cabang = $_SESSION['cabang'];

    $sql = mysqli_query($conn, "SELECT *FROM Invoice JOIN Customer ON Invoice.Cust_ID = Customer.Cust_No WHERE Inv_Number LIKE '%$cabang%' AND YEAR(Invoice.Inv_Tgl_Masuk)='$tahun'");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])));
        $sheet->setCellValue('D' . $baris, date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])));
        $sheet->setCellValue('E' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('F' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('G' . $baris, $data['Total_PCS']);
        $sheet->setCellValue('H' . $baris, $data['Payment_Amount']);
        $sheet->setCellValue('I' . $baris, ($data['Cust_Member_Name'] == 'MEMBER') ? 'MEMBER' : 'NONMEMBER');
        $sheet->setCellValue('J' . $baris, ($data['Status_Payment'] == 'Y') ? 'PAID' : 'UNPAID');
        $sheet->setCellValue('K' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    $akhir = $baris - 1; 

    $query = mysqli_query($conn, "SELECT sum(Payment_Amount) as Total_Amount, sum(Total_PCS) as Total_PCS, Inv_Tgl_Masuk FROM Invoice WHERE Inv_Number LIKE '%$cabang%' AND YEAR(Inv_Tgl_Masuk)='$tahun'");
    $total = mysqli_fetch_assoc($query);
    
    $mulai = $akhir + 3;
    $after = $mulai + 1;

    $sheet->setCellValue('G' . $mulai, 'Total PCS');
    $sheet->setCellValue('H' . $mulai, 'Total Amount');
    
    $sheet->setCellValue('G' . $after, $total['Total_PCS']);
    $sheet->setCellValue('H' . $after, $total['Total_Amount']);
    
    $sheet->getStyle('G'.$mulai.':H' . $after)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G'.$after.':H' . $after)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:K' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G5:H' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);
    $sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(15);


}  elseif ($_GET['type'] == 'daily-payment') {
    $start  = date('Y-m-d', strtotime($_POST['start']));
    $end    = date('Y-m-d', strtotime($_POST['end']));
    $judul  = 'Daily Payment';

    $sheet->setCellValue('A3', 'Report Payment ' . date('D, d M Y', strtotime($start)).' - '.date('D, d M Y', strtotime($end)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Payment');
    $sheet->setCellValue('D4', 'Dibayar oleh');
    $sheet->setCellValue('E4', 'Total Pembayaran');
    $sheet->setCellValue('F4', 'Tipe Pembayaran');
    $sheet->setCellValue('G4', 'Catatan');
    $sheet->setCellValue('H4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:H4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:H4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:H4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;
    $cabang = $_SESSION['cabang'];
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice_Payment WHERE Inv_Number LIKE '%$cabang%' AND DATE(Payment_Tgl) >= '$start' AND DATE(Payment_Tgl) <= '$end'");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Payment_Tgl'])));
        $sheet->setCellValue('D' . $baris, $data['Payment_Name']);
        $sheet->setCellValue('E' . $baris, $data['Payment_Total']);
        $sheet->setCellValue('F' . $baris, $data['Payment_Type']);
        $sheet->setCellValue('G' . $baris, $data['Payment_Note']);
        $sheet->setCellValue('H' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:H' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('E5:E' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);

} elseif ($_GET['type'] == 'monthly-payment') {
    $month  = date('Y-m-d', strtotime($_POST['month']));
    $judul  = 'Monthly Payment';

    $sheet->setCellValue('A3', 'Report Payment ' . date('M Y', strtotime($month)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Payment');
    $sheet->setCellValue('D4', 'Dibayar oleh');
    $sheet->setCellValue('E4', 'Total Pembayaran');
    $sheet->setCellValue('F4', 'Tipe Pembayaran');
    $sheet->setCellValue('G4', 'Catatan');
    $sheet->setCellValue('H4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:H4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:H4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:H4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;
    
    $bulan = substr($month, 5, 2);
    $tahun = substr($_POST['month'], -4);
    
    $cabang = $_SESSION['cabang'];

    $sql = mysqli_query($conn, "SELECT *FROM Invoice_Payment WHERE Inv_Number LIKE '%$cabang%' AND MONTH(Payment_Tgl)='$bulan' AND YEAR(Payment_Tgl)='$tahun'");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Payment_Tgl'])));
        $sheet->setCellValue('D' . $baris, $data['Payment_Name']);
        $sheet->setCellValue('E' . $baris, $data['Payment_Total']);
        $sheet->setCellValue('F' . $baris, $data['Payment_Type']);
        $sheet->setCellValue('G' . $baris, $data['Payment_Note']);
        $sheet->setCellValue('H' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:H' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('E5:E' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);

} elseif ($_GET['type'] == 'yearly-payment') {
    $year   = date('Y-m-d', strtotime($_POST['year']));
    $judul  = 'Yearly Payment';

    $sheet->setCellValue('A3', 'Report Payment ' . date('Y', strtotime($year)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Payment');
    $sheet->setCellValue('D4', 'Dibayar oleh');
    $sheet->setCellValue('E4', 'Total Pembayaran');
    $sheet->setCellValue('F4', 'Tipe Pembayaran');
    $sheet->setCellValue('G4', 'Catatan');
    $sheet->setCellValue('H4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:H4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:H4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:H4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;
    
    $tahun = substr($_POST['year'], -4);
    $cabang = $_SESSION['cabang'];
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice_Payment WHERE Inv_Number LIKE '%$cabang%' AND YEAR(Payment_Tgl)='$tahun'");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Payment_Tgl'])));
        $sheet->setCellValue('D' . $baris, $data['Payment_Name']);
        $sheet->setCellValue('E' . $baris, $data['Payment_Total']);
        $sheet->setCellValue('F' . $baris, $data['Payment_Type']);
        $sheet->setCellValue('G' . $baris, $data['Payment_Note']);
        $sheet->setCellValue('H' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:H' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('E5:E' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);

} elseif ($_GET['type'] == 'data' && $_GET['data'] == 'daily-invoice') {
    $start  = date('Y-m-d', strtotime($_POST['start']));
    $end    = date('Y-m-d', strtotime($_POST['end']));

    $month  = date('Y-m-d', strtotime($_POST['month']));
    $year   = date('Y-m-d', strtotime($_POST['year']));

    $bulan  = substr($month, 5, 2);
    $tahun  = substr($_POST['month'], -4);

    $yearly = substr($_POST['year'], -4);

    $type   = $_POST['type'];
    $cabang = $_SESSION['cabang'];

    if ($type == 'daily')
        $sql = mysqli_query($conn, "SELECT * from Invoice JOIN Customer ON Invoice.Cust_ID = Customer.Cust_No WHERE Invoice.Inv_Number LIKE '%$cabang%' AND Invoice.Inv_Tgl_Masuk BETWEEN '$start' AND '$end'");
    elseif ($type == 'monthly')
        $sql = mysqli_query($conn, "SELECT * from Invoice JOIN Customer ON Invoice.Cust_ID = Customer.Cust_No WHERE Invoice.Inv_Number LIKE '%$cabang%' AND MONTH(Inv_Tgl_Masuk)='$bulan' AND YEAR(Inv_Tgl_Masuk)='$tahun'");
    else  
        $sql = mysqli_query($conn, "SELECT * from Invoice JOIN Customer ON Invoice.Cust_ID = Customer.Cust_No WHERE Invoice.Inv_Number LIKE '%$cabang%' AND YEAR(Inv_Tgl_Masuk)='$yearly'");

    $data = array();
    $json = array();
    $i = 1;
    while( $row=mysqli_fetch_array($sql) ) {

        $nestedData=array(); 
        $nestedData['Inv_Number']       = $row["Inv_Number"];
        $nestedData['Inv_Tgl_Masuk']    = date('D, d M Y', strtotime($row['Inv_Tgl_Masuk']));
        $nestedData['Inv_Tg_Selesai']   = date('D, d M Y', strtotime($row['Inv_Tg_Selesai']));
        $nestedData['Cust_Nama']        = $row["Cust_Nama"];
        $nestedData['Cust_Alamat']      = $row["Cust_Alamat"];
        $nestedData['Total_PCS']        = number_format($row["Total_PCS"],0,',','.');
        $nestedData['Payment_Amount']   = number_format($row["Payment_Amount"],0,',','.');
        $nestedData['Cust_Member_Name'] = ($row['Cust_Member_Name'] == 'MEMBER') ? 'MEMBER' : 'NONMEMBER';
        $nestedData['Status_Payment']   = ($row['Status_Payment'] == 'Y') ? 'PAID' : 'UNPAID';
        $nestedData['Staff_Name']       = $row["Staff_Name"];
        
        $data[] = $nestedData;
    }
    $json['data'] = $data;
    echo json_encode($json);
    exit();
}  elseif ($_GET['type'] == 'data' && $_GET['data'] == 'daily-payment') {
    $start  = date('Y-m-d', strtotime($_POST['start']));
    $end    = date('Y-m-d', strtotime($_POST['end']));

    $month  = date('Y-m-d', strtotime($_POST['month']));
    $year   = date('Y-m-d', strtotime($_POST['year']));

    $bulan  = substr($month, 5, 2);
    $tahun  = substr($_POST['month'], -4);

    $yearly = substr($_POST['year'], -4);
    
    $type   = $_POST['type'];
    $cabang = $_SESSION['cabang'];

    if ($type == 'daily')
        $sql = mysqli_query($conn, "SELECT * from Invoice_Payment WHERE Inv_Number LIKE '%$cabang%' AND DATE(Payment_Tgl) >='$start' AND DATE(Payment_Tgl) <= '$end'");
    elseif ($type == 'monthly')
        $sql = mysqli_query($conn, "SELECT * from Invoice_Payment WHERE Inv_Number LIKE '%$cabang%' AND MONTH(Payment_Tgl)='$bulan' AND YEAR(Payment_Tgl)='$tahun'");
    else  
        $sql = mysqli_query($conn, "SELECT * from Invoice_Payment WHERE Inv_Number LIKE '%$cabang%' AND YEAR(Payment_Tgl)='$yearly'");

    $data = array();
    $json = array();
    $i = 1;
    while( $row=mysqli_fetch_array($sql) ) {

        $nestedData=array(); 
        $nestedData['Inv_Number']       = $row["Inv_Number"];
        $nestedData['Payment_Tgl']      = date('D, d M Y', strtotime($row['Payment_Tgl']));
        $nestedData['Payment_Name']     = $row["Payment_Name"];
        $nestedData['Payment_Type']     = $row["Payment_Type"];
        $nestedData['Payment_Total']    = number_format($row["Payment_Total"],0,',','.');
        $nestedData['Staff_Name']       = $row["Staff_Name"];
        $nestedData['Payment_Note']     = $row["Payment_Note"];
        
        $data[] = $nestedData;
    }
    $json['data'] = $data;
    echo json_encode($json);
    exit();
} elseif ($_GET['type'] == 'data' && $_GET['data'] == 'daily-marking') {
    $start  = date('Y-m-d', strtotime($_POST['start']));
    $end    = date('Y-m-d', strtotime($_POST['end']));

    $month  = date('Y-m-d', strtotime($_POST['month']));
    $year   = date('Y-m-d', strtotime($_POST['year']));

    $bulan  = substr($month, 5, 2);
    $tahun  = substr($_POST['month'], -4);

    $yearly = substr($_POST['year'], -4);

    $type   = $_POST['type'];

    if ($type == 'daily')
        $sql = mysqli_query($conn, "SELECT i.*, sum(it.Item_Pcs * it.Qty) as Marking_Done 
                                    FROM Invoice i JOIN Invoice_Item it ON i.Inv_Number = it.Inv_Number 
                                    WHERE it.Item_Note != '' AND i.Inv_Tgl_Masuk BETWEEN '$start' AND '$end' GROUP BY i.Inv_Number");
    elseif ($type == 'monthly')
        $sql = mysqli_query($conn, "SELECT i.*, sum(it.Item_Pcs * it.Qty) as Marking_Done 
                                    FROM Invoice i JOIN Invoice_Item it ON i.Inv_Number = it.Inv_Number 
                                    WHERE it.Item_Note != '' AND MONTH(i.Inv_Tgl_Masuk)='$bulan' AND YEAR(i.Inv_Tgl_Masuk)='$tahun' 
                                    GROUP BY Inv_Number");
    else  
        $sql = mysqli_query($conn, "SELECT i.*, sum(it.Item_Pcs * it.Qty) as Marking_Done 
                                    FROM Invoice i JOIN Invoice_Item it ON i.Inv_Number = it.Inv_Number 
                                    WHERE it.Item_Note != '' AND YEAR(i.Inv_Tgl_Masuk)='$yearly' 
                                    GROUP BY Inv_Number");

    $data = array();
    $json = array();
    $i = 1;
    while( $row=mysqli_fetch_array($sql) ) {

        $nestedData=array(); 
        $nestedData['Inv_Number']       = $row["Inv_Number"];
        $nestedData['Total_PCS']        = $row["Total_PCS"].' pcs';
        $nestedData['Marking_Done']     = $row["Marking_Done"].' pcs';
        $nestedData['Cust_Nama']        = $row["Cust_Nama"];
        $nestedData['Cust_Alamat']      = $row["Cust_Alamat"];
        $nestedData['Staff_Name']       = $row["Staff_Name"];
        
        $data[] = $nestedData;
    }
    $json['data'] = $data;
    echo json_encode($json);
    exit();
} elseif ($_GET['type'] == 'download-marking') {
    $start  = date('Y-m-d', strtotime($_POST['start']));
    $end    = date('Y-m-d', strtotime($_POST['end']));

    $month  = date('Y-m-d', strtotime($_POST['month']));
    $year   = date('Y-m-d', strtotime($_POST['year']));

    $bulan  = substr($month, 5, 2);
    $tahun  = substr($month, 0, 4);

    $yearly = substr($year, 0, 4);

    $type   = $_POST['type'];

    if ($type == 'daily') {
        $judul = 'Daily Marking';
        $header = 'Report Marking ' . date('D, d M Y', strtotime($start)) . ' s/d '.date('D, d M Y', strtotime($end));
        $sql = mysqli_query($conn, "SELECT i.*, sum(it.Item_Pcs * it.Qty) as Marking_Done 
                                    FROM Invoice i JOIN Invoice_Item it ON i.Inv_Number = it.Inv_Number 
                                    WHERE it.Item_Note != '' AND i.Inv_Tgl_Masuk BETWEEN '$start' AND '$end' GROUP BY i.Inv_Number");
    } elseif ($type == 'monthly') {
        $judul = 'Monthly Marking';
        $header = 'Report Marking ' . date('M Y', strtotime($month));
        $sql = mysqli_query($conn, "SELECT i.*, sum(it.Item_Pcs * it.Qty) as Marking_Done 
                                    FROM Invoice i JOIN Invoice_Item it ON i.Inv_Number = it.Inv_Number 
                                    WHERE it.Item_Note != '' AND MONTH(i.Inv_Tgl_Masuk)='$bulan' AND YEAR(i.Inv_Tgl_Masuk)='$tahun' 
                                    GROUP BY Inv_Number");
    } else {  
        $judul = 'Yearly Marking';
        $header = 'Report Marking ' . date('Y', strtotime($year));
        $sql = mysqli_query($conn, "SELECT i.*, sum(it.Item_Pcs * it.Qty) as Marking_Done 
                                    FROM Invoice i JOIN Invoice_Item it ON i.Inv_Number = it.Inv_Number 
                                    WHERE it.Item_Note != '' AND YEAR(i.Inv_Tgl_Masuk)='$yearly' 
                                    GROUP BY Inv_Number");
    }

    $sheet->setCellValue('A3', $header);
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'Invoice');
    $sheet->setCellValue('C4', 'Nama');
    $sheet->setCellValue('D4', 'Alamat');
    $sheet->setCellValue('E4', 'Marking Done');
    $sheet->setCellValue('F4', 'Total PCS');
    $sheet->setCellValue('G4', 'Staff');
    
    $sheet->getStyle('A4:G4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:G4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:G4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;
    
    $bulan = substr($month, 5, 2);
    $tahun = substr($month, 0, 4);
    
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('D' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('E' . $baris, $data['Marking_Done']);
        $sheet->setCellValue('F' . $baris, $data['Total_PCS']);
        $sheet->setCellValue('G' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('E5:F' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:G' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('E5:F' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);

} elseif ($_GET['type'] == 'get-total') {
    $start  = date('Y-m-d', strtotime($_POST['start']));
    $end    = date('Y-m-d', strtotime($_POST['end']));

    $month  = date('Y-m-d', strtotime($_POST['month']));
    $year   = date('Y-m-d', strtotime($_POST['year']));

    $bulan  = substr($month, 5, 2);
    $tahun  = substr($_POST['month'], -4);

    $yearly = substr($_POST['year'], -4);

    $type   = $_POST['type'];
    $cabang = $_SESSION['cabang'];

    if ($type == 'daily') 
        $query = mysqli_query($conn, "SELECT sum(Payment_Amount) as Total_Amount, sum(Total_PCS) as Total_PCS, Inv_Tgl_Masuk FROM Invoice WHERE Inv_Number LIKE '%$cabang%' AND Inv_Tgl_Masuk BETWEEN '$start' AND '$end'");
    elseif ($type == 'monthly')
        $query = mysqli_query($conn, "SELECT sum(Payment_Amount) as Total_Amount, sum(Total_PCS) as Total_PCS, Inv_Tgl_Masuk FROM Invoice WHERE Inv_Number LIKE '%$cabang%' AND MONTH(Inv_Tgl_Masuk)='$bulan' AND YEAR(Inv_Tgl_Masuk)='$tahun'");
    else 
        $query = mysqli_query($conn, "SELECT sum(Payment_Amount) as Total_Amount, sum(Total_PCS) as Total_PCS, Inv_Tgl_Masuk FROM Invoice WHERE Inv_Number LIKE '%$cabang%' AND YEAR(Inv_Tgl_Masuk)='$yearly'");
    
    $total = mysqli_fetch_assoc($query);

    $data = [
        'Total_Amount'  => 'Total Amount : '. number_format($total['Total_Amount'],0,',','.'),
        'Total_PCS'     => 'Total PCS : ' . number_format($total['Total_PCS'],0,',','.').' PCS',
    ];

    echo json_encode($data);
    exit();
}


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Laporan '.$judul.'.xlsx"');
        
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
