<?php

// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new User($db);
 
 
$product->email = $_POST["email"];
// query products
$stmt = $product->search($_POST["email"]);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    if($product->login2()){
        $response["value"] = 200;
        $response["message"] = "Email berhasil dikirim";
        echo json_encode($response);
    }
        
    // if unable to update the product, tell the user
    else{
       $response["value"] = 202;
       $response["message"] = "Terjadi kesalahan pada server";
       echo json_encode($response);
    }
}
 
else{
    $response["value"] = 404;
    $response["message"] = "Email Tidak di temukan";
    echo json_encode($response);

}



?>