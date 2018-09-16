<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/jadwal.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$product = new Jadwal($db);
 
// query products
$stmt = $product->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["result"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $product_item=array(
            "id" => $id,
            "jadwal" => $jadwal,
            "waktu" => $waktu,
            "tanggal" => $tanggal,
            "tempat" => $tempat,
            "prioritas" => $prioritas,
         );
         
        array_push($products_arr["result"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    $response["value"] = 0;
    $response["message"] = "Jadwal Tidak ditemukan";
    echo json_encode($response);
}
?>