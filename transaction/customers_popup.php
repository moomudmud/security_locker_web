<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
include('../inc/config.inc.php');


echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

if (($_SESSION['role'] <> 'admin') or empty($_SESSION['employee_id'])) {
    echo '<script>
                setTimeout(function() {
                swal({
                title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
                type: "error"
                }, function() {
                window.location = "/MAC-Web/index.php"; 
                });
                }, 1000);
                </script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Access inside</title>
</head>

<body>
    <form action="" method="get">
        <form action="" method="get">
            <div class="container">
                <div class="row">
                    <h3>Customer Search</h3>
                    <table class="table table-striped  table-hover table-responsive table-bordered">
                        <tr>
                            <td>Customer ID<input type="search" name="customer_id" class="form-control"></td>
                            <td>Name <input type="search" name="first_name" class="form-control"> </td>
                        </tr>

                        <tr>
                            <td>Phone <input type="search" name="phone" class="form-control"></td>
                            <td>ID card / Passport <input type="search" name="car" class="form-control"></td>
                        <tr>
                            <td align='right'><button type="submit" class="btn btn-primary">ค้นหาข้อมูล</button></a></td>
                            <td align='left'><button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;Export&nbsp;&nbsp;&nbsp;&nbsp;</button></a></td>

                        </tr>
                        </tr>
                    </table>
                    <div class="col-md-12"> <br>
                        <table class="table table-striped  table-hover table-responsive table-bordered">
                            <thead>
                    </div>
                    <div class="col-md-12"> <br></div>
                    <tr>
                    <tr>
                    <tr>
                        <th>Customer ID</th>
                        <th>First Name</th>
                        <th>Last name</th>
                        <th>Select</th>

                    </tr>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Query = "SELECT *  FROM tb_mas_customers c";

                        $result = mysqli_query($conn, $Query) or die("database error:" . mysqli_error($conn));
                        while ($row = mysqli_fetch_assoc($result)) {


                        ?>
                            <tr id="1">

                                <td class="row-data">
                                    <?php echo $row['customer_id']; ?>
                                </td>
                                <td class="row-data">
                                    <?php echo $row['first_name']; ?>
                                </td>
                                <td class="row-data">
                                    <?php echo $row['last_name']; ?>
                                </td>
                                <td><input type="button" value="submit" onclick="show()" />
                                </td>
                            </tr>
                        <?php } ?>

                        <script>
                            function show() {
                                var rowId =
                                    event.target.parentNode.parentNode.id;
                                //this gives id of tr whose button was clicked
                                var data =
                                    document.getElementById(rowId).querySelectorAll(".row-data");
                                /*returns array of all elements with 
                                "row-data" class within the row with given id*/

                                var customer_id = data[0].innerHTML;


                                alert("Customer ID: " + customer_id);
                            }
                        </script>
                    </tbody>
                </div>
            </div>
            </div>

        </form>
</body>

</html>