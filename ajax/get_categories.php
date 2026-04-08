<?php
$conn = new mysqli("localhost", "admin", "admin", "agnelli");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connessione fallita"]));
}

// 👉 aggiunto ORDER BY
$result = $conn->query("SELECT id, name FROM registry_category ORDER BY name ASC");

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);