<?php
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new User($db);
 
$product->id = $_POST["id"];
 
// delete the product
if($product->delete()){
    $response["value"] = 200;
    $response["message"] = "Delete berhasil";
    echo json_encode($response);
}
 
// if unable to delete the product
else{
    $response["value"] = 0;
    $response["message"] = "Delete gagal";
    echo json_encode($response);
}
?>