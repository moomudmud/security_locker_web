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
    $create_by = $_SESSION['employee_id'];
    echo $create_by;
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
    if (empty($_POST['pa1_id'])) {
        $pa1_id = "";
    } else {
        $pa1_id = mysqli_real_escape_string($conn, $_POST['pa1_id']);
    }
    if (empty($_POST['pa2_id'])) {
        $pa2_id = "";
    } else {
        $pa2_id = mysqli_real_escape_string($conn, $_POST['pa2_id']);
    }

    if (isset($_POST['is_duo'])) {
        $is_duo = "true";
    } else {
        $is_duo = "false";
    }

    if (isset($_POST['locker'])) {
        $value = $_POST['locker'];
        $myArray = explode(',', $value);
        $locker_id = $myArray[0];
        $locker_name = $myArray[1];
    }

    if (empty($_POST['mirefare_id'])) {
        $mirefare_id = "";
    } else {
        $mirefare_id = mysqli_real_escape_string($conn, $_POST['mirefare_id']);
    }

    $booking_type = mysqli_real_escape_string($conn, $_POST['booking_type']);

    if (isset($_POST['booking_type'])) {
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    }


    $user_check_query = "SELECT * FROM tb_tn_booking WHERE booking_id = '$booking_id'LIMIT 1";
    $query = mysqli_query($conn, $user_check_query);
    $result = mysqli_fetch_assoc($query);
    if ($result) { // if user exists
        if ($result['booking_id'] === $booking_id) {
            echo '<script>
                setTimeout(function() {
                 swal({
                     title: "Duplicate data",  
                     text: "Duplicate Customer ID.",
                     type: "warning"
                 }, function() {
                     window.location = "../transaction/booking.php"; //หน้าที่ต้องการให้กระโดดไป
                 });192
               }, 1000);
         </script>';
        }
    }
    if (count($errors) == 0) {

        try {
            echo $booking_type;

            $sql = "INSERT INTO tb_tn_booking(booking_id, customer_id, pa1_id, pa2_id, is_duo, locker_id, locker_name, booking_type, start_date, end_date, mirefare_id, remark, status_id, status_name, create_date, create_by) 
            VALUES ('$booking_id', '$customer_id', '$pa1_id', '$pa2_id', $is_duo, $locker_id, '$locker_name', '$booking_type', curdate(), curdate(), '$mirefare_id', 'remark', 1, 'booking', curdate(), '$create_by')";
            $query = mysqli_query($conn, $sql);
        } catch (Exception $e) {

            echo "Caught exception : <b>" . $e->getMessage() . "</b><br/>";
        }
        if ($query) {
            $sql = "UPDATE tb_mas_lockers SET is_empty=0 WHERE locker_id = '$locker_id'";
            $query = mysqli_query($conn, $sql);

            $sql2 = "INSERT INTO tb_booking_log(booking_id, activity, period, start_date, end_date, create_date, create_by) VALUES ('$booking_id','add','$booking_type','$start_date','$end_date','$create_date', '$employee_id_add')";
            mysqli_query($conn, $sql2);

            header('location: ../transaction/booking.php');
        }
        //header('location: ../management/customers.php');
    } else {
        //header('location: ../management/customers.php');
        echo 1;
    }
}
