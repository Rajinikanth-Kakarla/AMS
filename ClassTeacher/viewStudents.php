<?php 
error_reporting(0);
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
  <link rel="icon" href="img/logo/attnlg.jpg">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <!-- Custom Style -->
  <style>
    body, input, select, textarea {
      font-family: 'Quicksand', sans-serif !important;
    }

    h1, h2, h3, h4, h5, h6{
      font-family: 'Orbitron', sans-serif !important;
    }

    .breadcrumb-item,
.breadcrumb-item a,
.card-header h6 {
  font-family: 'Orbitron', sans-serif !important;
}

    
    .btn,
    .table td,
    .table th {
      font-family: 'Quicksand', sans-serif !important;
    }

    .btn-primary {
      background: linear-gradient(to right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7) !important;
      color: black !important;
      border: none !important;
    }

    .btn-primary:hover {
      color: white !important;
      background: linear-gradient(to right, #FFEA61, #FFD400, #FFDD3C, #FFF192, #FFFFB7) !important;
      transition: all 0.3s ease-in-out;
    }

    .form-control {
      border: 2px solid black !important;
      border-radius: 0 !important;
    }

    .breadcrumb-item a {
      color: orange !important;
    }

    .breadcrumb-item.active {
      color: black !important;
    }

    table td, table th {
      vertical-align: middle !important;
    }
 div.dataTables_filter {
  float: right;
}
    div.dataTables_filter input {
      
      width: 500px !important;
      height: 30px !important;
      border: 2px solid black !important;
      border-radius: 0 !important;
    }
    .page-item.active .page-link {
  background: linear-gradient(to right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7) !important;
  color: black !important;
  border: none !important;
}

  </style>

  <script>
    function classArmDropdown(str) {
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else {
        if (window.XMLHttpRequest) {
          xmlhttp = new XMLHttpRequest();
        } else {
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxClassArms2.php?cid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php"; ?>

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-black">
              All Student in Class<span style="font-family: 'Quicksand', sans-serif;">(<?php echo $rrw['className'] . ' - ' . $rrw['classArmName']; ?>)</span>
            </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item" style=""><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">All Student in Class</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-black">All Student In Class</h6>
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
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
                      tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber,tblstudents.dateCreated
                      FROM tblstudents
                      INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                      INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                      WHERE tblstudents.classId = '$_SESSION[classId]' AND tblstudents.classArmId = '$_SESSION[classArmId]'";

                      $rs = $conn->query($query);
                      $sn = 0;

                      if ($rs->num_rows > 0) {
                        while ($rows = $rs->fetch_assoc()) {
                          $sn++;
                          echo "
                            <tr>
                              <td>{$sn}</td>
                              <td>{$rows['firstName']}</td>
                              <td>{$rows['lastName']}</td>
                              <td>{$rows['otherName']}</td>
                              <td>{$rows['admissionNumber']}</td>
                              <td>{$rows['className']}</td>
                              <td>{$rows['classArmName']}</td>
                            </tr>
                          ";
                        }
                      } else {
                        echo "
                          <div class='alert alert-danger' role='alert'>
                            No Record Found!
                          </div>";
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
      $('#dataTable').DataTable();
      $('#dataTableHover').DataTable();
    });
  </script>
</body>

</html>
