<!--ДОДАТИ ТОВАР-->
<?php
session_start();
require_once '../php/connect.php';


	// Виводимо дані
$info = [];


if(isset($_POST['searching']) ){
	
	
	$serch = $_POST['serch'];
	
	if(!empty($serch)){
		$result = mysqli_query($conn, "SELECT * FROM user_table WHERE `id_user` = '$serch' OR `name` = '$serch' OR `mail` = '$serch' OR `phone` = '$serch'");


    while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
    }
	}else{
		
$result = mysqli_query($conn, "SELECT * FROM user_table");

while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
}
	}
	

}else{


$result = mysqli_query($conn, "SELECT * FROM user_table");

while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
}
}


?>

<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">
	<title>Адмін-користувачі</title>
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
				<div class="block">
					<a href="admin_order.php"> <img src="../img/icon/order.png" alt="" class="icon_img"></a>
					<p>Замовлення</p>
				</div>
				<!--			пошук коритувачі-->
				<div class="block_1">
					<a href="admin_user.php"><img src="../img/icon/user.png" alt="" class="icon_img"></a>
					<p>Користуввачі</p>
				</div>

			</div>
			<div class="panel">
				<div class="panel_block">
					<div class="title">
						<p>Пошук Користувачів</p>
					</div>

					<div class="cont">
						<form id="search_form" method="POST">

							<input type="text" id="serch" name="serch" placeholder="Пошук усіх замовлень">
							<input type="submit" value="Пошук" name="searching">
						</form>
						<table>
							<tr>
								<th>ID</th>
								<th>Ім'я</th>
								<th>Пошта</th>
								<th>Телефон</th>


							</tr>

	<?php foreach ($info as $row): ?>
							<tr>

								<td><b><?php echo $row['id_user']; ?></b></td>
								<td><?php echo $row['name']; ?> <?php echo $row['surname']; ?></td>
								<td><?php echo $row['mail']; ?></td>
								<td><?php echo $row['phone']; ?></td>




							</tr>
	<?php endforeach; ?>

						</table>



					</div>
				</div>

				<div class="panel_block">

					<div class="title">
						<p>Вихід</p>
					</div>
					<div class="cont">
						<form action="../php/logout.php" method="POST">


							<input type="submit" value="Вихід з адмін-панелі">
						</form>
					</div>

				</div>





			</div>

		</div>

		<footer id="footer">

		</footer>
	</div>




</body>

</html>
