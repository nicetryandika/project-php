<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "database_sql";

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("DB Connection Failed: " . mysqli_connect_error());
}
