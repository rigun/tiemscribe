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
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of product to be edited
$product->id = $data->id;
 
// set product property values
 
$product->email = $data->email; 
$product->nama = $data->nama; 
$product->password = password_hash($data->password, PASSWORD_DEFAULT); 
$product->passwordL = $data->passwordL; 
$product->foto = $data->foto; 
$product->ttl = $data->ttl; 
$product->kutipan = $data->kutipan; 

if($product->passwordL == null){
    if($product->update()){
        echo '{';
            echo '"message": "Data berhasil di perbaharui."';
        echo '}';
    }
     
    // if unable to update the product, tell the user
    else{
        echo '{';
            echo '"message": "Gagal memperbaharui data. Coba lagi"';
        echo '}';
    }
}else{
    if($product->updateWithPassword()){
        echo '{';
            echo '"message": "Data berhasil di perbaharui."';
        echo '}';
    }
     
    // if unable to update the product, tell the user
    else{
        echo '{';
            echo '"message": "Gagal memperbaharui data. Coba lagi. with password"';
        echo '}';
    }
}
// update the product

?>