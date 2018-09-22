<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, PATCH, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new User($db);

$product->token = $_GET['token'];

if($product->resetEmailByToken()){
    echo '{';
        echo '"message": "Status Berhasil di Update."';
    echo '}';
}
else{
    echo '{';
        echo '"message": "Gagal Update Status."';
    echo '}';
}
?>