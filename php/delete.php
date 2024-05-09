<?php
session_start();

require_once 'connect.php';

if (!$_SESSION['user']) {
    header('Location: index.php');
    exit; // Добавляем выход, чтобы код ниже не выполнялся после перенаправления
}

if (isset($_GET['data'])) {
    $id = $_GET['data'];

    // Получаем текущее количество для указанного объекта
    $query = "SELECT `count` FROM `favorites_table` WHERE `id_favorite` = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $count = $row['count'];

        if ($count > 1) {
            // Если количество больше 1, уменьшаем его на 1
            $newQuantity = $count - 1;
            $updateQuery = "UPDATE `favorites_table` SET `count` = '$newQuantity' WHERE `id_favorite` = '$id'";
            mysqli_query($conn, $updateQuery);
        } else {
            // Если количество равно 1, удаляем объект
            $deleteQuery = "DELETE FROM `favorites_table` WHERE `id_favorite` = '$id'";
            mysqli_query($conn, $deleteQuery);
        }
    }
}

header('Location: ../user.php#panel');
exit; // Завершаем выполнение скрипта после перенаправления
?>
