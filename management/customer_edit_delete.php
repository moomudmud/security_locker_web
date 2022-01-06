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

if (isset($_POST['reg_user'])) { {
        $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);

        if (($_POST['role']) <> "") {
            $role = mysqli_real_escape_string($conn, $_POST['role']);
            if ($_POST['role'] == 'pa') {
                $pa_owner = mysqli_real_escape_string($conn, $_POST['pa_owner']);
            } else {
                $pa_owner = "";
            }
        } else {
            $role = mysqli_real_escape_string($conn, $_POST['role_default']);
            echo $role;
        }
    }
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $remark =  mysqli_real_escape_string($conn, $_POST['remark']);

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


    if (count($errors) == 0) {


        $sql = "UPDATE tb_mas_customers SET first_name='$first_name', last_name='$last_name', 
                        phone='$phone', email='$email', role='$role', face_id = '$face_id', pa_owner='$pa_owner', card_id='$card_id', address='$address'   
                WHERE customer_id = '$customer_id'";
        mysqli_query($conn, $sql);

        if ($sql) {
            $sql2 = "INSERT INTO tb_customer_log(customer_id, activity, remark, create_date, create_by) VALUES ('$customer_id','edit', '$remark','$create_date', '$employee_id')";
            mysqli_query($conn, $sql2);
            header('location: ../management/customers.php');
        }
        
    } else {
        header("location: register.php");
    }
}
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];
    $sql = "DELETE  FROM tb_mas_customers WHERE customer_id = '$customer_id'";
    mysqli_query($conn, $sql);
    echo $customer_id;

}
