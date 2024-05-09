<?php
require_once 'php/connect.php';
session_start();
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
header('Location: user.php');
exit; // не забывайте выходить из скрипта после перенаправления
}



if (!empty($_POST)) {

    $email = $_POST['email'];
     $password = $_POST['password'];

 $check_user_pass = mysqli_query($conn, "SELECT * FROM `user_table` WHERE `password` = '$password'");
$check_user_mail = mysqli_query($conn, "SELECT * FROM `user_table` WHERE `mail` = '$email'");
if ($check_user_mail && $check_user_pass && mysqli_num_rows($check_user_mail) > 0 && mysqli_num_rows($check_user_pass) > 0 ) {
    
    $user = mysqli_fetch_assoc($check_user_mail);
    $_SESSION['user'] = [
            "id_user" => $user['id_user'],
            "f_name" => $user['name'],
            "l_name" => $user['surname'],
            "email" => $user['mail'],
             "phone" => $user['phone'],
           
        
           
];
    
    header('Location: user.php');
} else if($check_user_mail && $check_user_pass && mysqli_num_rows($check_user_mail) > 0 && mysqli_num_rows($check_user_pass) == 0 ){
    $_SESSION['message'] = $email . '<br> Не вірний пароль!';
}else {
    $_SESSION['message'] = $email . '<br> Користувач не знайдений!';
    echo mysqli_error($conn); 
}

}
?>
<!DOCTYPE html>
<html lang="ua">

<head>
	<meta charset="UTF-8">

	<title>Вхід</title>


	<link rel="shortcut icon" href="img/icon/icon.png">

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/menu.css">

	<link rel="stylesheet" href="css/info.css">
	<link rel="stylesheet" href="css/product.css">
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
			<div class="block_m"><a href="pass.php"><img src="img/icon/pass.png" alt=""><b>Вхід у кабінет</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div>

		</div>

		<div class="content">

			<div class="block">

				<div class="info">
					<br> <a href="">ВХІД У КАБІНЕТ</a>

					<form action="" method="POST">


						<label for="name">Електронна адреса:</label>
						<input type="email" maxlength="50" name="email" required placeholder="Ваша електронна адреса">

						<label for="name">Пароль:</label>
						<input type="password" maxlength="20" name="password" id="password" required placeholder="Введіть пароль">
						<br>



						<button type="submit">Вхід</button>



					</form>
					<a class="a_form" href="reg.php">У вас ще не має аккаунту?</a>

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

	<script src="js/slider.js"></script>
</body>

</html>
