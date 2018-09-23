<?php
include_once '../config/database.php';
include_once '../objects/catatan.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$catatan = new Catatan($db);
 
// set ID property of user to be edited
$catatan->id= $_POST['id'];
// read the details of user to be edited
$stmtCatatan = $catatan->readPrioritas();
$numCatatan = $stmtCatatan->rowCount();
$catatan_arr=array();
$catatan_arr["result"]=array();
// create array
if($numCatatan>0){


    while ($rowCatatan = $stmtCatatan->fetch(PDO::FETCH_ASSOC)){

        extract($rowCatatan);
        $product_item=array(
            "catatan" => $catatan,
            "prioritas" => $prioritas,
            "id" => $id
         );
         
        array_push($catatan_arr["result"], $product_item);
    }
    print_r(json_encode($catatan_arr));
}
else{
    $product_item=array(
        "id" => "-1",
        "catatan" => "no data",
        "prioritas" => "no data",
     );
     array_push($catatan_arr["result"], $product_item);
     print_r(json_encode($catatan_arr));
}
?>