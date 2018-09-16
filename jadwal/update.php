<?php

include_once '../config/database.php';
include_once '../objects/jadwal.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Jadwal($db);
 
$product->id = $_POST["id"];
 
// set product property values
 
$product->jadwal = $_POST["jadwal"];
$product->waktu = $_POST["waktu"];
$time = strtotime($_POST["tanggal"]);
$newformat = date('Y-m-d',$time);
$product->tanggal = $newformat;
$product->tempat = $_POST["tempat"];
$product->prioritas = $_POST["prioritas"];

// update the product
if($product->update()){
    $response["value"] = 200;
    $response["message"] = "Jadwal berhasil Ubah";
    echo json_encode($response);
}
 
// if unable to update the product, tell the user
else{
    $response["value"] = o;
    $response["message"] = "Coba Lagi";
    echo json_encode($response);
}
?>