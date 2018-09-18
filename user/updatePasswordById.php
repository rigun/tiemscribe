<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new User($db);
 
$product->id = $_POST['id'];
$product->password = $_POST['password'];

if($product->updatePasswordById()){
    $response["value"] = 0;
    $response["message"] = "Password Berhasil di Perbaharui";
    echo json_encode($response);
}
    
// if unable to update the product, tell the user
else{
    $response["value"] = 0;
    $response["message"] = "Password Gagal di Perbaharui";
    echo json_encode($response);
}

?>