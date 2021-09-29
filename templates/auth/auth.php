<?php

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Авторизация</title>	
		<link rel="stylesheet" href="<?= BASE_URL ?>css/auth.css">
	
	</head>
<body>
	<form name="auth">
		<label>Логин</label>
		<input type="text" name="login" placeholder="Введите логин">
		<label>Пароль</label>
		<input type="password" name="password" placeholder="Введите пароль">
		
		<button id="auth_user" type="submit"> Войти </button>
		
		<p id="auth_error" class="error none"></p>
	<form>
	
	<script src="<?= BASE_URL ?>js/job_user.js"></script>
</body>
</html>