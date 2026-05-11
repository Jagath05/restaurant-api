<?php
$allowedOrigins = [
    "https://restaurant-management-system-eight-delta.vercel.app",
    "https://restaurant-management-system-git-main-jagath05s-projects.vercel.app",
    "http://localhost:5173"
];

if (
    isset($_SERVER['HTTP_ORIGIN']) &&
    in_array(
        $_SERVER['HTTP_ORIGIN'],
        $allowedOrigins
    )
) {
    header(
        "Access-Control-Allow-Origin: " .
        $_SERVER['HTTP_ORIGIN']
    );
}

header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once(__DIR__ . "/../config/db.php");

$id = $_POST['id'];
$food_name = $_POST['food_name'];
$category = $_POST['category'];
$section = $_POST['section'];
$food_type = $_POST['food_type'];
$price = $_POST['price'];

$imageQuery = "";

// If new image uploaded
if(isset($_FILES['image'])){

    $imageName =
        time() .
        "_" .
        $_FILES['image']['name'];

    $target =
        "../uploads/images/" .
        $imageName;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $target
    );

    $imageQuery =
    ", image='$imageName'";
}

$query = "
UPDATE foods
SET
food_name='$food_name',
category='$category',
section='$section',
food_type='$food_type',
price='$price'
$imageQuery
WHERE id='$id'
";

$result =
mysqli_query(
    $conn,
    $query
);

if($result){

echo json_encode([
"success"=>true,
"message"=>"Food Updated"
]);

}else{

echo json_encode([
"success"=>false,
"message"=>"Update Failed"
]);

}
?>