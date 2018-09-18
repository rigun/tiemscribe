<?php
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new User($db);
 
 
$product->nama = $_POST["nama"];
$product->email = $_POST["email"];
$product->password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$product->foto = NULL;
$product->status = 0;
$product->token = bin2hex(random_bytes(5));
$product->dibuat_pada = date('Y-m-d H:i:s');

 
// query products
$stmt = $product->search($_POST["email"]);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
   $response["value"] = 0;
   $response["message"] = "Email sudah terdaftar";
   echo json_encode($response);
}
 
else{
    if($product->create()){
        $response["value"] = 200;
       $response["message"] = "Pendaftaran berhasil";
       echo json_encode($response);
    }
    // if unable to create the product, tell the user
    else{
        $response["value"] = 403;
       $response["message"] = "Pendaftaran gagal";
       echo json_encode($response);
    }
}

// create the product

?>