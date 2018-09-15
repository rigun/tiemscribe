<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$product = new User($db);
 
// get keywords
$data = json_decode(file_get_contents("php://input"));

$keywords= $data->email;
 
// query products
$stmt = $product->search($keywords);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    echo '{';
        echo '"message": "Email Sudah ada", "code": "403"';
    echo '}';
}
 
else{
    echo '{';
        echo '"message": "Email Tersedia", "code": "200"';
    echo '}';
}
?>