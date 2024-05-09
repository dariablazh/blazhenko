<?php
require_once 'connect.php';


// Отримуємо дані з форми
if (!empty($_POST)) {
	
	 $table_name = "product_table";
  $link = "../admin/admin.php";
	
    $name = $_POST['name'];
    $classification = $_POST['classification'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $s_description = $_POST['s_description'];
    $price = $_POST['price'];
	
	
	 $upload_dir = '../img/card/1/';  
         $file = $_FILES['image']['name'];
         $file_path = $upload_dir . time() . $file;
	
	
	
  $exists = mysqli_query($conn, "SELECT COUNT(*) FROM $table_name WHERE name = '$name' AND classification = '$classification'");
  $exists_count = mysqli_fetch_row($exists)[0]; // беремо перший елемент з масиву

  // Оновлення запису, якщо він вже існує
  if ($exists_count > 0) {
    // Запис з таким табельним номером та підрозділом вже існує, оновлюємо його
    $result = mysqli_query($conn, "UPDATE $table_name SET
      `name` = '$name',
      `classification` = '$classification',
      `type` = '$type',
      `description` = '$description',
      `s_description` = '$s_description',
      `image` = '$file_path',
	  `price` = '$price'
    WHERE name = '$name' AND classification = '$classification'");

  } 
	else {
    // Запису з таким табельним номером та підрозділом не існує, додаємо новий
    $result = mysqli_query($conn, "INSERT INTO `$table_name` (`id_product`, `name`, `classification`, `type`, `description`, `s_description`,`image`, `price`)
    VALUES (NULL, '$name', '$classification', '$type', '$description', '$s_description', '$file_path', '$price')
    ON DUPLICATE KEY UPDATE
    `name` = '$name',
      `classification` = '$classification',
      `type` = '$type',
      `description` = '$description',
      `s_description` = '$s_description',
      `image` = '$file_path',
	  `price` = '$price';");
		
		
 
  }
	move_uploaded_file($_FILES['image']['tmp_name'], "$file_path");
}
 header('Location: ' . $link);
?>