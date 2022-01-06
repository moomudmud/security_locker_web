<?php
include('../inc/server.php');
$sql = "SELECT * FROM tb_mas_customers";
$query = mysqli_query($conn, $sql);
echo '
<script src="./inc/jquery.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="inc/jquery.autocomplete.js" type="text/javascript"></script>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    <link type="text/css" rel="stylesheet" href="jquery.autocomplete.css" />
    <script type="text/javascript" src="jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="jquery.autocomplete.js"></script>
    <script type="text/javascript">
        var states = [
            <?php
            $province = "";
            while ($result = mysqli_fetch_array($query)) {
                $province .= "'" . $result['customer_id'] . "',";
            }
            echo rtrim($province, ",");
            ?>
        ];
        $(function() {
            $("#input").autocomplete({
                source: [states]
            });
        });
    </script>
</head>

<body>
    <input id="input" placeholder="กรอกจังหวัด">


</body>

</html>