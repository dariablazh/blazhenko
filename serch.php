<?php
session_start();
require_once 'php/connect.php'; // Подключение к БД

// Получение данных из таблицы продуктов
$info = [];
$result = mysqli_query($conn, "SELECT * FROM product_table");
while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
}

?>

<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">
	<title>Товари</title>
	<link rel="shortcut icon" href="img/icon/icon.png">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/menu.css">
	<link rel="stylesheet" href="css/info.css">
	<link rel="stylesheet" href="css/product.css">
	<link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" href="css/slider.css">
</head>

<body>
	<div class="wrapper">
		<!-- Header -->
		<header>
			<a href="index.php"><img src="img/icon/logo.png" alt=""></a>
			<div class="header_p">
				<p>Дубовицький</p>
				<p>завод</p>
				<p>сільгосптехніки</p>
			</div>
		</header>

		<!-- Navigation -->
		<div class="menu">
			<div class="block_m"><a href="index.php"><img src="img/icon/home.png" alt="">Головна</a></div>
			<div class="block_m"><a href="serch.php"><img src="img/icon/str.png" alt=""><b>Товари</b></a></div>
			<div class="block_m"><a href="delivery.php"><img src="img/icon/del.png" alt="">Доставка та оплата</a></div>
			<div class="block_m"><a href="description.php"><img src="img/icon/inf.png" alt="">Про нас</a></div>
			<div class="block_m"><a href="communication.php"><img src="img/icon/phon.png" alt="">Зв'язок</a></div>
			<div class="block_m"><a href="pass.php"><img src="img/icon/kab.png" alt="">Особистий кабінет</a></div>
		</div>

		<!-- Content -->
		<div class="content">
			
				<div class="block" id="product">
					<p>
						<input type="checkbox" id="fixPageCheckbox" onchange="togglePageFix(this)">
						<label for="fixPageCheckbox">ФІКСУВАТИ СТОРІНКУ</label>
					</p>

					<div class="product">
						<div class="panel" id="panel">
							<!-- Здесь будет отображаться контент товаров -->
							<?php 
                            $query = "SELECT * FROM product_table LIMIT 4"; // по умолчанию выводим первые 4 товара
                            $result = mysqli_query($conn, $query);
                            foreach ($result as $data) { 
                        ?>
							<div class="card">
								<div class="card_left">
									<p><a href="product.php?data=<?php echo $data['id_product']; ?>"><img src="<?= htmlspecialchars($data['image']); ?>" alt=""></a></p>
								</div>
								<div class="card_right">
									<p><?= htmlspecialchars($data['name']); ?></p>
									<p><?= htmlspecialchars($data['s_description']); ?></p>
									<p><?= htmlspecialchars($data['price']); ?> &nbsp;грн.</p>
								</div>
							</div>
							<?php } ?>
						</div>

						<div class="serch">
							<div class="serch_content">
								<form id="searchForm" method="POST">
									<p><a href="">ТОВАРИ</a></p>
									<div class="f_c">
										<?php
                                        $classification_query = "SELECT DISTINCT classification FROM product_table";
                                        $classification_result = mysqli_query($conn, $classification_query);
                                        while ($classification_row = mysqli_fetch_assoc($classification_result)) {
                                            $classification = $classification_row['classification'];
                                    ?>
										<br>
										<label>
											<input type="radio" name="classification" value="<?= htmlspecialchars($classification); ?>" required>
											<b><?= htmlspecialchars($classification); ?></b>
										</label><br><br>
										<?php
                                            $type_query = "SELECT DISTINCT type FROM product_table WHERE classification = '$classification'";
                                            $type_result = mysqli_query($conn, $type_query);
                                            while ($type_row = mysqli_fetch_assoc($type_result)) {
                                                $type = $type_row['type'];
                                        ?>
										<label>
											<input type="checkbox" name="type[]" value="<?= htmlspecialchars($type); ?>">
											<?= htmlspecialchars($type); ?>
										</label><br><br>
										<?php } // конец while для типов продуктов ?>
										<?php } // конец while для классификаций продуктов ?>
									</div>

									<button type="submit">Обрати</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Контент с информацией о клиентах -->
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
			
		</div>

			<!-- Footer -->
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

		 <script src="js/serch.js"> </script>
</body>

</html>
