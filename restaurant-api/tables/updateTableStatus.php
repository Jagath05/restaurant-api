<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit();
}

include_once(__DIR__ . "/../config/db.php");

$data =
json_decode(
    file_get_contents(
        "php://input"
    ),
    true
);

$id =
$data['id'];

$status =
$data['status'];

$query =
"
UPDATE restaurant_tables
SET status='$status'
WHERE id='$id'
";

$result =
mysqli_query(
    $conn,
    $query
);

echo json_encode([
    "success"=>$result
]);

?>