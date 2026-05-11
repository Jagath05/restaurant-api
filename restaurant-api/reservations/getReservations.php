<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once(__DIR__ . "/../config/db.php");

$query =
"
SELECT *
FROM reservations
ORDER BY id DESC
";

$result =
mysqli_query(
$conn,
$query
);

$reservations = [];

while(
$row =
mysqli_fetch_assoc(
$result)
){

$reservations[] =
$row;
}

echo json_encode(
$reservations
);

?>