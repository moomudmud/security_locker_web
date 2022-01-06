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
    $employee_id = $_SESSION['employee_id'];
}


if (isset($_POST['reg_user'])) {
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if ($_POST['role'] == 'pa') {
        $pa_owner = mysqli_real_escape_string($conn, $_POST['pa_owner']);
    } else {
        $pa_owner = "";
    }
    if (empty($_POST['address'])) {
        $address = "";
        echo ($address);
    } else {
        $address = mysqli_real_escape_string($conn, $_POST['address']);
    }
    if (empty($_POST['card_id'])) {
        $card_id = "";
    } else {
        $card_id = mysqli_real_escape_string($conn, $_POST['card_id']);
    }
    if (empty($_POST['face_id'])) {
        $face_id = "";
    } else {
        $face_id = mysqli_real_escape_string($conn, $_POST['face_id']);
    }
    //$my_arr = array('customer_id' => $customer_id, 'role' => $role, 'first_name' => $first_name, 'last_name' => $last_name, 'phone' => $phone, 'email' => $email, 'address' => $address, 'card_id' => $card_id);

    $user_check_query = "SELECT * FROM tb_mas_customers WHERE customer_id = '$customer_id'LIMIT 1";
    $query = mysqli_query($conn, $user_check_query);
    $result = mysqli_fetch_assoc($query);
    if ($result) { // if user exists
        if ($result['customer_id'] === $customer_id) {
            echo '<script>
                setTimeout(function() {
                 swal({
                     title: "Duplicate data",  
                     text: "Duplicate Customer ID.",
                     type: "warning"
                 }, function() {
                     window.location = "../management/customers.php"; //หน้าที่ต้องการให้กระโดดไป
                 });
               }, 1000);
         </script>';
        }
    }

    if ($face_id <> "") {
        $user_check_query = "SELECT * FROM tb_mas_customers WHERE face_id = '$face_id'LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        if ($result) { // if user exists
            if ($result['face_id'] === $face_id) {
                echo '<script>
                setTimeout(function() {
                 swal({
                     title: "Duplicate data",  
                     text: "Duplicate Face ID.",
                     type: "warning"
                 }, function() {
                     window.location = "../management/customers.php"; //หน้าที่ต้องการให้กระโดดไป
                 });
               }, 1000);
         </script>';
            }
        }
    }


    if (count($errors) == 0) {
        $sql = "INSERT INTO tb_mas_customers (customer_id, first_name, last_name, phone, email, card_id, address, face_id, role, pa_owner, is_active) VALUES ('$customer_id', '$first_name', '$last_name', '$phone', '$email', '$card_id', '$address', $face_id, '$role', '$pa_owner', 1)";
        mysqli_query($conn, $sql);
        header('location: ../management/customers.php');

        if ($sql) {
            $sql2 = "INSERT INTO tb_customer_log(customer_id, activity, create_date, create_by) VALUES ('$customer_id','add','$create_date', '$employee_id')";
            mysqli_query($conn, $sql2);
            header('location: ../management/customers.php');
        }
    } else {
        header('location: ../management/customers.php');
    }
}
