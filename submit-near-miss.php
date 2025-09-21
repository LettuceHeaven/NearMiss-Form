<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "nearmiss";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$DateofIncedent = $_POST['DateofIncedent'] ?? null;
$TimeofIncedent = $_POST['TimeofIncedent'] ?? null;
$TypeofReport = $_POST['TypeofReport'] ?? '';
$TypeofConcern = $_POST['TypeofConcern'] ?? '';
$Location = $_POST['Location'] ?? '';
$DescricbetheNearMiss = $_POST['DescricbetheNearMiss'] ?? '';
$ActionTaken = $_POST['ActionTaken'] ?? '';
$ReportedBy = $_POST['ReportedBy'] ?? '';
$EmployeelD = $_POST['EmployeelD'] ?? 0;
$Email = $_POST['Email'] ?? '';
$ContactNumber = $_POST['ContactNumber'] ?? '';
$Department = $_POST['Department'] ?? '';
$Sector = $_POST['Sector'] ?? '';

// File uploads (store in 'uploads/' folder)
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$UploadImage = '';
if (isset($_FILES['UploadImage']) && $_FILES['UploadImage']['error'] === 0) {
    $UploadImage = $uploadDir . basename($_FILES['UploadImage']['name']);
    move_uploaded_file($_FILES['UploadImage']['tmp_name'], $UploadImage);
}

$UploadVideo = '';
if (isset($_FILES['UploadVideo']) && $_FILES['UploadVideo']['error'] === 0) {
    $UploadVideo = $uploadDir . basename($_FILES['UploadVideo']['name']);
    move_uploaded_file($_FILES['UploadVideo']['tmp_name'], $UploadVideo);
}

// Insert into database
$stmt = $conn->prepare("
    INSERT INTO incidentreport
    (DateofIncedent, TimeofIncedent, TypeofReport, TypeofConcern, Location, DescricbetheNearMiss, ActionTaken, UploadImage, UploadVideo, ReportedBy, EmployeelD, Email, ContactNumber, Department, Sector)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssssssissss",
    $DateofIncedent,
    $TimeofIncedent,
    $TypeofReport,
    $TypeofConcern,
    $Location,
    $DescricbetheNearMiss,
    $ActionTaken,
    $UploadImage,
    $UploadVideo,
    $ReportedBy,
    $EmployeelD,
    $Email,
    $ContactNumber,
    $Department,
    $Sector
);

if ($stmt->execute()) {
    // Redirect to form with success query
    header("Location: form.html?status=success");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
