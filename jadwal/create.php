<?php
include_once '../config/database.php';
include_once '../objects/jadwal.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Jadwal($db);
 
$product->jadwal = $_POST["jadwal"];
$product->waktu = $_POST["waktu"];
$time = strtotime($_POST["tanggal"]);
$newformat = date('Y-m-d',$time);
$product->tanggal = $newformat;
$product->tempat = $_POST["tempat"];
$product->prioritas = $_POST["prioritas"];
$product->user_id = $_POST["id"];

// create the product
if($product->create()){
    $response["value"] = 200;
    $response["message"] = $_POST["tanggal"];
    echo json_encode($response);
}
 
// if unable to create the product, tell the user
else{
    $response["value"] = 0;
    $response["message"] = "Coba Lagi";
    echo json_encode($response);
}
?>