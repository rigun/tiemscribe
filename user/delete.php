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
    echo '{';
        echo '"message": "User berhasil di hapus"';
    echo '}';
}
 
// if unable to delete the product
else{
    echo '{';
        echo '"message": "Gagal Menghapus User"';
    echo '}';
}
?>