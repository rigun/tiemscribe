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
 

if($product->updateByToken()){
    echo '<h1>Verifikasi Berhasil</h1><br/>';
    echo '<hr><br/>';
    echo '<h2>Selamat, Email anda berhasil di verifikasi, sekarang anda sudah bisa untuk melakukan login dan menikmati fitur-fitur dari TiEm Schedule</h2>';

}
else{
    echo '{';
        echo '"message": "Gagal Update Status."';
    echo '}';
}
?>