<?php

$host = "viaduct.proxy.rlwy.net";
$user = "root";
$password = "CaHzIoPGwTpzoAsPNJyMQKIbbMrUsqNi";
$database = "railway";
$port = 36087;

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database,
    $port
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>