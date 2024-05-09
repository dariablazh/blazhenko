<?php
session_start();

require_once 'connect.php';

 $link = "../admin/admin.php";

if (isset($_GET['data'])) {
  $id = $_GET['data'];
	

    $result = mysqli_query($conn, "DELETE FROM product_table WHERE `id_product` = '$id'");

}

 
 header('Location: ' . $link);

?>