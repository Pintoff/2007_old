<?php
$servername = "localhost:3306";
$username = "root";
$password = "qweasd123";
$dbname = "computers";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
?>