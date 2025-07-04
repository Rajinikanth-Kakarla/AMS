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

$querey = mysqli_query($conn,"select * from tblsessionterm where isActive ='1'");
$rwws = mysqli_fetch_array($querey);
$sessionTermId = $rwws['Id'];
$dateTaken = date("Y-m-d");

$qurty = mysqli_query($conn,"select * from tblattendance where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' and dateTimeTaken='$dateTaken'");
$count = mysqli_num_rows($qurty);

if($count == 0){
  $qus = mysqli_query($conn,"select * from tblstudents where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]'");
  while ($ros = $qus->fetch_assoc()) {
    mysqli_query($conn,"insert into tblattendance(admissionNo,classId,classArmId,sessionTermId,status,dateTimeTaken) 
    value('$ros[admissionNumber]','$_SESSION[classId]','$_SESSION[classArmId]','$sessionTermId','0','$dateTaken')");
  }
}

if(isset($_POST['save'])){
  $admissionNo = $_POST['admissionNo'];
  $check = $_POST['check'];
  $N = count($admissionNo);

  $qurty = mysqli_query($conn,"select * from tblattendance where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' and dateTimeTaken='$dateTaken' and status = '1'");
  if(mysqli_num_rows($qurty) > 0){
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Attendance has been taken for today!</div>";
  } else {
    for($i = 0; $i < $N; $i++){
      if(isset($check[$i])){
        $qquery = mysqli_query($conn,"update tblattendance set status='1' where admissionNo = '$check[$i]'");
        $statusMsg = $qquery
          ? "<div class='alert alert-success' style='margin-right:700px;'>Attendance Taken Successfully!</div>"
          : "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Take Attendance</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link rel="icon" href="img/logo/attnlg.jpg">
 
<style>
  body, input, select, textarea {
    font-family: 'Quicksand', sans-serif !important;
  }

  h1, h2, h3, h4, h5, h6 {
    font-family: 'Orbitron', sans-serif !important;
  }

  /* Breadcrumb + header text */
  .card-header h6,
  .breadcrumb-item,
  .breadcrumb-item a {
    font-family: 'Orbitron', sans-serif !important;
  }

  /* Note: italic tag with Orbitron */
  .card-header i {
    font-family: 'Orbitron', sans-serif !important;
    font-style: italic;
  }

  /* Table and buttons */
  .btn,
  .table td,
  .table th {
    font-family: 'Quicksand', sans-serif !important;
  }

  /* Take Attendance button */
  .btn-primary {
    font-family: 'Orbitron', sans-serif !important;
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

  input[type="checkbox"].custom-checkbox {
    accent-color: green;
    width: 50px;
    height: 50px;
    align: center;
  }
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
<h1 class="h3 mb-0 text-black">
  Take Attendance 
  <span style="font-family: 'Quicksand', sans-serif;">(Today's Date: <?php echo date("m-d-Y"); ?>)</span>
</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">All Student in Class</li>
            </ol>
          </div>

          <form method="post">
            <div class="row">
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-black"><?php echo $rrw['className'].' - '.$rrw['classArmName']; ?></h6>
                    <h6 class="m-0 font-weight-bold text-danger">Note: <i>Click on the checkboxes beside each student to take attendance!</i></h6>
                  </div>
                  <div class="table-responsive p-3">
                    <?php echo $statusMsg; ?>
                    <table class="table table-hover">
                      <thead class="thead-light">
                        <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Other Name</th>
                          <th>Admission No</th>
                          <th>Class</th>
                          <th>Batch/Section</th>
                          <th>Check</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $query = "SELECT tblstudents.Id,tblstudents.admissionNumber,tblclass.className,tblclassarms.classArmName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.otherName
                        FROM tblstudents
                        INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                        INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                        WHERE tblstudents.classId = '$_SESSION[classId]' AND tblstudents.classArmId = '$_SESSION[classArmId]'";
                        $rs = $conn->query($query);
                        $sn = 0;
                        if($rs->num_rows > 0){
                          while ($rows = $rs->fetch_assoc()){
                            $sn++;
                            echo "
                              <tr>
                                <td>$sn</td>
                                <td>{$rows['firstName']}</td>
                                <td>{$rows['lastName']}</td>
                                <td>{$rows['otherName']}</td>
                                <td>{$rows['admissionNumber']}</td>
                                <td>{$rows['className']}</td>
                                <td>{$rows['classArmName']}</td>
                                <td><input name='check[]' type='checkbox' value='{$rows['admissionNumber']}' class='custom-checkbox'></td>
                              </tr>
                              <input type='hidden' name='admissionNo[]' value='{$rows['admissionNumber']}'>
                            ";
                          }
                        } else {
                          echo "<div class='alert alert-danger'>No Record Found!</div>";
                        }
                      ?>
                      </tbody>
                    </table>
                    <br>
<div class="text-center">
  <button type="submit" name="save" class="btn btn-primary">Take Attendance</button>
</div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>
</html>
