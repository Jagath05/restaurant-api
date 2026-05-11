<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once(__DIR__ . "/../config/db.php");

$tableNumber =
$_GET['tableNumber']
?? '';

if(!$tableNumber){

echo json_encode([]);
exit();
}

$query =
"
SELECT *
FROM orders
WHERE table_number='$tableNumber'
ORDER BY id DESC
";

$result =
mysqli_query(
$conn,
$query
);

$orders = [];

while(
$row =
mysqli_fetch_assoc(
$result)
){

$row['items'] =
json_decode(
$row['items'],
true
);

$orders[] =
$row;
}

echo json_encode(
$orders
);

?>