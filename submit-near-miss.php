<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";  // Change if needed
$username   = "root";       // Your DB username
$password   = "";           // Your DB password
$dbname     = "nearmiss";   // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Collect form data (check if values exist first)
$DateofIncedent  = $_POST['DateofIncedent'] ?? null;
$TimeofIncedent  = $_POST['TimeofIncedent'] ?? null;
$TypeofReport    = $_POST['TypeofReport'] ?? null;
$TypeofIncident  = $_POST['TypeofIncident'] ?? null;
$TypeofConcern   = $_POST['TypeofConcern'] ?? null;
$Location        = $_POST['Location'] ?? null;
$Descricbe       = $_POST['Descricbe'] ?? null;
$ActionTaken     = $_POST['ActionTaken'] ?? null;
$Department      = $_POST['Department'] ?? null;
$Sector          = $_POST['Sector'] ?? null;
$EmployeeID      = $_POST['EmployeeID'] ?? null;
$ReportedBy      = $_POST['ReportedBy'] ?? null;
$Email           = $_POST['Email'] ?? null;
$ContactNumber   = $_POST['ContactNumber'] ?? null;

// Handle file uploads
$UploadImage = "";
$UploadVideo = "";

// Create uploads folder if it doesn’t exist
if (!file_exists("uploads")) {
    mkdir("uploads", 0777, true);
}

if (isset($_FILES['UploadImage']) && $_FILES['UploadImage']['error'] === UPLOAD_ERR_OK) {
    $UploadImage = "uploads/" . time() . "_" . basename($_FILES["UploadImage"]["name"]);
    if (!move_uploaded_file($_FILES["UploadImage"]["tmp_name"], $UploadImage)) {
        echo "⚠️ Failed to move uploaded image.<br>";
    }
}

if (isset($_FILES['UploadVideo']) && $_FILES['UploadVideo']['error'] === UPLOAD_ERR_OK) {
    $UploadVideo = "uploads/" . time() . "_" . basename($_FILES["UploadVideo"]["name"]);
    if (!move_uploaded_file($_FILES["UploadVideo"]["tmp_name"], $UploadVideo)) {
        echo "⚠️ Failed to move uploaded video.<br>";
    }
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO near_miss_reports 
    (DateofIncedent, TimeofIncedent, TypeofReport, TypeofIncident, TypeofConcern, Location, Descricbe, ActionTaken, UploadImage, UploadVideo, Department, Sector, EmployeeID, ReportedBy, Email, ContactNumber) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt) {
    $stmt->bind_param(
        "ssssssssssssssss",
        $DateofIncedent,
        $TimeofIncedent,
        $TypeofReport,
        $TypeofIncident,
        $TypeofConcern,
        $Location,
        $Descricbe,
        $ActionTaken,
        $UploadImage,
        $UploadVideo,
        $Department,
        $Sector,
        $EmployeeID,
        $ReportedBy,
        $Email,
        $ContactNumber
    );

    if ($stmt->execute()) {
        echo "✅ Insert successful! Data saved to database.";
    } else {
        echo "❌ Insert failed: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ Error preparing statement: " . $conn->error;
}

$conn->close();
?>
