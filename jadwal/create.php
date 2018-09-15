<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/jadwal.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Jadwal($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
 
$product->jadwal = $data->jadwal;
$product->waktu = $data->waktu;
$product->tanggal = $data->tanggal;
$product->tempat = $data->tempat;
$product->prioritas = $data->prioritas;
$product->user_id = $data->user_id;

// create the product
if($product->create()){
    echo '{';
        echo '"message": "Product was created."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create jadwal."';
    echo '}';
}
?>