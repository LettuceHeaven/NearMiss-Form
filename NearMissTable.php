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

// 🔹 Fetch data for table
$sql = "SELECT * FROM near_miss_reports";
$result = $conn->query($sql);

// 🔹 Fetch data for charts (department counts)
$chartData = [];
$chartQuery = "SELECT Department, COUNT(*) as count FROM near_miss_reports GROUP BY Department";
$chartResult = $conn->query($chartQuery);
while ($row = $chartResult->fetch_assoc()) {
  $chartData[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Near Miss Report Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f4f8;
    }
    header {
      background-color: #2c2f9c;
      padding: 15px;
      text-align: center;
      color: #fff;
      font-size: 22px;
      font-weight: bold;
    }
    .dashboard {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 20px;
      flex-wrap: wrap;
    }
    .card {
      flex: 1 1 350px;
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      max-width: 400px;
    }
    .card canvas {
      max-height: 220px; /* 🔹 Make charts smaller */
    }
    h3 {
      margin-bottom: 10px;
      font-size: 16px;
    }
    .table-card {
      margin: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      padding: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #2c2f9c;
      color: #fff;
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    button.details-btn {
      padding: 6px 12px;
      border: none;
      background: #2c2f9c;
      color: #fff;
      border-radius: 5px;
      cursor: pointer;
    }
    button.details-btn:hover {
      background: #1e1f7a;
    }
    /* 🔹 Modal Styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
    }
    .modal-content {
      background: #fff;
      margin: 10% auto;
      padding: 20px;
      border-radius: 10px;
      width: 60%;
      max-width: 600px;
    }
    .close {
      float: right;
      font-size: 22px;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header>Near Miss Report Dashboard</header>

  <!-- 🔹 Dashboard Charts -->
  <div class="dashboard">
    <div class="card">
      <h3>Reports by Department</h3>
      <canvas id="barChart"></canvas>
    </div>
    <div class="card">
      <h3>Near Miss Distribution</h3>
      <canvas id="pieChart"></canvas>
    </div>
  </div>

  <!-- 🔹 Incident Table -->
  <div class="table-card">
    <h3>Incident Reports</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Type of Report</th>
          <th>Location</th>
          <th>Reported By</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>".$row['id']."</td>
            <td>".$row['DateofIncedent']."</td>
            <td>".$row['TypeofReport']."</td>
            <td>".$row['Location']."</td>
            <td>".$row['ReportedBy']."</td>
            <td>
              <button class='details-btn' 
                data-id='".$row['id']."'
                data-date='".$row['DateofIncedent']."'
                data-time='".$row['TimeofIncedent']."'
                data-report='".$row['TypeofReport']."'
                data-incident='".$row['TypeofIncident']."'
                data-concern='".$row['TypeofConcern']."'
                data-location='".$row['Location']."'
                data-desc='".$row['Descricbe']."'
                data-action='".$row['ActionTaken']."'
                data-department='".$row['Department']."'
                data-sector='".$row['Sector']."'
                data-employee='".$row['EmployeeID']."'
                data-reported='".$row['ReportedBy']."'
                data-email='".$row['Email']."'
                data-contact='".$row['ContactNumber']."'
                data-submitted='".$row['submitted_at']."'
              >Details</button>
            </td>
          </tr>";
  }
} else {
  echo "<tr><td colspan='6'>No records found</td></tr>";
}
        ?>
      </tbody>
    </table>
  </div>

  <!-- 🔹 Modal -->
  <div id="detailsModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Incident Details</h2>
      <p><b>ID:</b> <span id="modal-id"></span></p>
      <p><b>Date:</b> <span id="modal-date"></span></p>
      <p><b>Type of Report:</b> <span id="modal-report"></span></p>
      <p><b>Type of Concern:</b> <span id="modal-concern"></span></p>
      <p><b>Location:</b> <span id="modal-location"></span></p>
      <p><b>Description:</b> <span id="modal-desc"></span></p>
      <p><b>Action Taken:</b> <span id="modal-action"></span></p>
      <p><b>Reported By:</b> <span id="modal-reported"></span></p>
    </div>
  </div>

  <script>
    // 🔹 Prepare chart data from PHP
    const chartData = <?php echo json_encode($chartData); ?>;
    const labels = chartData.map(item => item.Department);
    const values = chartData.map(item => item.count);

    // 🔹 Bar Chart
    new Chart(document.getElementById("barChart"), {
      type: "bar",
      data: {
        labels: labels,
        datasets: [{
          label: "Reports",
          data: values,
          backgroundColor: "#2c2f9c"
        }]
      }
    });

    // 🔹 Pie Chart
    new Chart(document.getElementById("pieChart"), {
      type: "pie",
      data: {
        labels: labels,
        datasets: [{
          data: values,
          backgroundColor: ["#2c2f9c", "#1abc9c", "#f39c12", "#e74c3c"]
        }]
      }
    });

    // 🔹 Modal Script
    const modal = document.getElementById("detailsModal");
    const closeBtn = document.querySelector(".close");

    document.querySelectorAll(".details-btn").forEach(button => {
      button.addEventListener("click", () => {
        document.getElementById("modal-id").textContent = button.dataset.id;
        document.getElementById("modal-date").textContent = button.dataset.date;
        document.getElementById("modal-report").textContent = button.dataset.report;
        document.getElementById("modal-concern").textContent = button.dataset.concern;
        document.getElementById("modal-location").textContent = button.dataset.location;
        document.getElementById("modal-desc").textContent = button.dataset.desc;
        document.getElementById("modal-action").textContent = button.dataset.action;
        document.getElementById("modal-reported").textContent = button.dataset.reported;
        modal.style.display = "block";
      });
    });

    closeBtn.onclick = () => { modal.style.display = "none"; };
    window.onclick = (event) => { if (event.target == modal) modal.style.display = "none"; };
  </script>
</body>
</html>
