<?php
include_once '../config/database.php';
include_once '../objects/jadwal.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$product = new Jadwal($db);
 
// set ID property of user to be edited
$product->id= $_POST['id'];
// read the details of user to be edited
$stmt = $product->readDate();
$num = $stmt->rowCount();
    // products array
    $products_arr=array();
    $products_arr["result"]=array();
// check if more than 0 record found
if($num>0){
 


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $product_item=array(
            "id" =>$id,
            "tanggal" => $tanggal
         );
         
        array_push($products_arr["result"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    $product_item=array(
        "id" => "-1",
        "tanggal" => "No data"
     );
     array_push($products_arr["result"], $product_item);
     print_r(json_encode($products_arr));
}
?>