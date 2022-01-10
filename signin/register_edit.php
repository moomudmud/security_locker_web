<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
?>

<?php
if (isset($_GET['employee_id'])) {

    $employee_id = $_GET['employee_id'];
    //echo $employee_id . "<br>";

    $Query = "SELECT * FROM tb_mas_employees WHERE (employee_id     LIKE '$employee_id')";
    $result = mysqli_query($conn, $Query) or die("database error:" . mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register - DDK Report</title>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Edit Account</h3>
                                </div>
                                <div class="card-body">
                                    <form action="register_edit_delete.php" method="post">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputEmployeeID" type="text" name="employee_id" placeholder="Enter employee ID" required minlength="3" value="<?= $row['employee_id']; ?>" readonly="readonly" />
                                                    <label for="inputFirstName">Employee ID</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control" name="role" id="role">
                                                        <option value=""> --------------SELECT CHANGE--------------</option>
                                                        <option value="superadmin">Super admin</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="staff">Staff</option>
                                                    </select>
                                                    <label for="inputLastName">Role(default): <?= $row['role']; ?></label>
                                                    <input type="hidden" name="role_default" placeholder="Enter first name" value="<?= $row['role']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" type="text" name="first_name" placeholder="Enter first name" required minlength="3" value="<?= $row['first_name']; ?>" />
                                                    <label for="inputFirstName">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="text" name="last_name" placeholder="Enter last name" required minlength="3" value="<?= $row['last_name']; ?>" />
                                                    <label for="inputLastName">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" type="tel" name="phone" placeholder="Enter phone number" required minlength="10" value="<?= $row['phone']; ?>" />
                                                    <label for="inputFirstName">PHONE</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="email" name="email" placeholder="Enter email" required minlength="10" value="<?= $row['email']; ?>" />
                                                    <label for="inputLastName">Email</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" type="password" name="password_1" readonly="readonly" />
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" type="password" name="password_2" readonly="readonly" />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <textarea class="form-control" name="remark" rows="15" cols="60" placeholder="Enter address" required minlength="3"></textarea>
                                                    <label for="inputFirstName">Remark</label>
                                                </div>

                                            </div>


                                        </div>

                                        <?php if (isset($_SESSION['error'])) : ?>
                                            <div class="error">
                                                <h6 class="text-danger">
                                                    <?php
                                                    echo $_SESSION['error'];
                                                    unset($_SESSION['error']);
                                                    ?>
                                                </h6>
                                            </div>
                                        <?php endif ?>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" name="reg_user" class="btn btn-primary btn-block">Edit Account</button>
                                                <!-- <a class="btn btn-primary btn-block" href="login.html">Create Account</a> -->
                                            </div>
                                        </div>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a href="../index.php">Home</a></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include('../inc/footer.php'); ?>