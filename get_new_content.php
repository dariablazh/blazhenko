<?php
session_start();
require_once 'php/connect.php'; // Подключение к БД

// Создаем переменную для хранения HTML содержимого панели продуктов
$html = '';

// Проверяем, были ли переданы данные через POST запрос
if (isset($_POST['classification']) || isset($_POST['type'])) {
    // Формируем запрос к БД для получения соответствующих продуктов
    $query = "SELECT * FROM product_table";
    if (isset($_POST['classification']) && !empty($_POST['classification'])) {
        $classification = $_POST['classification'];
        $query .= " WHERE classification = '$classification'";
    }
    if (isset($_POST['type']) && !empty($_POST['type'])) {
        $types = $_POST['type'];
        $types_string = "'" . implode("','", $types) . "'";
        $query .= isset($classification) ? " AND type IN ($types_string)" : " WHERE type IN ($types_string)";
    }
    

    // Выполняем запрос к БД
    $result = mysqli_query($conn, $query);

    // Формируем HTML содержимое панели продуктов на основе полученных данных
    while ($data = mysqli_fetch_assoc($result)) {
        $html .= '<div class="card">';
        $html .= '<div class="card_left">';
        $html .= '<p><a href="product.php?data=' . $data['id_product'] . '"><img src="' . htmlspecialchars($data['image']) . '" alt=""></a></p>';
        $html .= '</div>';
        $html .= '<div class="card_right">';
        $html .= '<p>' . htmlspecialchars($data['name']) . '</p>';
        $html .= '<p>' . htmlspecialchars($data['s_description']) . '</p>';
        $html .= '<p>' . htmlspecialchars($data['price']) . ' грн.</p>';
        $html .= '</div>';
        $html .= '</div>';
    }
}

// Возвращаем HTML содержимое панели продуктов
echo $html;
?>
