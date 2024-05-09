<?php
session_start();
require_once 'php/connect.php';

if (!$_SESSION['user']) {
    header('Location: pass.php');
}

$login = $_SESSION['user']['email'];

if($login == "blazhenko@gmail.com"){
	
	header('Location: admin/admin.php');
}



$user = $_SESSION['user']['id_user'];


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


// Завантаження інформації для замовлень
$buy_products_info = [];
$result_buy = mysqli_query($conn, "SELECT id_product, count, code, status FROM buy_table WHERE `id_user` = '$user'");
while ($row = mysqli_fetch_assoc($result_buy)) {
    $product_id = $row['id_product'];
    $count = $row['count'];
	$code = $row['code'];
	$status = $row['status'];

    $result_product = mysqli_query($conn, "SELECT * FROM product_table WHERE `id_product` = '$product_id'");
    $product_data = mysqli_fetch_assoc($result_product);

    // Додаємо дані про товар разом з кількістю до масиву
    $product_data['count'] = $count;
	 $product_data['code'] = $code;
	 $product_data['status'] = $status;
    $buy_products_info[] = $product_data;
}



?>

<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">

	<title>Кабінет</title>


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
			<div class="block_m"><a href="pass.php"><img src="img/icon/kab.png" alt=""><b>Особистий кабінет</b></a></div>

		</div>
		<!--//////////////////////////////////////////////////////////////////////////////content-->
		<div class="content">
			<div class="block">
				<div class="info">
					<a href=""><?= $_SESSION['user']['f_name']?>&nbsp;<?=  $_SESSION['user']['l_name'] ?></a>
					<p>Електронна адреса:&nbsp; <?= $_SESSION['user']['email']?></p>
					<p>Номер телефону:&nbsp; <?= $_SESSION['user']['phone']?></p>
					<p></p>
				</div>
			</div>
			<!--		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

			<div class="block_title" id="panel">


				<div class="panel_title" style="display: flex; align-items: center;">
					<p style="display: flex; align-items: center;">Обране&nbsp;<img src="img/icon/sel.png" alt="" style="max-width: 40px;"></p>
				</div>


				<div class="panel_title">
					<a href="user_buy.php">
						<p style="display: flex; align-items: center;">Кошик&nbsp;<img src="img/icon/buy.png" alt="" style="max-width: 40px;"></p>


					</a>


				</div>

			</div>


			<div class="block_panel">

				<!--ОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕОБРАНЕ-->


				<div class="panel">

					<?php foreach ($selected_products_info as $data): ?>
					<div class="card">
						<div class="card_left">
							<p> <a href="product.php?data=<?php echo $data['id_product']; ?>"><img src="<?= $data['image']; ?>" alt="Контент - головна сторінка"></a></p>
						</div>
						<div class="card_right">

							<?php 
									
									$info_favorites = []; 
							$result_favorites = mysqli_query($conn, "SELECT * FROM favorites_table WHERE `id_product` = '" . $data['id_product'] . "' AND `id_user` = $user");


									while ($row_favorites = mysqli_fetch_assoc($result_favorites)) {
										$info_favorites[] = $row_favorites;
										$count = $row_favorites['count']; // Получение значения count
										$id = $row_favorites['id_favorite']; // Получение значения id
									}

									?>

							<p>Кількість: &nbsp;<?php echo $count; ?></p>
							<p><?php echo $data['name']; ?></p>

							<p>


								<span> <a href="php/delete.php?data=<?php echo $id; ?>">&nbsp;&nbsp;<img style="max-width: 30px;" src="img/icon/delet.png" alt=""></a>
								</span> <span> <a href="php/add_to_cart.php?data=<?php echo $id; ?>">&nbsp;&nbsp;<img style="max-width: 30px;" src="img/icon/kor.png" alt=""></a>

								</span>


							</p>
							<p>Ціна: &nbsp;<?php echo $data['price']; ?>&nbsp;грн.</p>
							<p style="display: flex; align-items: center;">Статус: <span><img style="max-width: 30px;" src="img/icon/sel.png" alt=""></span></p>

						</div>
					</div>
					<?php endforeach; ?>


				</div>

				<!--КОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИККОШИК-->
				<div class="panel">
					<?php foreach ($cart_products_info as $data): ?>
					<div class="card">
						<div class="card_left">
							<p> <a href="product.php?data=<?php echo $data['id_product']; ?>"><img src="<?= $data['image']; ?>" alt="Контент - головна сторінка"></a></p>
						</div>
						<div class="card_right">

							<?php 
									
									$info_favorites = []; 
							$result_favorites = mysqli_query($conn, "SELECT * FROM favorites_table WHERE `id_product` = '" . $data['id_product'] . "'");


									while ($row_favorites = mysqli_fetch_assoc($result_favorites)) {
										$info_favorites[] = $row_favorites;
										$count = $row_favorites['count']; // Получение значения count
											$id = $row_favorites['id_favorite']; // Получение значения id
									}

									
									
									?>



							<p>Кількість: &nbsp;<?php echo $count; ?></p>
							<p><?php echo $data['name']; ?></p>

							<p>


								<span> <a href="php/delete.php?data=<?php echo $id; ?>">&nbsp;&nbsp;<img style="max-width: 30px;" src="img/icon/delet.png" alt=""></a>
								</span> <span> <a href="php/add_to_cart.php?data=<?php echo $id; ?>">&nbsp;&nbsp;<img style="max-width: 30px;" src="img/icon/kor.png" alt=""></a>

								</span>

							</p>
							<p>Ціна: &nbsp;<?php echo $data['price']; ?>&nbsp;грн.</p>
							<p style="display: flex; align-items: center;">Статус: <span><img style="max-width: 30px;" src="img/icon/kor.png" alt=""></span></p>

						</div>
					</div>
					<?php endforeach; ?>


				</div>



			</div>

			<div class="block_title">

				<p></p>
				<div class="panel_title">
					<p style="display: flex; align-items: center;">Замовлення&nbsp;<img src="img/icon/buy_c.png" alt="" style="max-width: 40px;"></p>
				</div>
				<p></p>

			</div>
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<div class="panel_new">
				<?php
        $displayed_codes = array(); // Масив для збереження вже виведених кодів
        foreach ($buy_products_info as $data):
            if (!in_array($data['code'], $displayed_codes)): // Перевірка, чи код вже був виведений
                array_push($displayed_codes, $data['code']); // Додаємо код до списку виведених
    ?>
				<div class="card_new">
					<div class="card_left">
						<p><a href="order.php?data=<?php echo $data['code']; ?>"><img src="img/icon/pr_.png" alt="Контент - головна сторінка"></a></p>
						<p>Номер замовлення: &nbsp;<?php echo $data['code']; ?></p>
						<p>Статус: &nbsp;<?php echo $data['status']; ?></p>
					</div>

				</div>
				<?php
            endif;
        endforeach;
    ?>
			</div>


			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
			<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->



			<div class="block">
				<div class="info">
					<a href="">НАШІ КЛІЄНТИ</a>
					<div class="info_img">
						<span><img class="comp_img" src="img/companies/1.png" alt=""></span>
						<span><img class="comp_img" src="img/companies/2.png" alt=""></span>
						<span><img class="comp_img" src="img/companies/3.png" alt=""></span>
						<span><img class="comp_img" src="img/companies/4.png" alt=""></span>
						<span><img class="comp_img" src="img/companies/5.png" alt=""></span>
					</div>
				</div>
			</div>

			<a href="php/logout.php">
				<div class="block_title">


					<div class="panel_title">

						<p style="display: flex; align-items: center;"><img src="img/icon/logout.png" alt="" style="max-width: 40px;">&nbsp;Вийти</p>

					</div>

				</div>
			</a>

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
