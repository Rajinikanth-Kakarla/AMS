<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    <style>
  /* Base fonts */
  body, input, select, textarea {
    font-family: 'Quicksand', sans-serif !important;
  }

  h1, h2, h3, h4, h5, h6 {
    font-family: 'Orbitron', sans-serif !important;
  }

  /* Breadcrumbs and card titles */
  .breadcrumb-item,
  .breadcrumb-item a,
  h6.card-title {
    font-family: 'Orbitron', sans-serif !important;
  }

  /* Button styling */
  .btn {
    font-family: 'Quicksand', sans-serif !important;
  }

  .btn-primary {
    font-family: 'Orbitron', sans-serif !important;
    background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7) !important;
    color: #000 !important;
    border: none !important;
  }

  .btn-primary:hover {
    color: #fff !important;
    background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7) !important;
    opacity: 0.95;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
  }

  /* Form inputs */
  .form-control {
    border: 2px solid black !important;
    border-radius: 0 !important;
  }

  /* DataTables search input */
  div.dataTables_filter {
    float: right;
  }

  div.dataTables_filter input {
    width: 500px !important;
    height: 30px !important;
    border: 2px solid black !important;
    border-radius: 0 !important;
  }

  /* Color helpers */
  .text-black {
    color: #000 !important;
  }

  .text-orange {
    color: orange !important;
  }

  /* Pagination active style */
  .page-item.active .page-link {
    background: linear-gradient(to right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7) !important;
    color: black !important;
    border: none !important;
  }
</style>

  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php"; ?>

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-black">View Class Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-orange" href="./">Home</a></li>
              <li class="breadcrumb-item active text-black" aria-current="page">View Class Attendance</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-black card-title">View Class Attendance</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Select Date<span class="text-danger ml-2">*</span></label>
                        <input type="date" class="form-control" name="dateTaken" id="exampleInputFirstName">
                      </div>
                    </div>
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>

              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-black card-title">Class Attendance</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Other Name</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Batch/Section</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(isset($_POST['view'])){
                        $dateTaken =  $_POST['dateTaken'];
                        $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblclass.className,
                          tblclassarms.classArmName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                          tblstudents.firstName,tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber
                          FROM tblattendance
                          INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                          INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                          INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                          INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                          INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                          WHERE tblattendance.dateTimeTaken = '$dateTaken' AND tblattendance.classId = '$_SESSION[classId]' AND tblattendance.classArmId = '$_SESSION[classArmId]'";

                        $rs = $conn->query($query);
                        $num = $rs->num_rows;
                        $sn = 0;
                        if($num > 0){
                          while ($rows = $rs->fetch_assoc()){
                            $status = $rows['status'] == '1' ? "Present" : "Absent";
                            $colour = $rows['status'] == '1' ? "#00FF00" : "#FF0000";
                            $sn++;
                            echo "<tr>
                              <td>{$sn}</td>
                              <td>{$rows['firstName']}</td>
                              <td>{$rows['lastName']}</td>
                              <td>{$rows['otherName']}</td>
                              <td>{$rows['admissionNumber']}</td>
                              <td>{$rows['className']}</td>
                              <td>{$rows['classArmName']}</td>
                              <td>{$rows['sessionName']}</td>
                              <td>{$rows['termName']}</td>
                              <td style='background-color:{$colour}'>{$status}</td>
                              <td>{$rows['dateTimeTaken']}</td>
                            </tr>";
                          }
                        } else {
                          echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#dataTableHover').DataTable();
    });
  </script>
</body>

</html>
