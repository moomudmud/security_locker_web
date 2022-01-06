<?php 
    session_start();
    // include('db_conection.php');
    include('../inc/server.php');
    $errors = array();

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        echo 1;

        if (empty($username)) {
            array_push($errors, "Username is required");
        }

        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM tb_mas_employees WHERE employee_id  = '$username' AND password = '$password' ";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['employee_id'] = $username;
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['success'] = "Your are now logged in";
                header("location: ../index.php");
            } else {
                array_push($errors, "Wrong Username or Password");
                $_SESSION['error'] = "Wrong Username or Password!";
                header("location: login.php");
            }   
        } else {
            array_push($errors, "Username & Password is required");
            $_SESSION['error'] = "Username & Password is required";
            header("location: login.php");
        }
    }

?>
