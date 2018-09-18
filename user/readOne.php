<?php
include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../objects/catatan.php';
include_once '../objects/jadwal.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);
$catatan = new Catatan($db);
$jadwal = new Jadwal($db);
 
// set ID property of user to be edited
$user->id = isset($_GET['id']) ? $_GET['id'] : die();
$catatan->id = $user->id; 
$jadwal->id = $user->id;
// read the details of user to be edited
$user->readOne();
$stmtCatatan = $catatan->readOne();
$numCatatan = $stmtCatatan->rowCount();
$stmtJadwal = $jadwal->readOne();
$numJadwal = $stmtJadwal->rowCount();

// create array
if($numCatatan>0){
 
    // products array
    $catatan_arr=array();
    $catatan_arr["catatan"]=array();

    while ($rowCatatan = $stmtCatatan->fetch(PDO::FETCH_ASSOC)){

        extract($rowCatatan);
        $product_item=array(
            "catatan" => $catatan,
         );
         
        array_push($catatan_arr["catatan"], $product_item);
    }
}
else{
    $catatan_arr["catatan"]=null;
}
if($numJadwal>0){
 
    // products array
    $jadwal_arr=array();
    $jadwal_arr["jadwal"]=array();

    while ($rowJadwal = $stmtJadwal->fetch(PDO::FETCH_ASSOC)){

        extract($rowJadwal);
        $product_item=array(
            "jadwal" => $jadwal,
            "waktu" => $waktu,
            "tanggal" => $tanggal,
            "tempat" => $tempat,
         );
         
        array_push($jadwal_arr["jadwal"], $product_item);
    }
}
else{
    $jadwal_arr["jadwal"]=null;
}

$user_arr = array(
    "id" => $user->id,
    "email" => $user->email,
    "nama" => $user->nama,
    "foto" => $user->foto,
    "ttl" => $user->ttl,
    "kutipan" => $user->kutipan,
    "catatans" => $catatan_arr["catatan"],
    "jadwals" => $jadwal_arr["jadwal"]
 );
 
// make it json format
print_r(json_encode($user_arr));
?>