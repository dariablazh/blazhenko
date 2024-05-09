<?php
session_start();

require_once 'connect.php';

if (!$_SESSION['user']) {
    header('Location: index.php');
    exit; // Добавляем выход, чтобы код ниже не выполнялся после перенаправления
}

if (isset($_GET['data'])) {
    $id = $_GET['data'];

    // Предположим, что новый статус хранится в переменной $newStatus
    $newStatus = 'cart';

    // Выполняем запрос на обновление статуса
    $query = "UPDATE `favorites_table` SET `status` = '$newStatus' WHERE `id_favorite` = '$id'";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        echo "Помилка: " . mysqli_error($conn);
        exit;
    }
}

header('Location: ../user.php#panel');
exit; // Завершаем выполнение скрипта после перенаправления
?>

