<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Список ролей</title>
	<link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
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

	<?php
    	include_once 'templates/part_page/popup_create_role.php';
	?>	

	</div>

	<script src="<?= BASE_URL ?>js/slider.js"></script>
	<script src="<?=BASE_URL?>js/popup.js"></script> 

</body>

</html>