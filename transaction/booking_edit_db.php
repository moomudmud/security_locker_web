<?php
echo '
 <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
session_start();
date_default_timezone_set('Asia/Bangkok');
include('../inc/server.php');
$errors = array();
$create_date = date("Y-m-d H:i:s");

if (isset($_SESSION['employee_id'])) {
    $employee_id_edit = $_SESSION['employee_id'];
}

if (isset($_POST['reg_user'])) {
    $create_by = $_SESSION['employee_id'];

    $booking_id = $_POST['booking_id'];
    echo $booking_id;

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

    if (isset($_POST['is_duo']) == true) {
        $is_duo = 1;
    } else {
        $is_duo = 0;
    }


    $booking_type = mysqli_real_escape_string($conn, $_POST['booking_type']);

    if (isset($_POST['booking_type'])) {
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    }

    $remark =  mysqli_real_escape_string($conn, $_POST['remark']);

    $sql = "UPDATE tb_tn_booking SET pa1_id='$pa1_id' ,pa2_id='$pa2_id' ,is_duo = '$is_duo', 
            booking_type = '$booking_type' ,start_date = '$start_date' ,end_date = '$end_date' ,remark='$remark'
            WHERE booking_id = '$booking_id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $sql2 = "INSERT INTO tb_booking_log(booking_id, activity, period, start_date, end_date, remark, create_date, create_by) VALUES ('$booking_id','edit','$booking_type','$start_date','$end_date','$remark','$create_date', '$employee_id_edit')";
        mysqli_query($conn, $sql2);

        header('location: ../transaction/booking.php');
    } else {
        header('location: ../transaction/booking.php');
        echo "Error";
    }





    //header('location: ../management/customers.php');

    //header('location: ../management/customers.php');


}
