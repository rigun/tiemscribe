<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);

$user->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of user to be edited
$user->dataById();

$user_arr = array(
    "id" => $user->id,
    "email" => $user->email,
    "nama" => $user->nama,
    "foto" => $user->foto,
    "ttl" => $user->ttl,
    "kutipan" => $user->kutipan,
 );
 
// make it json format
print_r(json_encode($user_arr));
?>