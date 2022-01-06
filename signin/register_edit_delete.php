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
    $employee_id_edit = $_SESSION['employee_id'];
}

if (isset($_POST['reg_user'])) { {
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);

        if (($_POST['role']) <> "") {
            $role = mysqli_real_escape_string($conn, $_POST['role']);
        } else {
            $role = mysqli_real_escape_string($conn, $_POST['role_default']);
            echo $role;
        }
    }
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $my_arr = array('employee_id' => $employee_id, 'first_name' => $first_name, 'last_name' => $last_name, 'role' => $role, 'phone' => $phone, 'email' => $email);
    $remark =  mysqli_real_escape_string($conn, $_POST['remark']);

    if (empty($username)) {
        array_push($errors, "Username is required");
        $_SESSION['error'] = "Username is required";
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
        $_SESSION['error'] = "Email is required";
    }

    if (count($errors) == 0) {

        echo $employee_id;

        $sql = "UPDATE tb_mas_employees SET first_name='$first_name', last_name='$last_name', phone='$phone', email='$email', role='$role' WHERE employee_id = '$employee_id'";
        mysqli_query($conn, $sql);
        if ($sql) {
            $sql2 = "INSERT INTO tb_employee_log(employee_id, activity, remark, create_date, create_by) VALUES ('$employee_id','edit', '$remark','$create_date', '$employee_id_edit')";
            mysqli_query($conn, $sql2);
            header('location: ../management/employees.php');
        }
    } else {
        header("location: register.php");
    }
}
if (isset($_GET['employee_id'])) {
    echo "1";
    $employee_id = $_GET['employee_id'];
    $sql = "DELETE  FROM tb_mas_employees WHERE employee_id = '$employee_id'";
    
    mysqli_query($conn, $sql);

    header('location: ../management/employees.php');
}
