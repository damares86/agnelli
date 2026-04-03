<?php
$conn = new mysqli("localhost", "admin", "admin", "agnelli");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connessione fallita"]));
}

$category = $_GET['category'] ?? '';

// query base
$sql = "SELECT re.*, rc.name as category_name
        FROM registry_entry re
        JOIN registry_category rc ON re.registry_category_id = rc.id";

// filtro
if (!empty($category)) {
    $sql .= " WHERE re.registry_category_id = " . intval($category);
}

// ordinamento SEMPRE alla fine
$sql .= " ORDER BY re.name ASC";

$result = $conn->query($sql);

if (!$result) {
    die(json_encode([
        "error" => $conn->error,
        "query" => $sql
    ]));
}

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode(["data" => $data]);