<?php

// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/catatan.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Catatan($db); 
 
$product->catatan = $_POST["catatan"];
$product->prioritas = $_POST["prioritas"];
$product->user_id = $_POST["id"];

// create the product
if($product->create()){
    $response["value"] = 200;
    $response["message"] = "Catatan berhasil ditambahkan";
    echo json_encode($response);
}
else{
    $response["value"] = 0;
    $response["message"] = "Coba Lagi";
    echo json_encode($response);
}
?>