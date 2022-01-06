<?php
echo '
 <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
session_start();
include('../inc/server.php');
$errors = array();
date_default_timezone_set('Asia/Bangkok');
$create_date = date("Y-m-d H:i:s");

if (isset($_SESSION['employee_id'])) {
    $employee_id_add = $_SESSION['employee_id'];
}

if (isset($_POST['reg_user'])) {
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
    $my_arr = array('employee_id' => $employee_id, 'first_name' => $first_name, 'last_name' => $last_name, 'role' => $role, 'phone' => $phone, 'email' => $email, 'password_1' => $password_1, 'password_2' => $password_2);
    if (empty($username)) {
        array_push($errors, "Username is required");
        $_SESSION['error'] = "Username is required";
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
        $_SESSION['error'] = "Email is required";
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
        $_SESSION['error'] = "Password is required";
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
        $_SESSION['error'] = "The two passwords do not match";
    }

    $user_check_query = "SELECT * FROM tb_mas_employees WHERE employee_id = '$employee_id'LIMIT 1";
    $query = mysqli_query($conn, $user_check_query);
    $result = mysqli_fetch_assoc($query);
    if ($result) { // if user exists
        if ($result['employee_id'] === $employee_id) {
            echo '<script>
                setTimeout(function() {
                 swal({
                     title: "Duplicate data",  
                     text: "Duplicate employee ID.",
                     type: "warning"
                 }, function() {
                     window.location = "register.php"; //หน้าที่ต้องการให้กระโดดไป
                 });
               }, 1000);
         </script>';
        }
    }
    if (count($errors) == 0) {

        $password = md5($password_1);
        echo $employee_id;

        $sql = "INSERT INTO tb_mas_employees(employee_id, first_name, last_name, phone, email, password, role, face_id, is_active) VALUES ('$employee_id', '$first_name', '$last_name', '$phone', '$email', '$password', '$role', 0,1 )";
        mysqli_query($conn, $sql);

        if ($sql) {
            $sql2 = "INSERT INTO  tb_employee_log(employee_id, activity, create_date, create_by) VALUES ('$employee_id','add','$create_date', '$employee_id_add')";
            mysqli_query($conn, $sql2);
            header('location: ../management/employees.php');
        }
    } else {
        header("location: register.php");
    }
}
