<?php 
include 'Includes/dbcon.php';
session_start();
$error = ""; // to store error messages
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AMS - Login</title>

    <!-- Google Fonts (updated) -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom right, #FFD400, #FFDD3C, #FFEA61, #FFF192, #FFFFB7);
            font-family: 'Quicksand', sans-serif;
            color: black;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            border: 1px solid black;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            background-color: white;
            border-radius: 0;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            margin-top: 10px;
        }

        h5 {
            text-align: center;
            font-size: 24px;
            margin: 0;
        }

        .login-box img {
            display: block;
            margin: 15px auto;
            width: 100px;
            height: 100px;
        }

        form > div {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            height: 42px;
            padding: 10px;
            border: 1px solid black;
            border-radius: 0;
            background: white;
            color: black;
            font-family: 'Quicksand', sans-serif;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            height: 42px;
            padding: 10px;
            border: 1px solid black;
            background-color: white;
            color: black;
            cursor: pointer;
            border-radius: 0;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: black;
            color: white;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .checkbox-container input[type="checkbox"] {
            margin-right: 8px;
        }

        .error-message {
            margin-top: 20px;
            text-align: center;
            background-color: red;
            color: white;
            padding: 10px 15px;
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <!-- Institute Name -->
        
        <img src="img/logo/logo.png" alt="Institute Logo">
        <h1>Login Panel</h1>

        <form method="post" action="">
            <div>
                <select required name="userType">
                    <option value="">--Select User Roles--</option>
                    <option value="Administrator">Administrator</option>
                    <option value="ClassTeacher">ClassTeacher</option>
                </select>
            </div>
            <div>
                <input type="text" required name="username" placeholder="Enter Email Address">
            </div>
            <div>
                <input type="password" required name="password" placeholder="Enter Password">
            </div>
            <br>
            <div>
                <input type="submit" value="Login" name="login">
            </div>

            <p style="text-align: center; font-size: 14px; margin-top: 10px; color: #555;">&copy; 2025, GDF Labs</p>
        </form>
    </div>

    <?php
    if(isset($_POST['login'])){
        $userType = $_POST['userType'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        if($userType == "Administrator"){
            $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
            $rs = $conn->query($query);
            if($rs->num_rows > 0){
                $rows = $rs->fetch_assoc();
                $_SESSION['userId'] = $rows['Id'];
                $_SESSION['firstName'] = $rows['firstName'];
                $_SESSION['lastName'] = $rows['lastName'];
                $_SESSION['emailAddress'] = $rows['emailAddress'];
                echo "<script>window.location = 'Admin/index.php';</script>";
            } else {
                $error = "Invalid Username/Password!";
            }
        } else if($userType == "ClassTeacher"){
            $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
            $rs = $conn->query($query);
            if($rs->num_rows > 0){
                $rows = $rs->fetch_assoc();
                $_SESSION['userId'] = $rows['Id'];
                $_SESSION['firstName'] = $rows['firstName'];
                $_SESSION['lastName'] = $rows['lastName'];
                $_SESSION['emailAddress'] = $rows['emailAddress'];
                $_SESSION['classId'] = $rows['classId'];
                $_SESSION['classArmId'] = $rows['classArmId'];
                echo "<script>window.location = 'ClassTeacher/index.php';</script>";
            } else {
                $error = "Invalid Username/Password!";
            }
        } else {
            $error = "Invalid Username/Password!";
        }
    }

    if (!empty($error)) {
        echo "<div class='error-message'>$error</div>";
    }
    ?>
</body>
</html>
