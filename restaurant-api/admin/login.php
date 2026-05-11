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

// DB Connection
include_once(__DIR__ . "/../config/db.php");

// Read JSON body
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);
    exit();
}

$username = mysqli_real_escape_string(
    $conn,
    $data["username"]
);

$password = mysqli_real_escape_string(
    $conn,
    $data["password"]
);

// Admin Query
$query = "
SELECT *
FROM admins
WHERE username='$username'
AND password='$password'
LIMIT 1
";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {

    $admin = mysqli_fetch_assoc($result);

    echo json_encode([
        "success" => true,
        "admin" => $admin
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Invalid Username or Password"
    ]);
}
?>