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
$stmtCatatan = $catatan->readOne();
$numCatatan = $stmtCatatan->rowCount();

// create array
if($numCatatan>0){
 
    // products array
    $catatan_arr=array();
    $catatan_arr["catatan"]=array();

    while ($rowCatatan = $stmtCatatan->fetch(PDO::FETCH_ASSOC)){

        extract($rowCatatan);
        $product_item=array(
            "catatan" => $catatan,
            "prioritas" => $prioritas,
            "id" => $id
         );
         
        array_push($catatan_arr["catatan"], $product_item);
    }
}
else{
    $catatan_arr["catatan"]=null;
}

 
// make it json format
print_r(json_encode($user_arr));
?>