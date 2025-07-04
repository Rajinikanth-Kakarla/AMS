<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT tblclass.className, tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    WHERE tblclassteacher.Id = '$_SESSION[userId]'";

$rs = $conn->query($query);
$rrw = $rs->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

  <!-- CSS Dependencies -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Quicksand', sans-serif !important;
      background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7) !important;
    }

    h1 {
      font-family: 'Orbitron', sans-serif;
    }

    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .metric-box {
      background: #fff;
      border: 2px solid #000;
      padding: 15px;
    }

    .btn{
      color: #fff;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: 'Orbitron', sans-serif;
      color: #000 !important;
    }

    .progress {
      height: 20px;
      background-color: #eee;
      border: 1px solid #ccc;
    }

    .progress-bar {
      height: 100%;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <!-- Topbar -->
        <?php include "Includes/topbar.php"; ?>

        <!-- Main Content -->
        <div class="container-fluid py-4">
          <h1 class="text-center mb-4">Administrator Dashboard</h1>

          <div class="grid-container">
            <?php 
              function metricBox($title, $value, $max, $color) {
                $percent = min(100, ($value / $max) * 100);
                echo '
                  <div class="metric-box">
                    <h5 class="font-weight-bold">'.htmlspecialchars($title).'</h5>
                    <p>'.htmlspecialchars($value).' / '.htmlspecialchars($max).'</p>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: '.$percent.'%; background-color: '.$color.';"></div>
                    </div>
                  </div>';
              }

              // Metrics
              $students = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tblstudents"));
              $class = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tblclass"));
              $classArms = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tblclassarms"));
              $totAttendance = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tblattendance"));
              $classTeacher = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tblclassteacher"));
              $sessTerm = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tblsessionterm"));
              $termonly = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tblterm"));

              // Render 7 real metric boxes
              metricBox("Students", $students, 100, "#4caf50");
              metricBox("Classes", $class, 20, "#ff9800");
              metricBox("Sections", $classArms, 20, "#9c27b0");
              metricBox("Total Attendances", $totAttendance, 1000, "#03a9f4");
              metricBox("Class Teachers", $classTeacher, 10, "#f44336");
              metricBox("Sessions", $sessTerm, 10, "#3f51b5");
              metricBox("Terms", $termonly, 4, "#795548");
            ?>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="bg-light text-center py-3">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> GDF Labs. All rights reserved.</p>
      </footer>

    </div>
  </div>

  <!-- Scripts -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>
</html>
