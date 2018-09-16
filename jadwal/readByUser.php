<?php
include_once '../config/database.php';
include_once '../objects/catatan.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new Jadwal($db);
 
// set ID property of user to be edited
$product->id= $_POST['id'];
// read the details of user to be edited
$stmt = $product->readOne();
$num = $stmt->rowCount();

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