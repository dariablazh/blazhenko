<?php
session_start();
require_once 'php/connect.php';

if (!$_SESSION['user']) {
    header('Location: pass.php');
}

$user = $_SESSION['user']['id_user'];


  $new_data = $_GET['data'];



$info_user = [];
$result_user = mysqli_query($conn, "SELECT * FROM user_table WHERE `id_user` = '$user'");
while ($row_user = mysqli_fetch_assoc($result_user)) {
    $info_user[] = $row_user;
}

// Завантаження інформації для обраного
$selected_products = [];
$result_selected = mysqli_query($conn, "SELECT id_product FROM favorites_table WHERE `id_user` = '$user' AND `status` = 'selected'");
while ($row = mysqli_fetch_assoc($result_selected)) {
    $selected_products[] = $row['id_product'];
}
$selected_products_info = [];
foreach ($selected_products as $id_product) {
    $result_product = mysqli_query($conn, "SELECT * FROM product_table WHERE `id_product` = '$id_product'");
    if ($product_data = mysqli_fetch_assoc($result_product)) {
        $selected_products_info[] = $product_data;
    }
}


// Завантаження інформації для замовлень
$buy_products_info = [];
$result_buy = mysqli_query($conn, "SELECT id_product, count, code, id_delivery, status FROM buy_table WHERE `id_user` = '$user' AND `code` = '$new_data'");
while ($row = mysqli_fetch_assoc($result_buy)) {
    $product_id = $row['id_product'];
    $count = $row['count'];
	$code = $row['code'];
	$status = $row['status'];
	$id_delivery = $row['id_delivery'];
	

    $result_product = mysqli_query($conn, "SELECT * FROM product_table WHERE `id_product` = '$product_id'");
    $product_data = mysqli_fetch_assoc($result_product);

    // Додаємо дані про товар разом з кількістю до масиву
    $product_data['count'] = $count;
	 $product_data['code'] = $code;
	 $product_data['status'] = $status;
	
    $buy_products_info[] = $product_data;
}

$info_delivery = [];

$result_delivery = mysqli_query($conn, "SELECT * FROM delivery_table WHERE `id` = '$id_delivery'");

while ($row_delivery = mysqli_fetch_assoc($result_delivery)) {
    $info_delivery[] = $row_delivery;
}


?>

<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">

	<title>Замовлення</title>


	<link rel="shortcut icon" href="img/icon/icon.png">

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/menu.css">

	<link rel="stylesheet" href="css/info.css">


	<link rel="stylesheet" href="css/user.css">


	<link rel="stylesheet" href="css/footer.css">


</head>

