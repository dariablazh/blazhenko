<?php
session_start();
$email = ""; // Устанавливаем значение переменной $email до использования
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
     header('Location: user.php');
     exit; // не забывайте выходить из скрипта после перенаправления
}

require_once 'php/connect.php';

if (!empty($_POST)) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $check_user = mysqli_query($conn, "SELECT * FROM `user_table` WHERE `mail` = '$email'");
    if (mysqli_num_rows($check_user) < 1) {
        $result = mysqli_query($conn, "INSERT INTO `user_table` (`id_user`, `name`, `surname`, `phone`, `mail`, `password`) VALUES (NULL, '$name', '$surname', '$phone', '$email', '$password')");
        header('Location: pass.php');
    } else {
        $_SESSION['message'] = $email . '<br> Така пошта вже використовується!';
    }
}


?>
<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">

	<title>Реєстрація</title>


	<link rel="shortcut icon" href="img/icon/icon.png">

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/menu.css">

	<link rel="stylesheet" href="css/info.css">
	<link rel="stylesheet" href="css/product.css">
	<link rel="stylesheet" href="css/form.css">
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
			<div class="block_m"><a href="pass.php"><img src="img/icon/reg.png" alt=""><b>Реєстрація</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </a></div>

		</div>

		<div class="content">

			<div class="block">

				<div class="info">
					<br> <a href="">СТОРІНКА РЕЄСТРАЦІЇ</a>
					<div class="info_p">
						<form action="" method="post">

							<label for="name">Ім'я:</label>
							<input type="text" maxlength="20" name="name" required>
							<label for="name">Прізвище:</label>
							<input type="text" maxlength="20" name="surname" required>
							<label for="name">Телефон:</label>
							<input type="tel" maxlength="10" name="phone" required>

							<label for="name">Електронна адреса:</label>
							<input type="email" maxlength="50" name="email" required>

							<label for="name">Пароль:</label>
							<input type="password" maxlength="20" name="password" id="password" required placeholder="Введи надійний пароль">
							<br>
							<input type="password" maxlength="20" name="confirm_pass" id="confirm_pass" required placeholder="Повтори свій пароль">


							<p class="mes" style="color:red;">
								<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; unset($_SESSION['message']); ?>
							</p><br>


							<button type="submit" name="upload" value="UPLOAD">Реєстрація</button>


						</form>
						<a href="pass.php">У вас уже є акаунт?</a>

						<script>
							const passwordInput = document.getElementById('password');
							const confirmPasswordInput = document.getElementById('confirm_pass');
							const submitButton = document.querySelector('button[type="submit"]');


							function checkPasswords() {
								if (passwordInput.value === confirmPasswordInput.value) {

									confirmPasswordInput.setCustomValidity('');
								} else {

									confirmPasswordInput.setCustomValidity('Не вірний пароль!');
								}
							}

							confirmPasswordInput.addEventListener('input', checkPasswords);
							passwordInput.addEventListener('input', checkPasswords);

						</script>

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
