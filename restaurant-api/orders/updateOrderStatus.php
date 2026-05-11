<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include_once(__DIR__ . "/../config/db.php");

$data =
json_decode(
file_get_contents(
"php://input"
),
true
);

$orderId =
$data['orderId'];

$itemIndex =
$data['itemIndex'];

$status =
$data['status'];

/* GET CURRENT ITEMS */
$query =
"
SELECT items
FROM orders
WHERE id='$orderId'
";

$result =
mysqli_query(
$conn,
$query
);

$row =
mysqli_fetch_assoc(
$result
);

$items =
json_decode(
$row['items'],
true
);

/* UPDATE ONLY ONE FOOD STATUS */
$items[
$itemIndex
]['status'] =
$status;

$updatedItems =
json_encode(
$items
);

/* SAVE BACK */
$updateQuery =
"
UPDATE orders
SET items='$updatedItems'
WHERE id='$orderId'
";

$updateResult =
mysqli_query(
$conn,
$updateQuery
);

echo json_encode([
"success"=>$updateResult
]);

?>