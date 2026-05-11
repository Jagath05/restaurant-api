<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once(__DIR__ . "/../config/db.php");

$query =
"
SELECT *
FROM restaurant_tables
ORDER BY table_number ASC
";

$result =
mysqli_query(
    $conn,
    $query
);

$tables = [];

while(
$row =
mysqli_fetch_assoc(
$result)
){

    $tables[] =
    $row;
}

echo json_encode(
    $tables
);

?>