<body>
	<div class="wrapper">
		<!--//////////////////////////////////////////////////////////////////////////////header-->
		<header>
			<a href="index.php"><img src="img/icon/logo.png" alt=""></a>
			<div class="header_p">
				<p>Дубовицький</p>
				<p>завод</p>
				<p>сільгосптехніки</p>
			</div>

		</header>
		<!--//////////////////////////////////////////////////////////////////////////////nav-->
		<div class="menu">
			<div class="block_m"><a href="index.php"><img src="img/icon/home.png" alt="">Головна</a></div>
			<div class="block_m"><a href="serch.php"><img src="img/icon/str.png" alt="">Товари</a></div>
			<div class="block_m"><a href="delivery.php"><img src="img/icon/del.png" alt="">Доставка та оплата</a></div>
			<div class="block_m"><a href="description.php"><img src="img/icon/inf.png" alt="">Про нас</a></div>

			<div class="block_m"><a href="communication.php"><img src="img/icon/phon.png" alt="">Зв'язок</a></div>
			<div class="block_m"><a href="pass.php"><img src="img/icon/kab.png" alt="">Особистий кабінет</a></div>

		</div>
		<!--//////////////////////////////////////////////////////////////////////////////content-->
		<div class="content">

			<!--		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<div class="block_title">

				<p></p>
				<div class="panel_title">
					<p style="display: flex; align-items: center;">Замовлення номер:&nbsp;<?php echo  $code; ?></p>
				</div>
				<p></p>

			</div>
			<div class="block">
				<div class="info">
					<a href=""><?= $_SESSION['user']['f_name']?>&nbsp;<?=  $_SESSION['user']['l_name'] ?></a>
					<p>Електронна адреса:&nbsp; <?= $_SESSION['user']['email']?></p>
					<p>Номер телефону:&nbsp; <?= $_SESSION['user']['phone']?></p>
					<p></p>
				</div>
			</div>
			<div class="block">

				<div class="info">


					<br><a href="">ДОСТАВКА ТА ОПЛАТА</a><br>
					<div class="info_p">

						<?php foreach ($info_delivery as $data): ?>
						<p>Область: &nbsp;<?php echo $data['region']; ?></p>
						<p>Місто: &nbsp;<?php echo $data['city']; ?></p>
						<p>Адреса: &nbsp;<?php echo $data['address']; ?></p>
						<p>Спосіб доставки: &nbsp;<?php echo $data['type']; ?></p>
						<p>Спосіб оплати: &nbsp;<?php echo $data['pay_method']; ?></p>
						<p>Сума до сплати:&nbsp;<?php echo $data['total_price']; ?>&nbsp;грн. </p><br>
						<?php endforeach; ?>
					</div>
				</div>
				
			</div>
			
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<div class="panel_new">
				<?php foreach ($buy_products_info as $data): ?>
				<div class="card_new">
					<div class="card_left">
						<p> <a href="product.php?data=<?php echo $data['id_product']; ?>"><img src="<?= $data['image']; ?>" alt="Контент - головна сторінка"></a></p>
					</div>
					<div class="card_right">

						<p>Статус: &nbsp;<?php echo $data['status']; ?></p>
						<p>Кількість: &nbsp;<?php echo $data['count']; ?></p>
						<p><?php echo $data['name']; ?></p>


						<p>Ціна: &nbsp;<?php echo $data['price']; ?>&nbsp;грн.</p>

					</div>
				</div>
				<?php endforeach; ?>

			</div>


			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->


			<div class="block">

				
				
				<div class="info">

					
					<a href="">НАШІ РЕКВІЗИТИ</a><br>
					<div class="info_p">
						<p>Назва: ТОВ «ДЗСТ 2»</p>

						<p>Код: 44765929</p>

						<p>ІНН: 447659218079</p>

						<p>Р/р: UA903375680000026003300459145 АТ «Ощадбанк» м.Суми</p>

						<p>МФО: 337568</p>

						<p>Адреса: 41321, Сумська область, Конотопський район, с. Дубовичі, вул. Шевченка 6</p>

						<p>Тел. моб.: (098) 661-7616</p>

						<p>Ел. адреса: dzst@ukr.net</p>

						<p>Директор : Онікієнко Віктор Борисович</p>

						<p>Платник ПДВ. Загальна форма оподаткування.</p>



					</div>






				</div>

			</div>



		</div>




		<!--//////////////////////////////////////////////////////////////////////////////footer-->
		<footer id="footer">
			<div class="block_f">
				<p> <a href=""><img src="img/icon/facebook.png" alt="">Facebook</a></p>
				<p><a href=""><img src="img/icon/insta.png" alt="">Instagram</a></p>
				<p><a href=""><img src="img/icon/youtube.png" alt="">YouTube</a></p>
				<p><a href=""><img src="img/icon/viber.png" alt="">Viber</a></p>

			</div>
			<div class="block_f">
				<p><img src="img/icon/comun.png" alt="">(068) 094-2926 – Бухгалтерія</p>
				<p><img src="img/icon/comun.png" alt="">(068) 316-4932 – Відділ збуту</p>

			</div>

			<div class="block_f">

				<p><img src="img/icon/comun.png" alt="">(068) 31-64-932 - Відділ по роботі з клієнтами</p>
				<p><img src="img/icon/comun.png" alt="">(098) 00-81-778 - Відділ по роботі з клієнтами</p>
			</div>
			<div class="block_f">
				<p><img src="img/icon/mail.png" alt="">dzst@ukr.net</p>
			</div>
		</footer>
	</div>


</body>

</html>
