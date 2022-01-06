<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
echo '
<script src="./inc/jquery.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="inc/jquery.autocomplete.js" type="text/javascript"></script>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Customer</title>
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
                                    <h3 class="text-center font-weight-light my-4">Create Customer</h3>
                                </div>
                                <div class="card-body">
                                    <form action="customer_add_db.php" method="post">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputCustomer" type="text" name="customer_id" placeholder="Enter Customer ID" required minlength="3" />
                                                    <label for="inputFirstName">Customer ID</label>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="number" name="face_id" placeholder="Enter Face ID"  min="1" max="2000"/>
                                                    <label for="inputLastName">Face ID</label>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select onchange="myfunction();" class="form-control" name="role" required minlength="3" id="role">
                                                        <option value=""> -------------------SELECT-------------------</option>
                                                        <option value="owner">owner</option>
                                                        <option value="pa">pa</option>
                                                    </select>
                                                    <label for="inputLastName">Role</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="owner" type="text" name="pa_owner" placeholder="Enter last name" required minlength="3" disabled="true" />
                                                    <label for="inputLastName">Owner</label>
                                                </div>

                                            </div>
                                            <script>
                                                function myfunction() {
                                                    if (document.getElementById("role").value === "pa") {
                                                        document.getElementById("owner").disabled = false;
                                                        document.getElementById("owner").require = true;
                                                    } else {
                                                        document.getElementById("owner").disabled = true;
                                                        document.getElementById("owner").value = '';
                                                        document.getElementById("owner").require = false;
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" type="text" name="first_name" placeholder="Enter first name" required minlength="3" />
                                                    <label for="inputFirstName">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="text" name="last_name" placeholder="Enter last name" required minlength="3" />
                                                    <label for="inputLastName">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" type="tel" name="phone" placeholder="Enter phone number" required minlength="10" />
                                                    <label for="inputFirstName">PHONE</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="email" name="email" placeholder="Enter email" required minlength="10" />
                                                    <label for="inputLastName">Email</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <textarea class="form-control" name="address" rows="10" cols="60" placeholder="Enter address"> </textarea>
                                                    <label for="inputFirstName">ADDRESS</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="text" name="card_id" placeholder="Enter Card ID" />
                                                    <label for="inputCardID">ID card / Passport</label>
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
                                                <button type="submit" name="reg_user" class="btn btn-primary btn-block">Create Customer</button>
                                                <!-- <a class="btn btn-primary btn-block" href="login.html">Create Account</a> -->
                                            </div>
                                        </div>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a href="../index.php">Dashboard</a></div>
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
    <script>
        var province = ["ABC", "DBA"];

        $('#province_auto').autocomplete({
            source: [province],
            limit: 10
        });
    </script>
    <?php include('../inc/footer.php'); ?>
    <script src="../inc/jquery.js"></script>