<?php
session_start();
require_once 'php/connect.php';

if (!$_SESSION['user']) {
    header('Location: pass.php');
}

$user = $_SESSION['user']['id_user'];

$info_user = [];
$result_user = mysqli_query($conn, "SELECT * FROM user_table WHERE `id_user` = '$user'");
while ($row_user = mysqli_fetch_assoc($result_user)) {
    $info_user[] = $row_user;
}

// Завантаження інформації для кошика
$cart_products = [];
$result_cart = mysqli_query($conn, "SELECT id_product FROM favorites_table WHERE `id_user` = '$user' AND `status` = 'cart'");
while ($row = mysqli_fetch_assoc($result_cart)) {
    $cart_products[] = $row['id_product'];
}
$cart_products_info = [];
foreach ($cart_products as $id_product) {
    $result_product = mysqli_query($conn, "SELECT * FROM product_table WHERE `id_product` = '$id_product'");
    if ($product_data = mysqli_fetch_assoc($result_product)) {
        $cart_products_info[] = $product_data;
    }
}

$total_price = 0; // Ініціалізуємо змінну для зберігання загальної суми цін
foreach ($cart_products_info as $data) {
    $result_favorites = mysqli_query($conn, "SELECT * FROM favorites_table WHERE `id_product` = '" . $data['id_product'] . "'");
    $count = 0; // присвоюємо значення за замовчуванням
    while ($row_favorites = mysqli_fetch_assoc($result_favorites)) {
        $info_favorites[] = $row_favorites;
        $count = $row_favorites['count']; // Отримання значення count
    }
    $total_price += $data['price'] * $count;
}
?>

<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">

	<title>Оформлення замовлення</title>


	<link rel="shortcut icon" href="img/icon/icon.png">

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/menu.css">
	<link rel="stylesheet" href="css/user.css">
	<link rel="stylesheet" href="css/info.css">

	<link rel="stylesheet" href="css/form.css">
	<link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" href="css/slider.css">

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


			<div class="block_panel">

				<!--ОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕ-->


				<div class="panel" style="background-color: #fff;">

					<div class="info">


						<br> <a href="">ОФОРМЛЕННЯ ЗАМОВЛЕННЯ:</a>
						<div class="info_p">
							<form action="php/add_to_buy.php" method="POST">
								<input type="hidden" name="user_id" value="<?php echo $user; ?>">

								<input type="hidden" name="total_price" value="<?php echo $total_price; ?>">



								<label for="region">Вкажіть область:</label>
								<input type="text" name="region" id="region" required>

								<label for="city">Вкажіть місто або село:</label>
								<input type="text" name="city" id="city" required>

								<label>Оберіть спосіб доставки:</label><br>
								<label for="courier"><input type="radio" name="delivery_method" id="courier" value="На адресу" required> Кур'єрська доставка</label>
								<label for="post"><input type="radio" name="delivery_method" id="post" value="Пошта" required> Поштова доставка</label>
								<label for="pickup"><input type="radio" name="delivery_method" id="pickup" value="Самовивіз" required> Самовивіз</label><br>

								<label for="address">Вкажіть адресу:</label>
								<input type="text" name="address" id="address" required>

								<label>Оберіть спосіб оплати:</label><br>
								<label for="cash"><input type="radio" name="pay_method" id="cash" value="Готівкою" required> Готівкою</label>
								<label for="card"><input type="radio" name="pay_method" id="card" value="Карткою" required> Карткою</label>
								<label for="online"><input type="radio" name="pay_method" id="online" value="Онлайн" required> Онлайн</label><br>


								<p>
									<button type="submit" name="buy">ОФОРМИТИ</button>
									<button type="reset">ОЧИСТИТИ</button>
								</p>
							</form>


						</div>

					</div>


				</div>

				<!--КОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИК-->
				<div class="panel">
					<?php foreach ($cart_products_info as $data): ?>
					<div class="card">
						<div class="card_left">
							<p><a href="product.php?data=<?php echo $data['id_product']; ?>"><img src="<?= $data['image']; ?>" alt="Контент - головна сторінка"></a></p>
						</div>
						<div class="card_right">

							<?php
                $info_favorites = [];
                $result_favorites = mysqli_query($conn, "SELECT * FROM favorites_table WHERE `id_product` = '" . $data['id_product'] . "'");

                while ($row_favorites = mysqli_fetch_assoc($result_favorites)) {
                    $info_favorites[] = $row_favorites;
                    $count = $row_favorites['count']; // Отримання значення count
                    $id = $row_favorites['id_favorite']; // Отримання значення id
                }
                ?>

							<p>Кількість: &nbsp;<?php echo $count; ?></p>
							<p><?php echo $data['name']; ?></p>
							<p>Ціна: &nbsp;<?php echo $data['price']; ?>&nbsp;грн.</p>
							<p style="display: flex; align-items: center;">Статус: <span><img style="max-width: 30px;" src="img/icon/buy.png" alt=""></span></p>

						</div>
					</div>
					<?php endforeach; ?>
				</div>

			</div>
			<div class="block">
				<div class="info">

					<a href="">Сума до сплати: &nbsp;<?php echo $total_price; ?>&nbsp;грн.</a>

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
