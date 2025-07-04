<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------
if(isset($_POST['save'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNo = $_POST['phoneNo'];
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];
    $dateCreated = date("Y-m-d");
    
    $query = mysqli_query($conn,"select * from tblclassteacher where emailAddress ='$emailAddress'");
    $ret = mysqli_fetch_array($query);

    $sampPass = "pass123";
    $sampPass_2 = md5($sampPass);

    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
    } else {
        $query = mysqli_query($conn,"INSERT into tblclassteacher(firstName,lastName,emailAddress,password,phoneNo,classId,classArmId,dateCreated) 
        value('$firstName','$lastName','$emailAddress','$sampPass_2','$phoneNo','$classId','$classArmId','$dateCreated')");
        if ($query) {
            $qu = mysqli_query($conn,"update tblclassarms set isAssigned='1' where Id ='$classArmId'");
            $statusMsg = $qu 
              ? "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>"
              : "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
        } else {
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
        }
    }
}

//------------------------EDIT--------------------------------------------------
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
    $Id = $_GET['Id'];
    $query = mysqli_query($conn,"select * from tblclassteacher where Id ='$Id'");
    $row = mysqli_fetch_array($query);

    if(isset($_POST['update'])){
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $emailAddress = $_POST['emailAddress'];
        $phoneNo = $_POST['phoneNo'];
        $classId = $_POST['classId'];
        $classArmId = $_POST['classArmId'];

        $query = mysqli_query($conn,"update tblclassteacher set firstName='$firstName', lastName='$lastName',
        emailAddress='$emailAddress', phoneNo='$phoneNo', classId='$classId',classArmId='$classArmId' where Id='$Id'");
        
        echo $query
          ? "<script>window.location = 'createClassTeacher.php'</script>"
          : "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
}

//------------------------DELETE------------------------------------------------
if (isset($_GET['Id']) && isset($_GET['classArmId']) && isset($_GET['action']) && $_GET['action'] == "delete") {
    $Id = $_GET['Id'];
    $classArmId = $_GET['classArmId'];

    $query = mysqli_query($conn,"DELETE FROM tblclassteacher WHERE Id='$Id'");
    if ($query == TRUE) {
        $qu = mysqli_query($conn,"update tblclassarms set isAssigned='0' where Id ='$classArmId'");
        echo $qu
          ? "<script>window.location = 'createClassTeacher.php'</script>"
          : "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    } else {
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Create Class Teacher</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link rel="icon" href="img/logo/attnlg.jpg">

  <style>
    body, input, select, textarea {
      font-family: 'Quicksand', sans-serif !important;
    }

    h1, h2, h3, h4, h5, h6, .btn , .tabs{
      font-family: 'Orbitron', sans-serif !important;
    }

    .btn-primary, .btn-warning, .page-item.active .page-link {
      background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7) !important;
      color: #000 !important;
      border: none !important;
    }

    .btn-primary:hover, .btn-warning:hover {
  background: linear-gradient(to bottom right, #FFEA61, #FFD400, #FFDD3C, #FFF192, #FFFFB7) !important;
  color: #fff !important;
  opacity: 0.9;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
  transition: all 0.3s ease-in-out;
}


    .form-control {
      border: 2px solid black !important;
      border-radius: 0 !important;
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

    .text-black {
      color: #000 !important;
    }

    .text-orange {
      color: orange !important;
    }

    a.text-danger {
      font-weight: bold;
    }
  </style>

  <script>
    function classArmDropdown(str) {
      if (!str) return document.getElementById("txtHint").innerHTML = "";
      const xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
          document.getElementById("txtHint").innerHTML = this.responseText;
      };
      xmlhttp.open("GET", "ajaxClassArms.php?cid=" + str, true);
      xmlhttp.send();
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
            <h1 class="h3 mb-0 text-black">Create Class Teachers</h1>
            <div class="tabs">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-orange" href="./">Home</a></li>
              <li class="breadcrumb-item active text-black" aria-current="page">Create Class Teachers</li>
            </ol></div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-black">Create Class Teachers</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label>Firstname<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="firstName" value="<?php echo $row['firstName']; ?>">
                      </div>
                      <div class="col-xl-6">
                        <label>Lastname<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="lastName" value="<?php echo $row['lastName']; ?>">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label>Email Address<span class="text-danger ml-2">*</span></label>
                        <input type="email" class="form-control" required name="emailAddress" value="<?php echo $row['emailAddress']; ?>">
                      </div>
                      <div class="col-xl-6">
                        <label>Phone No<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="phoneNo" value="<?php echo $row['phoneNo']; ?>">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label>Select Class<span class="text-danger ml-2">*</span></label>
                        <?php
                          $qry = "SELECT * FROM tblclass ORDER BY className ASC";
                          $result = $conn->query($qry);
                          if ($result->num_rows > 0) {
                            echo '<select required name="classId" onchange="classArmDropdown(this.value)" class="form-control mb-3">';
                            echo '<option value="">--Select Class--</option>';
                            while ($rows = $result->fetch_assoc()) {
                              echo '<option value="'.$rows['Id'].'">'.$rows['className'].'</option>';
                            }
                            echo '</select>';
                          }
                        ?>
                      </div>
                      <div class="col-xl-6">
                        <label>Section<span class="text-danger ml-2">*</span></label>
                        <div id="txtHint"></div>
                      </div>
                    </div>
                    <?php if (isset($Id)) { ?>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                    <?php } else { ?>
                      <button type="submit" name="save" class="btn btn-primary">Save</button>
                    <?php } ?>
                  </form>
                </div>
              </div>

              <!-- All Class Teachers -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-black">All Class Teachers</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Phone No</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Date Created</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $query = "SELECT tblclassteacher.Id, tblclass.className, tblclassarms.classArmName,
                        tblclassarms.Id AS classArmId, tblclassteacher.firstName, tblclassteacher.lastName,
                        tblclassteacher.emailAddress, tblclassteacher.phoneNo, tblclassteacher.dateCreated
                        FROM tblclassteacher
                        INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
                        INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId";
                        $rs = $conn->query($query);
                        $sn = 0;
                        if ($rs->num_rows > 0) {
                          while ($rows = $rs->fetch_assoc()) {
                            $sn++;
                            echo "<tr>
                              <td>{$sn}</td>
                              <td>{$rows['firstName']}</td>
                              <td>{$rows['lastName']}</td>
                              <td>{$rows['emailAddress']}</td>
                              <td>{$rows['phoneNo']}</td>
                              <td>{$rows['className']}</td>
                              <td>{$rows['classArmName']}</td>
                              <td>{$rows['dateCreated']}</td>
                              <td><a class='text-danger' href='?action=delete&Id={$rows['Id']}&classArmId={$rows['classArmId']}'><i class='fas fa-fw fa-trash text-danger'></i> Delete</a></td>
                            </tr>";
                          }
                        } else {
                          echo "<div class='alert alert-danger'>No Record Found!</div>";
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

  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

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
