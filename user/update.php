<?php
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new User($db);
 
$product->id = $_POST["id"];
 
// set product property values
 
$product->nama = $_POST["nama"]; 

if($product->update()){
    $response["value"] = 200;
    $response["message"] = "Nama Berhasil Diubah";
    echo json_encode($response);
}
    
// if unable to update the product, tell the user
else{
    $response["value"] = 0;
    $response["message"] = "Nama Gagal Diubah";
    echo json_encode($response);
}

// update the product

?>