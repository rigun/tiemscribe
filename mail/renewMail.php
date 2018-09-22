<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new User($db);
 
$product->token = isset($_GET['token']) ? $_GET['token'] : die();
 

if($product->resetEmailByToken()){
    $response["value"] = 200;
    $response["message"] = "Password berhasil direset dengan password 12345678";
    echo json_encode($response);
}
else{
    $response["value"] = 0;
    $response["message"] = "Password gagal direset";
    echo json_encode($response);
}
?>