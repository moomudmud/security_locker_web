<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
echo '
<script src="./inc/jquery.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="inc/jquery.autocomplete.js" type="text/javascript"></script>';
?>

<?php
if (isset($_GET['booking_id'])) {

    $booking_id = $_GET['booking_id'];

    $Query = "SELECT * FROM tb_tn_booking WHERE (booking_id    LIKE '$booking_id')";
    $result = mysqli_query($conn, $Query) or die("database error:" . mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Review</title>
    <script type="text/javascript">
        $(function() {

            var date_today = "<?php
                                $date = date('Y-m-d');
                                echo $date;
                                ?>";
            var weekly = "<?php
                            $date = date_create(date('Y-m-d'));
                            date_add($date, date_interval_create_from_date_string('7 days'));
                            echo date_format($date, 'Y-m-d');
                            ?>";
            var monthly = "<?php
                            $date = date_create(date('Y-m-d'));
                            date_add($date, date_interval_create_from_date_string('30 days'));
                            echo date_format($date, 'Y-m-d');
                            ?>";
            var yearly = "<?php
                            $date = date_create(date('Y-m-d'));
                            date_add($date, date_interval_create_from_date_string('365 days'));
                            echo date_format($date, 'Y-m-d');
                            ?>";

            $("input[name='booking_type']").click(function() {
                if ($("#weekly").is(":checked")) {
                    $("#start_date_check").removeAttr("disabled");
                    $("#end_date_check").removeAttr("disabled");

                    $("#start_date_check").attr("value", date_today);
                    $("#end_date_check").attr("value", weekly);

                } else if ($("#monthly").is(":checked")) {
                    $("#start_date_check").removeAttr("disabled");
                    $("#end_date_check").removeAttr("disabled");

                    $("#start_date_check").attr("value", date_today);
                    $("#end_date_check").attr("value", monthly);
                } else if ($("#yearly").is(":checked")) {
                    $("#start_date_check").removeAttr("disabled");
                    $("#end_date_check").removeAttr("disabled");

                    $("#start_date_check").attr("value", date_today);
                    $("#end_date_check").attr("value", yearly);
                }

            });
        });
    </script>
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
                                    <h3 class="text-center font-weight-light my-4">Review</h3>
                                </div>
                                <div class="card-body">
                                    <form action="booking_edit_db.php" method="post">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="booking_id" type="text" name="booking_id" value="<?= $row['booking_id']; ?> " readonly="true" />
                                                    <label for="inputBooking_id">Booking ID</label>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="customer_id" type="text" name="customer_id" value="<?= $row['customer_id']; ?> " readonly="true" />

                                                    <label for="inputCustomer_id">Customer ID</label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="pa1_id" type="text" name="pa1_id" value="<?= $row['pa1_id']; ?> " readonly="true" />
                                                    <label for="inputPA1">PA1</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="pa2_id" type="text" name="pa2_id" value="<?= $row['pa2_id']; ?> " readonly="true" />
                                                    <label for="inputPA2">PA2</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input type="checkbox" onclick="myFunction()" id="myCheck" name="is_duo" <?php if ($row['is_duo'] == true) {
                                                                                                                                    echo 'checked=""';
                                                                                                                                } ?>>&nbsp&nbspAcceess Duo</label>

                                                    <script>
                                                        function myFunction() {
                                                            var x = document.getElementById("myCheck").checked;
                                                            document.getElementById("demo").innerHTML = x;
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="locker_name" type="text" name="locker_name" value="<?= $row['locker_name']; ?> " readonly="true" />
                                                    <label for="inputLastName">Locker</label>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="mirefare_id" type="text" name="mirefare_id" value="<?= $row['mirefare_id']; ?>" readonly="true" />
                                                    <label for="inputCardID">Mirefare card ID</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

                                                <span>Period</span>
                                                <label for="weekly">
                                                    <input type="radio" id="weekly" name="booking_type" value="weekly" <?php if ($row['booking_type'] == "weekly") {
                                                                                                                            echo 'checked=""';
                                                                                                                        } ?> />
                                                    Weekly
                                                </label>
                                                <label for="monthly">
                                                    <input type="radio" id="monthly" name="booking_type" value="monthly" <?php if ($row['booking_type'] == "monthly") {
                                                                                                                                echo 'checked=""';
                                                                                                                            } ?> />
                                                    Monthly
                                                </label>
                                                <label for="yearly">
                                                    <input type="radio" id="yearly" name="booking_type" value="yearly" <?php if ($row['booking_type'] == "yearly") {
                                                                                                                            echo 'checked=""';
                                                                                                                        } ?> />
                                                    Yearly
                                                </label>
                                                <hr />

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="start_date_check" type="date" name="start_date" value="<?= $row['start_date']; ?>" />
                                                    <label for="inputFirstName">Start date</label>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="end_date_check" type="date" name="end_date" value="<?= $row['end_date']; ?>" />
                                                    <label for="inputFirstName">Expire date</label>
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
                                                <button type="submit" name="reg_user" class="btn btn-primary btn-block">EDIT</button>
                                                <!-- <a class="btn btn-primary btn-block" href="login.html">Create Account</a> -->
                                            </div>
                                        </div>
                                        <div class="card-footer text-center py-2">
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