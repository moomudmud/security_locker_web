<?php

    $menu1 = 'Management';
    $menu2 = 'Log';

    if ($_SESSION['role'] == 'admin') {
        $delete_custome_button = '<center><a href="../management/customer_edit_delete.php?customer_id=<?= $row['.'customer_id'.'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('.'ยืนยันการลบข้อมูล !!'.');">DELETE</a></center>';
        $delete_header = 'Delete';
    }
    else{
        $delete_custome_button = '';
        $delete_header = '';
    }
?>