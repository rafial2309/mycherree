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
}


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Laporan '.$judul.'.xlsx"');
        
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
