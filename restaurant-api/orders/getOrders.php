<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once(__DIR__ . "/../config/db.php");

$query =
"
SELECT *
FROM orders
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