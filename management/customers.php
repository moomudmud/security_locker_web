<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
include('../inc/config.inc.php');

echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

if (($_SESSION['role'] <> 'staff') && ($_SESSION['role'] <> 'admin')) {
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
    <title>Customers Management</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">DDK REPORT</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <form action="" method="post">
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
                    <h1 class="mt-4">Customers Management</h1>
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                        <li class="breadcrumb-item active">Customers Management</li>
                    </ol>
                    <div style="overflow-x:auto;">
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
                                <td align='left'><button type="button" class="btn btn-primary dataExport" data-type="excel" data-filename="User Log">Export XLS</button></a></td>

                            </tr>
                            </tr>


                        </table>
                        <table id="dataTable" class="table table-striped">
                            <thead style="vertical-align: top;">
                                <a href="../management/customer_add.php" class="btn btn-success">+ADD </a>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>First Name</th>
                                    <th>Last name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>ID card/Passport</th>
                                    <th>Role</th>
                                    <th>Owner</th>
                                    <th>
                                        <center>Edit</center>
                                    </th>
                                    <th>
                                        <center>Delete</center>
                                    </th>



                            </thead>
                            <tbody>
                                <?php
                                $Query = "SELECT *  FROM tb_mas_customers c";

                                $result = mysqli_query($conn, $Query) or die("database error:" . mysqli_error($conn));
                                while ($row = mysqli_fetch_assoc($result)) {


                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['customer_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['first_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['last_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['phone']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['card_id']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['role']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['pa_owner']; ?>
                                        </td>
                                        <td>
                    
                                            <center><a href="../management/customer_edit.php?customer_id=<?= $row['customer_id']; ?>" class="btn btn-warning btn-sm">EDIT</a></center>
                                        </td>
                                        <td>
                                            <center><a href="../management/customer_edit_delete.php?customer_id=<?= $row['customer_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล !!');">DELETE</a></center>
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