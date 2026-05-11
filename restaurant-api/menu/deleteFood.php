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

$id = $_GET['id'];

$query =
"DELETE FROM foods
WHERE id='$id'";

$result =
mysqli_query(
    $conn,
    $query
);

if($result){

echo json_encode([
"success"=>true,
"message"=>"Food Deleted"
]);

}else{

echo json_encode([
"success"=>false,
"message"=>"Delete Failed"
]);

}

?>