<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

// Handle OPTIONS request
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){

    http_response_code(200);
    exit();
}

include_once(__DIR__ . "/../config/db.php");

// Get JSON data
$data =
json_decode(
    file_get_contents(
        "php://input"
    ),
    true
);

// Validate data
if(!$data){

    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);

    exit();
}

// Form data
$name =
mysqli_real_escape_string(
    $conn,
    $data['name']
);

$phone =
mysqli_real_escape_string(
    $conn,
    $data['phone']
);

$people =
(int)$data['people'];

$date =
mysqli_real_escape_string(
    $conn,
    $data['date']
);

$time =
mysqli_real_escape_string(
    $conn,
    $data['time']
);

$duration =
(int)$data['duration'];

// Save reservation request
$query =
"
INSERT INTO reservations
(
customer_name,
phone,
people_count,
table_number,
reservation_date,
reservation_time,
duration_hours,
status
)
VALUES
(
'$name',
'$phone',
'$people',
NULL,
'$date',
'$time',
'$duration',
'Pending'
)
";

$result =
mysqli_query(
    $conn,
    $query
);

if($result){

    $reservationId =
    mysqli_insert_id(
        $conn
    );

    echo json_encode([

        "success" => true,

        "message" =>
        "Reservation request sent",

        "reservation_id" =>
        $reservationId,

        "status" =>
        "Pending"

    ]);

}else{

    echo json_encode([

        "success" => false,

        "message" =>
        mysqli_error(
            $conn
        )
    ]);
}
?>