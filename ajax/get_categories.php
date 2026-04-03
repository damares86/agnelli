<?php
$conn = new mysqli("localhost", "admin", "admin", "agnelli");

$result = $conn->query("SELECT id, name FROM registry_category");

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);