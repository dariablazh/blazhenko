<?php
require_once 'connect.php';


    $status = $_POST['status'];
    $code = $_POST['code'];

    
    $result = mysqli_query($conn, "UPDATE buy_table SET status = '$status' WHERE code = '$code'");

 $link = "../admin/admin_order.php";
header('Location: ' . $link);
?>