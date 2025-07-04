<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT tblclass.className,tblclassarms.classArmName 
FROM tblclassteacher
INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
Where tblclassteacher.Id = '$_SESSION[userId]'";

$rs = $conn->query($query);
$rrw = $rs->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
  <link href="img/logo/logo.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">
  
  <!-- CSS Dependencies -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7);
    }

    @import url('https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Quicksand:wght@300;400;500;700&display=swap');
    .btn{
      color: #fff;
    }

    h1, h2, h3, h4, h5, h6, .tabs {
      font-family: 'Orbitron', sans-serif;
      color: #000 !important;
    }

    .breadcrumb-item a {
      color: orange !important;
    }

    .text-gray-800 {
      color: #000 !important;
    }

    .mini-card {
      border: 2px solid #000;
      padding: 20px;
      background-color: #fff;
      transition: all 0.3s ease;
      cursor: pointer;
      font-family: 'Quicksand', sans-serif;
    }

    .mini-card:hover {
      background-color: #fefae0;
      box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
    }

    .mini-card-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .mini-card .label {
      font-size: 14px;
      font-weight: 600;
      text-transform: lowercase;
    }

    .mini-card .count {
  font-size: 48px;
  font-family: 'Figtree', sans-serif;
  font-weight: 800;
  color: #000;
}

  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Topbar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Topbar -->

        <!-- Container Fluid -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">
  <span style="font-family: 'Orbitron', sans-serif; font-weight: 700;">Class Teacher Dashboard</span>
  <span style="font-family: 'Quicksand', sans-serif; font-weight: 500;">(<?php echo $rrw['className'].' - '.$rrw['classArmName'];?>)</span>
</h1>
<div class="tabs">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol></div>
          </div>

          <div class="row mb-3">
            <?php 
              $studentsQuery = mysqli_query($conn,"SELECT * FROM tblstudents WHERE classId = '$_SESSION[classId]' AND classArmId = '$_SESSION[classArmId]'");
              $students = mysqli_num_rows($studentsQuery);
            ?>

            <div class="col-md-3 mb-4">
              <div class="mini-card">
                <div class="mini-card-content">
                  <div class="label">Students</div>
                  <div class="count"><?php echo $students; ?></div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- Container Fluid -->
      </div>

      <!-- Footer -->
      <?php include 'includes/footer.php'; ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- JS Dependencies -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>
