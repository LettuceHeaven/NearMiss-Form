<?php
// 🔹 Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "nearmiss";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// 🔹 Fetch table data
$sql = "SELECT * FROM near_miss_reports";
$result = $conn->query($sql);
$rows = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
  }
}

// 🔹 Fetch chart data
$chartData = [];
$chartQuery = "SELECT Department, COUNT(*) as count FROM near_miss_reports GROUP BY Department";
$chartResult = $conn->query($chartQuery);
while ($row = $chartResult->fetch_assoc()) {
  $chartData[] = $row;
}

// 🔹 Send JSON response
header("Content-Type: application/json");
echo json_encode([
  "tableData" => $rows,
  "chartData" => $chartData
]);
