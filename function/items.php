<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include "../config/configuration.php";

function imagecreatefromfile( $filename ) {
    if (!file_exists($filename)) {
        throw new InvalidArgumentException('File "'.$filename.'" not found.');
    }
    switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
        case 'jpeg':
        case 'jpg':
            return imagecreatefromjpeg($filename);
        break;

        case 'png':
            return imagecreatefrompng($filename);
        break;

        case 'gif':
            return imagecreatefromgif($filename);
        break;

        default:
            throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
        break;
    }
}

if ($_GET['menu'] == 'create' ) {
	// ADD NEW ITEM
	$Item_Name 		 	= $_POST['Item_Name'];
	$Item_Category 		= $_POST['Item_Category'];
	$Item_Price         = $_POST['Item_Price'];
	$Item_Pcs           = $_POST['Item_Pcs'];
	
	mysqli_query($conn, "INSERT INTO Master_Item (Item_Name, Item_Category, Item_Price, Item_Pcs, Item_Pic, Item_Status) VALUES ('$Item_Name','$Item_Category','$Item_Price','$Item_Pcs','','Y')");

} elseif ($_GET['menu'] == 'edit') {
    // UPDATE EXISTING ITEM
	$Item_ID 		 	= $_POST['Item_ID'];
	$Item_Name 		 	= $_POST['Item_Name'];
	$Item_Category 		= $_POST['Item_Category'];
	$Item_Price         = $_POST['Item_Price'];
	$Item_Pcs           = $_POST['Item_Pcs'];
	
    mysqli_query($conn, "UPDATE Master_Item SET Item_Name='$Item_Name', Item_Category='$Item_Category', Item_Price='$Item_Price', Item_Pcs='$Item_Pcs' WHERE Item_ID='$Item_ID'");
} else if ($_GET['menu'] == 'data') {
    $requestData= $_REQUEST;
    $columns = array( 
        0 =>'Item_ID',
        1 =>'Item_Name',
        2 =>'Item_Category',
        3 =>'Item_Price',
        4 =>'Item_Pcs',
        5 =>'Item_Status',
    );
    //----------------------------------------------------------------------------------
    //join 2 tabel dan bisa lebih, tergantung kebutuhan
    $sql = "SELECT * from Master_Item WHERE Item_Status='Y'";
    $query=mysqli_query($conn, $sql) or die("items?menu=data: get dataku");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;

    //----------------------------------------------------------------------------------
    $sql = " SELECT * from Master_Item";
    $sql.= " WHERE Item_Status='Y'";
    if( !empty($requestData['search']['value']) ) {
        //----------------------------------------------------------------------------------
        $sql.=" AND Item_Name NOT LIKE '[DELETE]%' AND ( Item_Name LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR Item_Category LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR Item_Price LIKE '".$requestData['search']['value']."%' )";
    }
    //----------------------------------------------------------------------------------
    $query=mysqli_query($conn, $sql) or die("items?menu=data: get dataku");
    $totalFiltered = mysqli_num_rows($query);
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
    $query=mysqli_query($conn, $sql) or die("items?menu=data: get dataku");
    //----------------------------------------------------------------------------------
    $data = array();
    $i = 1;
    while( $row=mysqli_fetch_array($query) ) {

        $nestedData=array(); 
        $nestedData[] = $row["Item_Name"];
        $nestedData[] = $row["Item_Category"];
        $nestedData[] = number_format($row["Item_Price"],0,',','.');
        $nestedData[] = $row["Item_Pcs"];
        $nestedData[] = "<img class='rounded-md' style='height: 40px;' src='src/images/item/".$row['Item_ID'].".webp'> <form method='post' id='".$row['Item_ID']."' action='function/items?menu=uploadimage' enctype='multipart/form-data'><input type='hidden' name='idnya' value='".$row['Item_ID']."'><input type='file' name='imageitem' id='' onchange='uploadpic(".$row['Item_ID'].")'></form>";
        $nestedData[] = "<button class='btn btn-sm btn-pending w-16 mr-1 mb-2' data-tw-toggle='modal' data-tw-target='#edit-item-modal' onclick='btnEdit(".$row['Item_ID'].")'>EDIT</button><button class='btn btn-sm btn-danger w-16 mr-1 mb-2' onclick='btnDelete(".$row['Item_ID'].")'>DELETE</button>";

        
        $data[] = $nestedData;
    }
    //----------------------------------------------------------------------------------
    $json_data = array(
                "draw"            => intval( $requestData['draw'] ),  
                "recordsTotal"    => intval( $totalData ), 
                "recordsFiltered" => intval( $totalFiltered ), 
                "data"            => $data );
    //----------------------------------------------------------------------------------
    echo json_encode($json_data);
    exit();
} elseif ($_GET['menu'] == 'ajax') { 
    // KEYWORD DIKIRIM DENGAN METHOD POST
    $Item_ID 	= $_POST['Item_ID'];

    $sql 	= mysqli_query($conn, "SELECT * FROM Master_Item WHERE Item_ID='$Item_ID'");
    $data 	= mysqli_fetch_assoc($sql);

//     Deskripsi
// Qty
// Size
// Item_Note
// Adjustment
// Adjustment_Note

    $json = [ 
        'Item_ID'	        => $Item_ID, 
        'Item_Name' 		=> $data['Item_Name'],
	    'Item_Category'     => $data['Item_Category'],
	    'Item_Price'        => $data['Item_Price'],
	    'Item_Pcs'          => $data['Item_Pcs'],
	];
    // MERUBAH VARIABEL ARRAY KE FORMAT JSON
    echo json_encode($json);
    exit();
} elseif ($_GET['menu'] == 'cariitem') { 
    // KEYWORD DIKIRIM DENGAN METHOD POST
    $keyword    = $_POST['keyword'];

    $query = mysqli_query($conn,"SELECT * from Master_Item WHERE Item_Name LIKE '%$keyword%' order by Item_Name ASC LIMIT 8");
    while ($dataitem = mysqli_fetch_array($query)) { ?>

    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3" onclick="tambahitem('<?php echo $dataitem['Item_ID'] ?>','<?php echo $dataitem['Item_Name'] ?>','<?php echo $dataitem['Item_Price'] ?>','<?php echo $dataitem['Item_Pcs'] ?>')">
        <div class="box rounded-md p-3 relative zoom-in">
            <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                <div class="absolute top-0 left-0 w-full h-full image-fit">
                    <img alt="My Cherree Laundry" class="rounded-md" src="src/images/item/<?php echo $dataitem['Item_ID'] ?>.webp" onerror="this.onerror=null; this.src='src/images/item/noimage.svg'">
                </div>
            </div>
            <div class="block font-medium text-center truncate mt-3"><?php echo $dataitem['Item_Name'] ?></div>
            <center><button class="btn btn-sm btn-outline-primary inline-block mt-1"><?php echo $dataitem['Item_Category'] ?></button></center>
        </div>
    </a>

    <?php
    }
    exit();
} elseif ($_GET['menu'] == 'uploadimage'){


    $image = $_FILES['imageitem']['name'];
    $file_tmp =$_FILES['imageitem']['tmp_name'];

    $dir="../src/images/item/";

    $id = $_POST['idnya'];
    $newName=$id.".webp";

    if(move_uploaded_file($file_tmp,$dir.$image)){

        $img = imagecreatefromfile($dir . $image);
        $quality = 100;
        imagewebp($img, $dir . $newName, $quality);
        imagedestroy($img);
        unlink($dir.$image);

    }
   
    echo "<script>location.href='../app?p=master_item';</script>";

    exit();
} else {
	// SOFT DELETE ITEM
	$Item_ID = $_GET['id'];

	mysqli_query($conn, "UPDATE Master_Item SET Item_Status='N' WHERE Item_ID='$Item_ID'");
}
// REDIRECT KEMBALI KE HALAMAN ITEM
echo "<script>location.href='../app?p=master_item';</script>";
?>