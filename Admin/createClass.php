<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if(isset($_POST['save'])){
    $className=$_POST['className'];
    $query=mysqli_query($conn,"select * from tblclass where className ='$className'");
    $ret=mysqli_fetch_array($query);
    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger'>This Class Already Exists!</div>";
    } else {
        $query=mysqli_query($conn,"insert into tblclass(className) value('$className')");
        if ($query) {
            $statusMsg = "<div class='alert alert-success'>Created Successfully!</div>";
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
    }
}

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
    $Id= $_GET['Id'];
    $query=mysqli_query($conn,"select * from tblclass where Id ='$Id'");
    $row=mysqli_fetch_array($query);

    if(isset($_POST['update'])){
        $className=$_POST['className'];
        $query=mysqli_query($conn,"update tblclass set className='$className' where Id='$Id'");
        if ($query) {
            echo "<script type = \"text/javascript\">
            window.location = (\"createClass.php\")
            </script>"; 
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
    }
}

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
    $Id= $_GET['Id'];
    $query = mysqli_query($conn,"DELETE FROM tblclass WHERE Id='$Id'");
    if ($query == TRUE) {
        echo "<script type = \"text/javascript\">
        window.location = (\"createClass.php\")
        </script>";  
    } else {
        $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <?php include 'includes/title.php';?>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

  <!-- Bootstrap & FontAwesome -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <!-- Custom Styling -->
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
    }
    h1, h6, .btn, .breadcrumb {
      font-family: 'Orbitron', sans-serif;
    }
    .form-control {
      font-family: 'Quicksand', sans-serif;
      border-radius: 0 !important;
      border: 2px solid black !important;
    }

    .btn-primary, .btn-warning {
      color: #000;
      background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7);
      border: none;
    }
    .btn-primary:hover, .btn-warning:hover {
      filter: brightness(0.95);
    }

    .pagination .page-item.active .page-link {
      background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7);
      color: #000;
      border: none;
    }

    .text-orange {
      color: orange !important;
    }
    .text-black {
      color: black !important;
    }
    .action-icon {
      margin-right: 4px;
    }

    /* Increase DataTables search input size */
    div.dataTables_filter {
  float: right;
}

div.dataTables_filter input {
  width: 500px !important;  /* ⬅️ adjust width as needed */
  height: 30px !important;
  font-size: 16px !important;
  font-family: 'Quicksand', sans-serif;
  border-radius: 0 !important;
  border: 2px solid black !important;
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
            <h1 class="h3 mb-0 text-black">Create Class</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./" class="text-orange">Home</a></li>
              <li class="breadcrumb-item active text-black" aria-current="page">Create Class</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-black">Create Class</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Class Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="className" value="<?php echo $row['className'];?>" placeholder="Class Name">
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

              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-black">All Classes</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $query = "SELECT * FROM tblclass";
                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn=0;
                          if($num > 0) {
                            while ($rows = $rs->fetch_assoc()) {
                              $sn++;
                              echo "
                              <tr>
                                <td>".$sn."</td>
                                <td>".$rows['className']."</td>
                                <td>
                                  <a href='?action=edit&Id=".$rows['Id']."' class='text-success'>
                                    <i class='fas fa-fw fa-edit action-icon'></i>Edit
                                  </a>
                                </td>
                                <td>
                                  <a href='?action=delete&Id=".$rows['Id']."' class='text-danger'>
                                    <i class='fas fa-fw fa-trash action-icon'></i>Delete
                                  </a>
                                </td>
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
              </div> <!-- End Row -->
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
