<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// SAVE
if(isset($_POST['save'])){
    $sessionName=$_POST['sessionName'];
    $termId=$_POST['termId'];
    $dateCreated=date("Y-m-d");
    $query=mysqli_query($conn,"SELECT * FROM tblsessionterm WHERE sessionName='$sessionName' AND termId='$termId'");
    $ret=mysqli_fetch_array($query);
    if($ret > 0){
        $statusMsg="<div class='alert alert-danger' style='margin-right:700px;'>This Session and Term Already Exists!</div>";
    } else {
        $query=mysqli_query($conn,"INSERT INTO tblsessionterm(sessionName,termId,isActive,dateCreated) VALUES('$sessionName','$termId','0','$dateCreated')");
        $statusMsg = $query ?
            "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>" :
            "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
}

// EDIT
if(isset($_GET['Id'],$_GET['action']) && $_GET['action']=="edit"){
    $Id=$_GET['Id'];
    $query=mysqli_query($conn,"SELECT * FROM tblsessionterm WHERE Id='$Id'");
    $row=mysqli_fetch_array($query);
    if(isset($_POST['update'])){
        $sessionName=$_POST['sessionName'];
        $termId=$_POST['termId'];
        $query=mysqli_query($conn,"UPDATE tblsessionterm SET sessionName='$sessionName', termId='$termId', isActive='0' WHERE Id='$Id'");
        echo $query ?
            "<script>window.location='createSessionTerm.php';</script>" :
            ($statusMsg="<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>");
    }
}

// DELETE
if(isset($_GET['Id'], $_GET['action']) && $_GET['action']=="delete"){
    $Id=$_GET['Id'];
    $query=mysqli_query($conn,"DELETE FROM tblsessionterm WHERE Id='$Id'");
    echo $query ?
        "<script>window.location='createSessionTerm.php';</script>" :
        ($statusMsg="<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>");
}

// ACTIVATE
if(isset($_GET['Id'], $_GET['action']) && $_GET['action']=="activate"){
    $Id=$_GET['Id'];
    mysqli_query($conn,"UPDATE tblsessionterm SET isActive='0' WHERE isActive='1'");
    $que=mysqli_query($conn,"UPDATE tblsessionterm SET isActive='1' WHERE Id='$Id'");
    echo $que ?
        "<script>window.location='createSessionTerm.php';</script>" :
        ($statusMsg="<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Create Session and Term</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

<!-- CSS -->
<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="css/ruang-admin.min.css" rel="stylesheet">
<link rel="icon" href="img/logo/attnlg.jpg">

<style>
  body, input, select, textarea {
    font-family: 'Quicksand', sans-serif !important;
  }
  h1, h2, h3, h4, h5, h6, .btn ,.tabs{
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
  .text-black { color: #000 !important; }
  .text-orange { color: orange !important; }
  a.text-success, a.text-danger { font-weight: bold; }
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
          <h1 class="h3 mb-0 text-black">Create Session and Term</h1>
          <div class="tabs">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-orange" href="./">Home</a></li>
            <li class="breadcrumb-item active text-black">Create Session and Term</li>
          </ol></div>
        </div>

        <!-- Form card -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-header d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-black">Create Session and Term</h6>
                <?php echo $statusMsg; ?>
              </div>
              <div class="card-body">
                <form method="post">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Session Name<span class="text-danger ml-2">*</span></label>
                      <input type="text" name="sessionName" class="form-control" value="<?php echo $row['sessionName'];?>" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Term<span class="text-danger ml-2">*</span></label>
                      <select name="termId" class="form-control" required>
                        <option value="">--Select Term--</option>
                        <?php
                          $res = $conn->query("SELECT * FROM tblterm ORDER BY termName ASC");
                          while($r = $res->fetch_assoc()){
                            $sel = ($row['termId']==$r['Id']) ? 'selected':''; 
                            echo "<option value='{$r['Id']}' {$sel}>{$r['termName']}</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <?php if(isset($Id)){ ?>
                    <button name="update" type="submit" class="btn btn-warning">Update</button>
                  <?php } else { ?>
                    <button name="save" type="submit" class="btn btn-primary">Save</button>
                  <?php } ?>
                </form>
              </div>
            </div>

            <!-- Table card -->
            <div class="card mb-4">
              <div class="card-header d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-black">All Session and Term</h6>
                <h6 class="m-0 font-weight-bold text-danger">
                  Note: <i>Click on the check icon to activate.</i>
                </h6>
              </div>
              <div class="table-responsive p-3">
                <table class="table table-hover" id="dataTableHover">
                  <thead class="thead-light">
                    <tr>
                      <th>#</th><th>Session</th><th>Term</th><th>Status</th><th>Date</th><th>Activate</th><th>Edit</th><th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $q = "SELECT sts.Id, sts.sessionName, sts.termId, sts.isActive, sts.dateCreated, t.termName
                            FROM tblsessionterm sts
                            JOIN tblterm t ON t.Id=sts.termId
                            ORDER BY sts.dateCreated DESC";
                      $rs = $conn->query($q);
                      $sn=1;
                      while($r = $rs->fetch_assoc()){
                        $status = $r['isActive']==1 ? 'Active' : 'InActive';
                        echo "<tr>
                          <td>{$sn}</td>
                          <td>{$r['sessionName']}</td>
                          <td>{$r['termName']}</td>
                          <td>{$status}</td>
                          <td>{$r['dateCreated']}</td>
                          <td><a class='text-success' href='?action=activate&Id={$r['Id']}'><i class='fas fa-fw fa-check text-success'></i></a></td>
                          <td><a class='text-success' href='?action=edit&Id={$r['Id']}'><i class='fas fa-fw fa-edit text-success'></i></a></td>
                          <td><a class='text-danger' href='?action=delete&Id={$r['Id']}'><i class='fas fa-fw fa-trash text-danger'></i></a></td>
                        </tr>";
                        $sn++;
                      }
                      if($rs->num_rows==0){
                        echo "<tr><td colspan='8' class='text-center'>No Record Found!</td></tr>";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>

      </div>
      <?php include "Includes/footer.php";?>
    </div>
  </div>
</div>

<a href="#page-top" class="scroll-to-top rounded"><i class="fas fa-angle-up"></i></a>

<!-- JS assets -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/ruang-admin.min.js"></script>
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
  $(function(){ $('#dataTableHover').DataTable(); });
</script>
</body>
</html>
