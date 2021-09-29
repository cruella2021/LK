<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?= $titlePage ?> </title>
	<link rel="icon" href="<?= BASE_URL ?>favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="<?= BASE_URL ?>favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?= BASE_URL ?>css/reset.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>css/base.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>

<body>
	<header>
		<div class="container">
			<div class="header_image"> 
				<div class="slider_image image_back_1 im_active"></div>
				<div class="slider_image image_back_2"></div>
				<div class="slider_image image_back_3"></div>
			</div>
	</header>

	<div class="container">

		<?php include_once 'templates/part_page/nav.php' ?>

		<!--Контент-->
		<div class="container">
			<div class="main">
				{{ Content }}
			</div>

		</div>

	</div>

	{{ Hidden content }}

	{{ Connect_script }}
	<script src="js/header.js"></script>
</body>

</html>