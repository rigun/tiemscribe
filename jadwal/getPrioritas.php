<?php
include_once '../config/database.php';
include_once '../objects/jadwal.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new Jadwal($db);
 
// set ID property of user to be edited
$product->id= $_POST['id'];
// read the details of user to be edited
$stmt = $product->readPrioritas();
$num = $stmt->rowCount();

// check if more than 0 record found
    // products array
    $products_arr=array();
    $products_arr["result"]=array();

if($num>0){
 


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $product_item=array(
            "id" => $id,
            "jadwal" => $jadwal,
            "waktu" => $waktu,
            "tanggal" => $tanggal,
            "tempat" => $tempat,
            "prioritas" => $prioritas
         );
         
        array_push($products_arr["result"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    $product_item=array(
        "id" => "-1",
        "jadwal" => "No data",
        "waktu" => "No data",
        "tanggal" => "No data",
        "tempat" => "No data",
        "prioritas" => "No data"
     );
     array_push($products_arr["result"], $product_item);
     print_r(json_encode($products_arr));
}
?>