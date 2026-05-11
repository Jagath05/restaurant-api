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

if(!isset($_GET['category'])){

    echo json_encode([]);
    exit();
}

$category =
mysqli_real_escape_string(
    $conn,
    $_GET['category']
);

$query =
"
SELECT *
FROM foods
WHERE category='$category'
";

$result =
mysqli_query(
    $conn,
    $query
);

$foods = [];

while(
$row =
mysqli_fetch_assoc(
    $result
)){

    $foods[] =
    $row;
}

echo json_encode(
    $foods
);

?>