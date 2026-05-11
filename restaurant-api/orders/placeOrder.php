<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

// Handle preflight
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){

    http_response_code(200);
    exit();
}

include_once(__DIR__ . "/../config/db.php");

// Get request
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
        "message" => "No data"
    ]);

    exit();
}

// Form data
$customer_name =
$data['customer_name'];

$table_number =
$data['table_number'];

$items =
json_encode(
    $data['items']
);

$subtotal =
$data['subtotal'];

$tax =
$data['tax'];

$total =
$data['total'];

$payment_method =
$data['payment_method'];

// Generate order number
$orderNumber =
"ORD-" .
rand(
1000,
9999
);

// Insert order
$query =
"
INSERT INTO orders
(
order_number,
customer_name,
table_number,
items,
subtotal,
tax,
total,
payment_method,
payment_status,
bill_generated
)
VALUES
(
'$orderNumber',
'$customer_name',
'$table_number',
'$items',
'$subtotal',
'$tax',
'$total',
'$payment_method',
'Pending',
'Yes'
)
";

$result =
mysqli_query(
    $conn,
    $query
);

if($result){

    $orderId =
    mysqli_insert_id(
        $conn
    );

    echo json_encode([

        "success" =>
        true,

        "message" =>
        "Order placed successfully",

        "order_id" =>
        $orderId,

        "order_number" =>
        $orderNumber

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