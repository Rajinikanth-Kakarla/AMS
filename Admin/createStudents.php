<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// SAVE
if(isset($_POST['save'])){
    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $otherName=$_POST['otherName'];
    $admissionNumber=$_POST['admissionNumber'];
    $classId=$_POST['classId'];
    $classArmId=$_POST['classArmId'];
    $dateCreated=date("Y-m-d");
    $query=mysqli_query($conn,"SELECT * FROM tblstudents WHERE admissionNumber='$admissionNumber'");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
        $statusMsg="<div class='alert alert-danger' style='margin-right:700px;'>This Admission Number Already Exists!</div>";
    } else {
        $query=mysqli_query($conn,"INSERT into tblstudents(firstName,lastName,otherName,admissionNumber,password,classId,classArmId,dateCreated) VALUES('$firstName','$lastName','$otherName','$admissionNumber','12345','$classId','$classArmId','$dateCreated')");
        $statusMsg = $query 
            ? "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>"
            : "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
}

// EDIT
if(isset($_GET['Id'],$_GET['action']) && $_GET['action']=="edit"){
    $Id=$_GET['Id'];
    $query=mysqli_query($conn,"SELECT * FROM tblstudents WHERE Id='$Id'");
    $row=mysqli_fetch_array($query);
    if(isset($_POST['update'])){
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $otherName=$_POST['otherName'];
        $admissionNumber=$_POST['admissionNumber'];
        $classId=$_POST['classId'];
        $classArmId=$_POST['classArmId'];
        $query=mysqli_query($conn,"UPDATE tblstudents SET firstName='$firstName', lastName='$lastName', otherName='$otherName', admissionNumber='$admissionNumber', classId='$classId', classArmId='$classArmId' WHERE Id='$Id'");
        echo $query 
            ? "<script>window.location='createStudents.php';</script>"
            : ($statusMsg="<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>");
    }
}

// DELETE
if(isset($_GET['Id'],$_GET['action']) && $_GET['action']=="delete"){
    $Id=$_GET['Id'];
    $query=mysqli_query($conn,"DELETE FROM tblstudents WHERE Id='$Id'");
    echo $query 
        ? "<script>window.location='createStudents.php';</script>"
        : ($statusMsg="<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Create Students</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

<!-- CSS -->
<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="css/ruang-admin.min.css" rel="stylesheet">
<link rel="icon" href="img/logo/logo.png">

<style>
  body, input, select, textarea { font-family: 'Quicksand', sans-serif!important; }
  h1,h6,.btn, .tabs { font-family: 'Orbitron',sans-serif!important; }
  .btn-primary, .btn-warning, .page-item.active .page-link {
    background: linear-gradient(to bottom right,#FFD400,#FFDD3C,#FFEA61,#FFF192,#FFFFB7)!important;
    color:#000!important; border:none!important;
  }
  .btn-primary:hover, .btn-warning:hover {
  background: linear-gradient(to bottom right, #FFEA61, #FFD400, #FFDD3C, #FFF192, #FFFFB7) !important;
  color: #fff !important;
  opacity: 0.9;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
  transition: all 0.3s ease-in-out;
}

  .form-control { border:2px solid black!important; border-radius:0!important; }
  div.dataTables_filter {
  float: right;
}
   
  div.dataTables_filter input {
    width:500px!important; height:30px!important;
    border:2px solid black!important; border-radius:0!important;
  }
  .text-black { color:#000!important; }
  .text-orange { color:orange!important; }
  a.text-success, a.text-danger { font-weight:bold; }
</style>

<script>
function classArmDropdown(str){
  if(!str){ document.getElementById("txtHint").innerHTML=""; return; }
  let xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function(){
    if(this.readyState==4 && this.status==200) document.getElementById("txtHint").innerHTML=this.responseText;
  };
  xmlhttp.open("GET","ajaxClassArms2.php?cid="+str,true);
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

      <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
          <h1 class="h3 text-black mb-0">Create Students</h1>
          <div class="tabs">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-orange" href="./">Home</a></li>
            <li class="breadcrumb-item active text-black" aria-current="page">Create Students</li>
          </ol></div>
        </div>

        <!-- Form Card -->
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-black">Create Students</h6>
            <?php echo $statusMsg; ?>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Firstname *</label>
                  <input type="text" class="form-control" name="firstName" value="<?php echo $row['firstName'];?>">
                </div>
                <div class="form-group col-md-4">
                  <label>Lastname *</label>
                  <input type="text" class="form-control" name="lastName" value="<?php echo $row['lastName'];?>">
                </div>
                <div class="form-group col-md-4">
                  <label>Other Name *</label>
                  <input type="text" class="form-control" name="otherName" value="<?php echo $row['otherName'];?>">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Admission Number *</label>
                  <input type="text" class="form-control" name="admissionNumber" required value="<?php echo $row['admissionNumber'];?>">
                </div>
                <div class="form-group col-md-3">
                  <label>Class *</label>
                  <select name="classId" onchange="classArmDropdown(this.value)" class="form-control">
                    <option value="">--Select Class--</option>
                    <?php
                      $res=$conn->query("SELECT * FROM tblclass ORDER BY className ASC");
                      while($r=$res->fetch_assoc()){
                        $sel = ($row['classId']==$r['Id'])?'selected':'';
                        echo "<option value='{$r['Id']}' {$sel}>{$r['className']}</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label>Section *</label>
                  <div id="txtHint"></div>
                </div>
              </div>
              <?php if(isset($Id)){ ?>
              <button type="submit" name="update" class="btn btn-warning">Update</button>
              <?php } else {?>
              <button type="submit" name="save" class="btn btn-primary">Save</button>
              <?php } ?>
            </form>
          </div>
        </div>

        <!-- Table Card -->
        <div class="card mb-4">
          <div class="card-header">
            <h6 class="m-0 font-weight-bold text-black">All Students</h6>
          </div>
          <div class="table-responsive p-3">
            <table class="table table-hover" id="dataTableHover">
              <thead class="thead-light">
                <tr><th>#</th><th>First</th><th>Last</th><th>Other</th><th>Admission</th><th>Class</th><th>Section</th><th>Date</th><th>Edit</th><th>Delete</th></tr>
              </thead>
              <tbody>
                <?php
                  $q="SELECT s.Id, s.firstName, s.lastName, s.otherName, s.admissionNumber, c.className, ca.classArmName, s.dateCreated
                      FROM tblstudents s
                      JOIN tblclass c ON c.Id=s.classId
                      JOIN tblclassarms ca ON ca.Id=s.classArmId";
                  $rs=$conn->query($q);
                  $sn=1;
                  while($r=$rs->fetch_assoc()){
                    echo "
                      <tr>
                        <td>{$sn}</td><td>{$r['firstName']}</td><td>{$r['lastName']}</td><td>{$r['otherName']}</td>
                        <td>{$r['admissionNumber']}</td><td>{$r['className']}</td><td>{$r['classArmName']}</td><td>{$r['dateCreated']}</td>
                        <td><a class='text-success' href='?action=edit&Id={$r['Id']}'><i class='fas fa-edit text-success'></i> Edit</a></td>
                        <td><a class='text-danger' href='?action=delete&Id={$r['Id']}'><i class='fas fa-trash text-danger'></i> Delete</a></td>
                      </tr>";
                    $sn++;
                  }
                  if($rs->num_rows==0){
                    echo "<tr><td colspan='10' class='text-center'>No Record Found!</td></tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>
</div>

<a href="#page-top" class="scroll-to-top rounded"><i class="fas fa-angle-up"></i></a>

<!-- JS -->
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
