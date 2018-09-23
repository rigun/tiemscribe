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
            "prioritas" => $prioritas,
            "user_id" => $user_id
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