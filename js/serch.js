  // JavaScript функция для отправки AJAX запроса при отправке формы
  document.getElementById('searchForm').addEventListener('submit', function (event) {
  	event.preventDefault(); // Предотвращаем отправку формы по умолчанию
  	var formData = new FormData(this); // Получаем данные формы
  	var xhr = new XMLHttpRequest();
  	xhr.onreadystatechange = function () {
  		if (xhr.readyState == XMLHttpRequest.DONE) {
  			if (xhr.status == 200) {
  				document.getElementById('panel').innerHTML = xhr.responseText;
  			}
  		}
  	};
  	xhr.open('POST', 'get_new_content.php', true);
  	xhr.send(formData);
  });

  // JavaScript функция для фиксации страницы
  function togglePageFix(checkbox) {
  	var body = document.body;
  	if (checkbox.checked) {
  		body.style.overflow = "hidden"; // Запрещаем прокрутку
  	} else {
  		body.style.overflow = ""; // Разрешаем прокрутку
  	}
  }
