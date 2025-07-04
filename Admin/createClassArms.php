<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    
    $classId=$_POST['classId'];
    $classArmName=$_POST['classArmName'];
   
    $query=mysqli_query($conn,"select * from tblclassarms where classArmName ='$classArmName' and classId = '$classId'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Class Arm Already Exists!</div>";
    } else {
        $query=mysqli_query($conn,"insert into tblclassarms(classId,classArmName,isAssigned) value('$classId','$classArmName','0')");
        if ($query) {
            $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
        } else {
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
        }
    }
}

//------------------------EDIT--------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
    $Id= $_GET['Id'];
    $query=mysqli_query($conn,"select * from tblclassarms where Id ='$Id'");
    $row=mysqli_fetch_array($query);

    if(isset($_POST['update'])){
        $classId=$_POST['classId'];
        $classArmName=$_POST['classArmName'];
        $query=mysqli_query($conn,"update tblclassarms set classId = '$classId', classArmName='$classArmName' where Id='$Id'");
        if ($query) {
            echo "<script type = \"text/javascript\">
            window.location = (\"createClassArms.php\")
            </script>"; 
        } else {
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
        }
    }
}

//------------------------DELETE------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
    $Id= $_GET['Id'];
    $query = mysqli_query($conn,"DELETE FROM tblclassarms WHERE Id='$Id'");
    if ($query == TRUE) {
        echo "<script type = \"text/javascript\">
        window.location = (\"createClassArms.php\")
        </script>";  
    } else {
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <?php include 'includes/title.php';?>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

  <!-- Stylesheets -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <style>
    body, input, select, textarea {
      font-family: 'Quicksand', sans-serif !important;
    }

    h1, h2, h3, h4, h5, h6, .btn, .tabs {
      font-family: 'Orbitron', sans-serif !important;
    }

    .btn-primary, .btn-warning, .page-item.active .page-link {
      background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7) !important;
      color: #000 !important;
      border: none !important;
    }

    .btn-primary:hover, .btn-warning:hover {
  background: linear-gradient(to bottom right, #FFEA61, #FFD400, #FFDD3C, #FFF192, #FFFFB7) !important;
  color:  #fff !important;
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

    a.text-success, a.text-danger {
      font-weight: bold;
    }
    
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php";?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php";?>

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-black">Create Sections</h1>
            <div class="tabs">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-orange" href="./">Home</a></li>
              <li class="breadcrumb-item active text-black" aria-current="page">Create Sections</li>
            </ol></div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-black">Create Section</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Select Class<span class="text-danger ml-2">*</span></label>
                        <?php
                          $qry= "SELECT * FROM tblclass ORDER BY className ASC";
                          $result = $conn->query($qry);
                          $num = $result->num_rows;		
                          if ($num > 0){
                            echo '<select required name="classId" class="form-control mb-3">';
                            echo'<option value="">--Select Class--</option>';
                            while ($rows = $result->fetch_assoc()){
                              echo'<option value="'.$rows['Id'].'" >'.$rows['className'].'</option>';
                            }
                            echo '</select>';
                          }
                        ?>  
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Class Section Title<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="classArmName" value="<?php echo $row['classArmName'];?>" placeholder="Class Arm Name">
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

              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-black">All Sections</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $query = "SELECT tblclassarms.Id,tblclassarms.isAssigned,tblclass.className,tblclassarms.classArmName 
                      FROM tblclassarms
                      INNER JOIN tblclass ON tblclass.Id = tblclassarms.classId";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      if($num > 0) {
                        while ($rows = $rs->fetch_assoc()) {
                          $status = $rows['isAssigned'] == '1' ? "Assigned" : "UnAssigned";
                          $sn++;
                          echo "
                          <tr>
                            <td>{$sn}</td>
                            <td>{$rows['className']}</td>
                            <td>{$rows['classArmName']}</td>
                            <td>{$status}</td>
                            <td><a class='text-success' href='?action=edit&Id={$rows['Id']}'><i class='fas fa-fw fa-edit text-success'></i> Edit</a></td>
                            <td><a class='text-danger' href='?action=delete&Id={$rows['Id']}'><i class='fas fa-fw fa-trash text-danger'></i> Delete</a></td>
                          </tr>";
                        }
                      } else {
                        echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
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

      <?php include "Includes/footer.php";?>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

  <!-- Scripts -->
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
