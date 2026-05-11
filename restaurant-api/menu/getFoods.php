<?php

require_once(__DIR__ . "/../config/cors.php");
require_once(__DIR__ . "/../config/db.php");

$query =
"SELECT * FROM foods ORDER BY id DESC";

$result =
mysqli_query($conn, $query);

$foods = [];

while ($row = mysqli_fetch_assoc($result)) {

    $foods[] = $row;
}

echo json_encode($foods);

?>