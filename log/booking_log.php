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
                title: "Dont have permission to access.",
                type: "error"
                }, function() {
                window.location = "/security_locker_web/index.php"; 
                });
                }, 1000);
                </script>';
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: signin/login.php');
}


$errors = array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Booking log</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../index.php">SECURITY LOCKER</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <form action="" method="get">
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../index.php?logout='1'">Logout</a></li>
                    </ul>
                </li>
            </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="../index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Home
                        </a>
                        <div class="sb-sidenav-menu-heading">Transaction</div>
                        <a class="nav-link" href="../transaction/booking.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Booking
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDepartment" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            <?php if (($_SESSION['role'] ==  'admin')) {
                                echo $menu1;
                            } ?>
                            <!-- AS1 -->
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDepartment" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../management/employees.php">Employees</a>
                                <a class="nav-link" href="../management/customers.php">Customer</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDepartment" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            <?php echo $menu2; ?>
                            <!-- AS1 -->
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDepartment" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../log/employees_log.php">Employees Log</a>
                                <a class="nav-link" href="../log/customers_log.php">Customers Log</a>
                                <a class="nav-link" href="../log/booking_log.php">Booking Log</a>
                                <a class="nav-link" href="../log/access_log.php">Access Log</a>
                                <a class="nav-link" href="../log/breaking_log.php">Breaking Log</a>
                            </nav>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
                        Role: <?php echo $_SESSION['role']; ?><br>
                    </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Booking log</h1>
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                        <li class="breadcrumb-item active">Booking log</li>
                    </ol>
                    <div style="overflow-x:auto;">
                        <table class="table table-striped  table-hover table-responsive table-bordered">
                            <tr>
                                <td>Booking ID<input type="search" name="booking_id" class="form-control"></td>
                                <td>Employee <input type="search" name="employee_id" class="form-control"> </td>
                            </tr>

                            <td align='right'><button type="submit" class="btn btn-primary">?????????????????????????????????</button></a></td>
                            <td align='left'><button type="button" class="btn btn-primary dataExport" data-type="excel" data-filename="booking_log">Export XLS</button></a></td>

                            </tr>
                            </tr>


                        </table>
                        <table id="dataTable" class="table table-striped">
                            <thead style="vertical-align: top;">
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Activity</th>
                                    <th>Period</th>
                                    <th>Start date</th>
                                    <th>Expire Date</th>
                                    <th>Operator</th>
                                    <th>Create Date</th>
                                    <th>Comment</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php

                                if (isset($_GET['booking_id'])) {
                                    $booking_id = "%{$_GET['booking_id']}%";
                                    $employee_id = "%{$_GET['employee_id']}%";

                                    $Query = "SELECT * FROM tb_booking_log l
                                              WHERE (l.booking_id     LIKE '$booking_id' OR '$booking_id' IS NULL)
                                              AND   (l.create_by     LIKE '$employee_id' OR '$employee_id' IS NULL)";
                                    $result = mysqli_query($conn, $Query) or die("database error:" . mysqli_error($conn));
                                } else {
                                    $Query = "SELECT * FROM tb_booking_log l";
                                    $result = mysqli_query($conn, $Query) or die("database error:" . mysqli_error($conn));
                                }

                                while ($row = mysqli_fetch_assoc($result)) {


                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['booking_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['activity']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['period'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row['start_date']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['end_date']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['create_by']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['create_date']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['remark']; ?>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
<script src="../tableExport/tableExport.js"></script>
<script type="text/javascript" src="../tableExport/jquery.base64.js"></script>
<script src="../js/export.js"></script>
<?php include('../inc/footer.php'); ?>