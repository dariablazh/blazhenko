<?php
session_start();

require_once 'connect.php';

if (!$_SESSION['user']) {
    header('Location: pass.php');
}

$user = $_SESSION['user']['id_user'];





// Retrieve delivery details from the form
$user_id = $_POST['user_id'];
$region = $_POST['region'];
$city = $_POST['city'];
$delivery_method = $_POST['delivery_method'];
$address = $_POST['address'];
$pay_method = $_POST['pay_method'];

$total_price = floatval($_POST['total_price']);




    // If no record exists, insert a new one
    $insert_query = "INSERT INTO `delivery_table` (`id_user`, `region`, `city`, `type`, `address`, `pay_method`, `total_price`) VALUES ('$user_id', '$region', '$city', '$delivery_method', '$address', '$pay_method', '$total_price')";
    $insert_result = mysqli_query($conn, $insert_query);

   if ($insert_result) {
    $last_insert_id = mysqli_insert_id($conn); // Отримання ID останнього вставленого запису
   
} else {
    echo "Помилка при вставці: " . mysqli_error($conn);
    exit;
}




// Generate a unique numeric code for the entire order
$code = abs(crc32(uniqid()));

// Отримуємо дані для замовлення з кошика
$result_cart = mysqli_query($conn, "SELECT * FROM favorites_table WHERE `id_user` = '$user' AND `status` = 'cart'");
while ($row = mysqli_fetch_assoc($result_cart)) {
    $product_id = $row['id_product'];
    $count = $row['count'];
   
    // Insert order details into the buy_table with the same code for all products in the order
    $insert_query = "INSERT INTO buy_table (code, id_product, count, id_user, id_delivery, status) VALUES ('$code', '$product_id', '$count', '$user', ' $last_insert_id', 'Обробляється')";
    $insert_result = mysqli_query($conn, $insert_query);

    if (!$insert_result) {
        echo "Помилка при записі до таблиці замовлень: " . mysqli_error($conn);
        exit;
    }
}


// Видаляємо записи з кошика
$delete_query = "DELETE FROM favorites_table WHERE `id_user` = '$user' AND `status` = 'cart'";
$delete_result = mysqli_query($conn, $delete_query);


// Redirect after successful insertion or update
header('Location: ../user.php#panel');
exit;
?>




