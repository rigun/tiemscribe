<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new User($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of product to be edited
$product->token = $data->token;
$product->password = password_hash($data->password, PASSWORD_DEFAULT); 

if($product->updatePasswordByToken($data->newToken)){
    echo '{';
        echo '"message": "password berhasil di perbaharui","code":"200"';
    echo '}';
}
    
// if unable to update the product, tell the user
else{
    echo '{';
        echo '"message": "Gagal memperbaharui data. Coba lagi. with password"';
    echo '}';
}

?>