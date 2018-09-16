<?php

include_once '../config/database.php';
include_once '../objects/catatan.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Catatan($db);
 
// set product id to be deleted
$product->id = $_POST["id"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Berhasil di hapus";
    echo json_encode($response);
}
 
// if unable to delete the product
else{
    $response["value"] = 0;
    $response["message"] = "Coba Lagi";
    echo json_encode($response);
}
?>