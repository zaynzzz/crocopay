<?php
$conn = new mysqli(
    'localhost',
    'root',
    'root',
    'croco_pay',
    3306,
    '/Applications/MAMP/tmp/mysql/mysql.sock'
);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
echo "Connected successfully!";
