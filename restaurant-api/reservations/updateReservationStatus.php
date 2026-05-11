<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

// Handle OPTIONS
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

if(!$data){

    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);

    exit();
}

$id =
$data['id'];

$status =
$data['status'];

$tableNumber =
$data['table_number']
?? null;

// Get reservation details
$getReservation =
"
SELECT *
FROM reservations
WHERE id='$id'
";

$reservationResult =
mysqli_query(
    $conn,
    $getReservation
);

$reservation =
mysqli_fetch_assoc(
    $reservationResult
);

// Approve logic
if(
    $status ===
    "Approved"
){

    if(!$tableNumber){

        echo json_encode([

            "success" =>
            false,

            "message" =>
            "Please select table"
        ]);

        exit();
    }

    $date =
    $reservation[
        'reservation_date'
    ];

    $time =
    $reservation[
        'reservation_time'
    ];

    // Prevent double booking
    $checkQuery =
    "
    SELECT *
    FROM reservations
    WHERE
    table_number='$tableNumber'
    AND reservation_date='$date'
    AND reservation_time='$time'
    AND status='Approved'
    AND id!='$id'
    ";

    $checkResult =
    mysqli_query(
        $conn,
        $checkQuery
    );

    if(
        mysqli_num_rows(
            $checkResult
        ) > 0
    ){

        echo json_encode([

            "success" =>
            false,

            "message" =>
            "Table already booked"
        ]);

        exit();
    }

    // Reserve table
    mysqli_query(
        $conn,
"
UPDATE restaurant_tables
SET status='Reserved'
WHERE table_number='$tableNumber'
"
    );
}

// Completed logic
if(
    $status ===
    "Completed"
){

    $oldTable =
    $reservation[
        'table_number'
    ];

    if($oldTable){

        mysqli_query(
            $conn,
"
UPDATE restaurant_tables
SET status='Available'
WHERE table_number='$oldTable'
"
        );
    }
}

// Reject logic
if(
    $status ===
    "Rejected"
){

    $oldTable =
    $reservation[
        'table_number'
    ];

    if($oldTable){

        mysqli_query(
            $conn,
"
UPDATE restaurant_tables
SET status='Available'
WHERE table_number='$oldTable'
"
        );
    }
}

// Update reservation
$query =
"
UPDATE reservations
SET
status='$status',
table_number=" .
(
$tableNumber
? "'$tableNumber'"
: "table_number"
)
. "
WHERE id='$id'
";

$result =
mysqli_query(
    $conn,
    $query
);

if($result){

    echo json_encode([

        "success" =>
        true,

        "message" =>
        "Reservation updated"

    ]);

}else{

    echo json_encode([

        "success" =>
        false,

        "message" =>
        mysqli_error(
            $conn
        )

    ]);
}

?>