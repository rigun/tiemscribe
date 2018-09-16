<?php

// include database and object files
include_once '../config/database.php';
include_once '../objects/catatan.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Catatan($db);

// set ID property of product to be edited
$product->id = $_POST["id"];
$product->catatan = $_POST["catatan"];
$product->prioritas = $_POST["prioritas"];

// update the product
if($product->update()){
    $response["value"] = 200;
    $response["message"] = "Catatan berhasil Ubah";
    echo json_encode($response);
}
 
// if unable to update the product, tell the user
else{
    $response["value"] = o;
    $response["message"] = "Coba Lagi";
    echo json_encode($response);
}
?>