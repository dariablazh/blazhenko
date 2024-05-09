<?php
session_start();
require_once 'php/connect.php';

if (!$_SESSION['user']) {
    header('Location: pass.php');
}

$user = $_SESSION['user']['id_user'];
// Перевірка, чи параметр 'data' присутній у GET-запиті
if (isset($_GET['data'])) {
    $new_data = $_GET['data'];

    // Запит до бази даних для отримання продукту
    $result = mysqli_query($conn, "SELECT * FROM product_table WHERE `id_product` = '$new_data'");
    $row = mysqli_fetch_assoc($result);

    // Перевірка на кнопку 'buy'
    if (isset($_POST['add'])) {
        // Перевірка, чи сесійний користувач існує
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user']['id_user'];

            $result = mysqli_query($conn, "SELECT id_favorite, count FROM favorites_table WHERE id_user = '$user' AND id_product = '$new_data'");
            if ($row = mysqli_fetch_assoc($result)) {
                // запис із заданим id_product вже існує, оновлюємо кількість
                $new_count = $row['count'] + 1;
                $fav_id = $row['id_favorite'];
                $update = mysqli_query($conn, "UPDATE favorites_table SET count = '$new_count' WHERE id_favorite = '$fav_id' AND id_user = '$user'");
                header('Location: user.php');
                exit;
            } else {
                // Продукт не знайдено, додавання нового запису з кількістю 1
                $insert = mysqli_query($conn, "INSERT INTO `favorites_table` (`id_favorite`, `id_product`, `id_user`, `count`, `status`) VALUES (NULL, '$new_data', '$user', 1, 'selected')");
                header('Location: user.php');
                exit;
            }
        } else {
            // Якщо користувач не залогінений, перенаправляємо на сторінку входу
            header('Location: pass.php');
            exit;
        }
    }
} else {
    // Якщо параметр 'data' відсутній, можна перенаправити користувача або вивести повідомлення
    echo "Required data is missing!";
}
?>


<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">

	<title>Продукт</title>


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

			<div class="block">
				<div class="info">
					<br>
					<div class="info_img">
						<span> <img class="img_content" src="<?= $row['image']; ?>" alt="Контент - головна сторінка"></span>

					</div>
				</div>
			</div>

			<div class="block">



				<div class="info">
					<br><a href="">Опис:</a><br>
					<div class="info_p">
						<p style="line-height: 1.6;"><?= $row['name']; ?></p>
						<p style="line-height: 1.6;"><?= $row['description']; ?></p>
						<p class="p_price" style="line-height: 1.6;">Ціна: &nbsp;<?= $row['price']; ?>&nbsp;грн</p>
					</div>
				</div>


			</div>


			<div class="block">

				<div class="info">


					<form action="" method="POST">

						<div class="block_button">
						<?php 
						$info_f = [];
						$status = ''; // Ініціалізуємо змінну $status перед циклом

						// Перевірка, чи змінна $user визначена перед викликом запиту SQL
						if (isset($user)) {
							$result_f = mysqli_query($conn, "SELECT * FROM favorites_table WHERE `id_product` = $new_data AND `id_user` = $user");

							// Перевірка наявності результату запиту
							if ($result_f) {
								while ($row_f = mysqli_fetch_assoc($result_f)) {
									$info_f[] = $row_f;
									$status = $row_f['status']; // Оновлюємо значення $status всередині циклу
								}
							} else {
								// Обробка помилки запиту
								echo "Помилка запиту до бази даних: " . mysqli_error($conn);
							}

							// Перевіряємо значення $status після завершення циклу і виводимо кнопку тільки один раз
							if ($status == 'cart') {
								echo "<button type=\"submit\" name=\"add\"><img src=\"img/icon/kor.png\"><p>В кошик</p></button>";
							} else {
								echo "<button type=\"submit\" name=\"add\"><img src=\"img/icon/sel.png\"><p>В обране</p></button>";
							}
						} else {
							// Обробка випадку, коли змінна $user не визначена
							echo "Змінна \$user не визначена.";
						}
					?>



						</div>



					</form>
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
