<?php
require '../config/configuration.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\{Alignment, Border, Color, Fill};

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->mergeCells('A1:G1');
$sheet->mergeCells('A2:G2');
$sheet->setCellValue('A1', 'My Cherree Laundry');
$sheet->setCellValue('A2', 'Bukit Golf Mediterania RT.7/RW.2, Kamal Muara, Kec. Penjaringan, Kota Jkt Utara, DKI Jakarta 14470');

if ($_GET['type'] == 'customer') {
    $judul = 'Customer';

    $sheet->setCellValue('A3', 'N');
    $sheet->setCellValue('B3', 'Nama');
    $sheet->setCellValue('C3', 'Telepon');
    $sheet->setCellValue('D3', 'Alamat');
    $sheet->setCellValue('E3', 'Status Membership');
    $sheet->setCellValue('F3', 'Tanggal Join');
    
    $sheet->getStyle('A3:F3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:F3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:F3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;
    
    $sql = mysqli_query($conn, "SELECT *FROM Customer WHERE Cust_Status ='Y'");
    
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('C' . $baris, $data['Cust_Telp']);
        $sheet->setCellValue('D' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('E' . $baris, $data['Cust_Member_Name']);
        $sheet->setCellValue('F' . $baris, $data['Cust_Tgl_Join']);
        $baris++;
        $no++;
    }
    
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    
    $akhir = $baris - 1; 
    $sheet->getStyle('A4:F' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

} elseif ($_GET['type'] == 'membership') {
    $judul = 'Membership';

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Tanggal');
    $sheet->setCellValue('C3', 'Nama');
    $sheet->setCellValue('D3', 'Status');
    $sheet->setCellValue('E3', 'Jumlah');
    $sheet->setCellValue('F3', 'Join - Expired');
    
    $sheet->getStyle('A3:F3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:F3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:F3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;
    
    $sql = mysqli_query($conn, "SELECT *FROM Registrasi_Member");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, date('d/m/Y', strtotime($data['Registrasi_Tgl'])));
        $sheet->setCellValue('C' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('D' . $baris, 'LUNAS');
        $sheet->setCellValue('E' . $baris, $data['Registrasi_Payment']);
        $sheet->setCellValue('F' . $baris, date('d/m/Y', strtotime($data['Cust_Member_Join'])).' - '.date('d/m/Y', strtotime($data['Cust_Member_Join'])));
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('A4:F' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('E4:E' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');

}  elseif ($_GET['type'] == 'item') {
    $judul = 'Master Item';

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
    
    $sql = mysqli_query($conn, "SELECT *FROM Master_Item WHERE Item_Status='Y'");
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
    $judul = 'Master Colour';

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Colour Name');
    
    $sheet->getStyle('A3:B3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:B3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:B3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;
    
    $sql = mysqli_query($conn, "SELECT *FROM Master_Colour WHERE Colour_Status='Y'");
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
    $judul = 'Master Brand';

    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Brand Name');
    
    $sheet->getStyle('A3:B3')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A3:B3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A3:B3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A4');
    
    $baris  = 4;
    $no     = 1;
    
    $sql = mysqli_query($conn, "SELECT *FROM Master_Brand WHERE Brand_Status='Y'");
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
    $judul = 'Promo & Discount';

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
    
    $sql = mysqli_query($conn, "SELECT *FROM Discount WHERE Discount_Status='Y'");
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
    $judul = 'Staff & Karyawan';

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
    
    $sql = mysqli_query($conn, "SELECT *FROM Staff WHERE Staff_Status='Y'");
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

    $sheet->setCellValue('A3', 'Report ' . date('D, d M Y', strtotime($start)).' - '.date('D, d M Y', strtotime($end)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Masuk');
    $sheet->setCellValue('D4', 'Tanggal Selesai');
    $sheet->setCellValue('E4', 'Nama Customer');
    $sheet->setCellValue('F4', 'Alamat');
    $sheet->setCellValue('G4', 'Total PCS');
    $sheet->setCellValue('H4', 'Total Pembayaran');
    $sheet->setCellValue('I4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:I4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:I4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:I4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice WHERE Inv_Tgl_Masuk BETWEEN '$start' AND '$end'");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])));
        $sheet->setCellValue('D' . $baris, date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])));
        $sheet->setCellValue('E' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('F' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('G' . $baris, $data['Total_PCS']);
        $sheet->setCellValue('H' . $baris, $data['Payment_Amount']);
        $sheet->setCellValue('I' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:I' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G5:H' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);

} elseif ($_GET['type'] == 'monthly-invoice') {
    $month  = date('Y-m-d', strtotime($_POST['month']));
    $judul  = 'Monthly Invoice';
    
    $sheet->setCellValue('A3', 'Report ' . date('M Y', strtotime($month)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Masuk');
    $sheet->setCellValue('D4', 'Tanggal Selesai');
    $sheet->setCellValue('E4', 'Nama Customer');
    $sheet->setCellValue('F4', 'Alamat');
    $sheet->setCellValue('G4', 'Total PCS');
    $sheet->setCellValue('H4', 'Total Pembayaran');
    $sheet->setCellValue('I4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:I4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:I4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:I4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;

    $bulan = substr($month, 5, 2);
    $tahun = substr($month, 0, 4);
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice WHERE MONTH(Inv_Tgl_Masuk)='$bulan' AND YEAR(Inv_Tgl_Masuk)='$tahun'");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])));
        $sheet->setCellValue('D' . $baris, date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])));
        $sheet->setCellValue('E' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('F' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('G' . $baris, $data['Total_PCS']);
        $sheet->setCellValue('H' . $baris, $data['Payment_Amount']);
        $sheet->setCellValue('I' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:I' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G5:H' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);

} elseif ($_GET['type'] == 'yearly-invoice') {
    $year   = date('Y-m-d', strtotime($_POST['year']));
    $judul  = 'Yearly Invoice';

    $sheet->setCellValue('A3', 'Report' . date('Y', strtotime($year)));
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'ID Invoice');
    $sheet->setCellValue('C4', 'Tanggal Masuk');
    $sheet->setCellValue('D4', 'Tanggal Selesai');
    $sheet->setCellValue('E4', 'Nama Customer');
    $sheet->setCellValue('F4', 'Alamat');
    $sheet->setCellValue('G4', 'Total PCS');
    $sheet->setCellValue('H4', 'Total Pembayaran');
    $sheet->setCellValue('I4', 'Dikerjakan oleh');
    
    $sheet->getStyle('A4:I4')->getAlignment()->setVertical('center')->setHorizontal('center');
    $sheet->getStyle('A4:I4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('A4:I4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('E2E8F0');
    
    $sheet->freezePane('A5');
    
    $baris = 5;
    $no = 1;

    $tahun = substr($year, 0, 4);
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice WHERE YEAR(Inv_Tgl_Masuk)='$tahun'");
    while ($data = mysqli_fetch_assoc($sql)) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $data['Inv_Number']);
        $sheet->setCellValue('C' . $baris, date('D, d M Y', strtotime($data['Inv_Tgl_Masuk'])));
        $sheet->setCellValue('D' . $baris, date('D, d M Y', strtotime($data['Inv_Tg_Selesai'])));
        $sheet->setCellValue('E' . $baris, $data['Cust_Nama']);
        $sheet->setCellValue('F' . $baris, $data['Cust_Alamat']);
        $sheet->setCellValue('G' . $baris, $data['Total_PCS']);
        $sheet->setCellValue('H' . $baris, $data['Payment_Amount']);
        $sheet->setCellValue('I' . $baris, $data['Staff_Name']);
        $baris++;
        $no++;
    }
    foreach ($sheet->getColumnIterator() as $column) {
        $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
    $akhir = $baris - 1; 
    $sheet->getStyle('B5:B' . $akhir)->getAlignment()->setHorizontal('right');
    $sheet->getStyle('A5:I' . $akhir)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle('G5:H' . $akhir)->getNumberFormat()->setFormatCode('_(* #,##0_);_([Red]* \(#,##0\);_(* "-"??_);_(@_)');
    $sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(8);

}  elseif ($_GET['type'] == 'daily-payment') {
    $start  = date('Y-m-d', strtotime($_POST['start']));
    $end    = date('Y-m-d', strtotime($_POST['end']));
    $judul  = 'Daily Payment';

    $sheet->setCellValue('A3', 'Report ' . date('D, d M Y', strtotime($start)).' - '.date('D, d M Y', strtotime($end)));
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
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice_Payment WHERE Payment_Tgl BETWEEN '$start' AND '$end'");
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

    $sheet->setCellValue('A3', 'Report ' . date('M Y', strtotime($month)));
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
    $tahun = substr($month, 0, 4);
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice_Payment WHERE MONTH(Payment_Tgl)='$bulan' AND YEAR(Payment_Tgl)='$tahun'");
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
    $judul  = 'Yearly Invoice';

    $sheet->setCellValue('A3', 'Report ' . date('Y', strtotime($year)));
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
    
    $tahun = substr($year, 0, 4);
    
    $sql = mysqli_query($conn, "SELECT *FROM Invoice_Payment WHERE YEAR(Payment_Tgl)='$tahun'");
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
    $tahun  = substr($month, 0, 4);

    $yearly = substr($year, 0, 4);

    $type   = $_POST['type'];

    if ($type == 'daily')
        $sql = mysqli_query($conn, "SELECT * from Invoice WHERE Inv_Tgl_Masuk BETWEEN '$start' AND '$end'");
    elseif ($type == 'monthly')
        $sql = mysqli_query($conn, "SELECT * from Invoice WHERE MONTH(Inv_Tgl_Masuk)='$bulan' AND YEAR(Inv_Tgl_Masuk)='$tahun'");
    else  
        $sql = mysqli_query($conn, "SELECT * from Invoice WHERE YEAR(Inv_Tgl_Masuk)='$yearly'");

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
    $tahun  = substr($month, 0, 4);

    $yearly = substr($year, 0, 4);

    $type   = $_POST['type'];

    if ($type == 'daily')
        $sql = mysqli_query($conn, "SELECT * from Invoice_Payment WHERE Payment_Tgl BETWEEN '$start' AND '$end'");
    elseif ($type == 'monthly')
        $sql = mysqli_query($conn, "SELECT * from Invoice_Payment WHERE MONTH(Payment_Tgl)='$bulan' AND YEAR(Payment_Tgl)='$tahun'");
    else  
        $sql = mysqli_query($conn, "SELECT * from Invoice_Payment WHERE YEAR(Payment_Tgl)='$yearly'");

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
}


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Laporan '.$judul.'.xlsx"');
        
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');