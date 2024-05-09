<!--ДОДАТИ ТОВАР-->
<?php
session_start();
require_once '../php/connect.php';


	// Виводимо дані
$info = [];
$info_p = [];

if(isset($_POST['searching']) ){
	
	
	$serch = $_POST['serch'];
	
	if(!empty($serch)){
		$result = mysqli_query($conn, "SELECT * FROM buy_table WHERE `code` = '$serch' OR `status` = '$serch'");


    while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
    }
		
$result_p = mysqli_query($conn, "SELECT * FROM product_table WHERE id_product IN (SELECT id_product FROM buy_table WHERE `code` = '$serch')");
		  while ($row = mysqli_fetch_assoc($result_p)) {
    $info_p[] = $row;
    }
	
		
		
}
	
	
	
	else{
		
$result = mysqli_query($conn, "SELECT * FROM buy_table");

while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
}
	}
	

}else{


$result = mysqli_query($conn, "SELECT * FROM buy_table");

while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
}
}



?>


<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">
	<title>Адмін-товари</title>
	<link rel="shortcut icon" href="../img/icon/icon.png">
	<link rel="stylesheet" href="../css/admin.css">

</head>

<body>
	<div class="wrapper">
		<header>

			<img src="../img/icon/admin.png" alt="" class="icon_img">


			<p>Адмін-панель</p>

		</header>



		<div class="content">
			<div class="menu">
				<!--			додати товар-->
				<div class="block">
					<a href="admin.php"> <img src="../img/icon/add.png" alt="" class="icon_img"></a>
					<p>Додати товар</p>
				</div>
				<!--			пошук замовлення-->
				<div class="block_1">
					<a href="admin_order.php"> <img src="../img/icon/order.png" alt="" class="icon_img"></a>
					<p>Замовлення</p>
				</div>
				<!--			пошук коритувачі-->
				<div class="block">
					<a href="admin_user.php"><img src="../img/icon/user.png" alt="" class="icon_img"></a>
					<p>Користуввачі</p>
				</div>

			</div>
			<div class="panel">
				<div class="panel_block">
					<div class="title">
						<p>Пошук замовлень</p>
					</div>

					<div class="cont">
						<form id="search_form" method="POST">

							<input type="text" id="serch" name="serch" placeholder="Пошук усіх замовлень">
							<input type="submit" value="Пошук" name="searching">
						</form>
						<br>
						<p>Замовлення:</p>
						<table>
							<tr>
								<th>Код</th>
								<th>ID</th>
								<th>Замовник</th>


								<th>Тип оплати</th>
								<th>Сума</th>
								<th>Статус</th>

							</tr>
							<?php
        $displayed_codes = array(); // Масив для збереження вже виведених кодів
        foreach ($info as $row):
            if (!in_array($row['code'], $displayed_codes)): // Перевірка, чи код вже був виведений
                array_push($displayed_codes, $row['code']); // Додаємо код до списку виведених
							
							
							 // Виконуємо запит до бази даних, щоб отримати дані про тип оплати та суму доставки
            $query = "SELECT pay_method, total_price FROM delivery_table WHERE id = " . $row['id_delivery'];
            $result = mysqli_query($conn, $query); // Предполагається, що ви використовуєте mysqli для роботи з базою даних
            $delivery_info = mysqli_fetch_assoc($result);
							
							 // Виконуємо запит до бази даних, щоб отримати дані про користувача
            $query = "SELECT mail FROM user_table WHERE id_user = " . $row['id_user'];
            $result = mysqli_query($conn, $query); // Предполагається, що ви використовуєте mysqli для роботи з базою даних
            $user_info = mysqli_fetch_assoc($result);
    ?>

							<tr class="table-row_code" data-id="<?php echo $row['code']; ?>">

								<td><b><?php echo $row['code']; ?></b></td>
								<td><?php echo $row['id_user']; ?></td>
								<td><?php echo $user_info['mail']; ?></td>

								<td><?php echo $delivery_info['pay_method']; ?></td>
								<td><?php echo $delivery_info['total_price']; ?></td>

								<td><b><?php echo $row['status']; ?></b></td>

							</tr>

							<?php
								endif;
							endforeach;
						?>


						</table>

						<?php 
						 if (!empty($serch)) : 
						?>
						<br>
						<p>Товари:</p>
						<table>
							<tr>
								<th>ID</th>
								<th>Назва</th>
								<th>Кількість</th>
								<th>Ціна</th>
							</tr>

							<?php foreach ($info_p as $row): ?>
							<tr class="table-row" data-id="<?php echo $row['id_product']; ?>">
								<td><b><?php echo $row['id_product']; ?></b></td>
								<td><?php echo $row['name']; ?></td>
								<td>
									<?php
            $result_buy = mysqli_query($conn, "SELECT count FROM buy_table WHERE `id_product` = '" . $row['id_product'] . "'");
            $row_buy = mysqli_fetch_assoc($result_buy);
            $count = $row_buy['count'];
            echo $count;
            ?>
								</td>
								<td><?php echo $row['price']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>


						<!--						//////////////////////////////////////////////////////////////////////////////////////////////////-->





						<br>
						<p>Доставка:</p>

						<table>
							<tr>
								<th>Область</th>
								<th>Населений пункт</th>
								<th>Адреса</th>
								<th>Спосіб доставки</th>

							</tr>
							<?php
        $displayed_codes = array(); // Масив для збереження вже виведених кодів
        foreach ($info as $row):
            if (!in_array($row['code'], $displayed_codes)): // Перевірка, чи код вже був виведений
                array_push($displayed_codes, $row['code']); // Додаємо код до списку виведених
							
							
							
							
							 // Виконуємо запит до бази даних, щоб отримати дані про користувача
            $query = "SELECT * FROM delivery_table WHERE id = " . $row['id_delivery'];
            $result = mysqli_query($conn, $query); // Предполагається, що ви використовуєте mysqli для роботи з базою даних
            $delivery_info = mysqli_fetch_assoc($result);
    ?>

							<tr class="table-row_code" data-id="<?php echo $row['code']; ?>">

								<td><b><?php echo $delivery_info['region']; ?></b></td>
								<td><?php echo $delivery_info['city']; ?></td>
								<td><?php echo $delivery_info['address']; ?></td>

								<td><?php echo $delivery_info['type']; ?></td>


							</tr>

							<?php
								endif;
							endforeach;
						?>


						</table>









						<!--						///////////////////////////////////////////////////////////////////////////////////////////////////////////-->

						<?php endif; ?>



						<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
						<script>
							function copyToClipboardAndSearch(text) {
								// Копіювання в буфер обміну
								if (navigator.clipboard) {
									navigator.clipboard.writeText(text).then(function() {
										console.log('Асинхронно: Копіювання в буфер обміну виконано успішно!');
									}, function(err) {
										console.error('Асинхронно: Неможливо скопіювати текст: ', err);
									});
								} else {
									var textArea = document.createElement("textarea");
									textArea.value = text;
									document.body.appendChild(textArea);
									textArea.focus();
									textArea.select();
									try {
										var successful = document.execCommand('copy');
										var msg = successful ? 'успішно' : 'неуспішно';
									} catch (err) {
										console.error('Альтернативно: Не вдалося скопіювати', err);
									}
									document.body.removeChild(textArea);
								}

								// Додавання до поля пошуку
								var $searchInput = $('#serch');
								$searchInput.val(text);
							}

							$(document).ready(function() {
								// Зміна курсору тільки для рядків з класом table-row_code
								$(".table-row_code").css("cursor", "pointer");
								$(".table-row_code").click(function(event) {
									var id = $(this).data("id");
									// Вставка коду в поле вводу
									$('#code_input').val(id);
									copyToClipboardAndSearch(id);
								});

								// Зміна курсору тільки для рядків з класом table-row
								$(".table-row").css("cursor", "pointer");
								$(".table-row").click(function(event) {
									var id = $(this).data("id");
									if (event.ctrlKey) {
										window.open("../product.php?data=" + id, '_blank'); // Відкриття в новій вкладці
									}
								});
							});

						</script>

					</div>
				</div>

				<div class="panel_block">

					<div class="title">
						<p>Зміна статусу</p>
					</div>
					<div class="cont">
						<form action="../php/update_status.php" method="POST">



							<label for="code">Код:</label><br>
							<input type="text" id="code_input" name="code" required><br>


							<label for="classification">Статус:</label><br>
							<p><input type="radio" id="classification" name="status" value="Обробляється" required>Обробляється</p>
							<p><input type="radio" id="classification" name="status" value="Чекає оплати" required>Чекає оплати</p>
							<p><input type="radio" id="classification" name="status" value="Комплектується" required>Комплектується</p>
							<p><input type="radio" id="classification" name="status" value="Доставляється" required>Доставляється</p>
							<p><input type="radio" id="classification" name="status" value="Видача" required>Видача</p>
							<p><input type="radio" id="classification" name="status" value="Виконано" required>Отримано</p>
							<p><input type="radio" id="classification" name="status" value="Скасовано" required>Скасовано</p><br>



							<input type="submit" value="Змінити статус" name="update_status">
						</form>


						<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->



					</div>

				</div>





			</div>

		</div>

		<footer id="footer">

		</footer>
	</div>




</body>

</html>
