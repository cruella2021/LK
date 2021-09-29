<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Организации</title>
	<link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">

</head>

<body>
	<div class="wrapper">
		<?php
		include_once 'templates/part_page/slider.php'
		?>
		<!--Контент-->
		<div class="content">

			<?php
			include_once 'templates/part_page/nav.php'
			?>
			<!--Основная часть-->
			<div class="main">
				{{ Content }}
			</div>
		</div>

		<!--Подвал-->
		<?php
		include_once 'templates/part_page/footer.php'
		?>

	</div>
	
	<script src="<?= BASE_URL ?>js/slider.js"></script>
</body>

</html>