<!--ДОДАТИ ТОВАР-->
<?php
session_start();
require_once '../php/connect.php';


	// Виводимо дані
$info = [];


if(isset($_POST['searching']) ){
	
	
	$serch = $_POST['serch'];
	
	if(!empty($serch)){
		$result = mysqli_query($conn, "SELECT * FROM product_table WHERE `name` = '$serch' OR `id_product` = '$serch' OR `classification` = '$serch' OR `type` = '$serch'");


    while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
    }
	}else{
		
$result = mysqli_query($conn, "SELECT * FROM product_table");

while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
}
	}
	

}else{


$result = mysqli_query($conn, "SELECT * FROM product_table");

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
				<div class="block_1">
					<a href="admin.php">	<img src="../img/icon/add.png" alt="" class="icon_img"></a>
					<p>Додати товар</p>
				</div>
				<!--			пошук замовлення-->
				<div class="block">
				<a href="admin_order.php">		<img src="../img/icon/order.png" alt="" class="icon_img"></a>
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
						<p>Область додавання</p>
					</div>
					<div class="cont">
						<form action="../php/insert.php" method="POST" enctype="multipart/form-data">



							<label for="name">Назва:</label><br>
							<input type="text" id="name" name="name" required><br>

							<label for="classification">Класифікація:</label><br>
							<input type="text" id="classification" name="classification" required><br>

							<label for="type">Тип:</label><br>
							<input type="text" id="type" name="type" required><br>

							<label for="description">Опис:</label><br>
							<textarea id="description" name="description" rows="4" required></textarea><br>

							<label for="s_description">Короткий опис:</label><br>
							<textarea id="s_description" name="s_description" rows="2" required></textarea><br>

							<label for="image">Зображення:</label><br>
							<input type="file" name="image" required><br>

							<label for="price">Ціна:</label><br>
							<input type="number" id="price" name="price" step="0.01" required><br><br>

							<input type="submit" value="Додати">
						</form>
					</div>

				</div>

				<div class="panel_block">
					<div class="title">
						<p>Додані товари</p>
					</div>

					<div class="cont">
						<form id="search_form" method="POST">

							<input type="text" id="serch" name="serch" placeholder="Пошук усіх товарів">
							<input type="submit" value="Пошук" name="searching">
						</form>
						<table>
							<tr>
								<th>ID</th>
								<th>Назва</th>
								<th>Класифікація</th>
								<th>Тип</th>

								<th>⮾</th>

							</tr>
							<?php foreach ($info as $row): ?>

							<tr class="table-row" data-id="<?php echo $row['id_product']; ?>">

								<td><b><?php echo $row['id_product']; ?></b></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['classification']; ?></td>
								<td><?php echo $row['type']; ?></td>

								<td> <a href="../php/delete_product.php?data=<?php echo $row['id_product']; ?>">
										<img style="width: 30px;" src="../img/icon/delet.png" alt="⮾">
									</a></td>

							</tr>

							<?php endforeach; ?>
						</table>
						<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
						<script>
							$(document).ready(function() {
								$(".table-row").css("cursor", "pointer"); // Зміна курсору для всіх рядків таблиці
								$(".table-row").click(function(event) {
									if (event.ctrlKey) { // Перевіряємо, чи зажата клавіша Ctrl
										var id = $(this).data("id");
										window.open("../product.php?data=" + id, '_blank'); // Відкриття посилання в новому вікні
									} else {
										
									}
								});
							});

						</script>

					</div>
				</div>



			</div>

		</div>

		<footer id="footer">

		</footer>
	</div>




</body>

</html>
