<nav>
	<ul class="top_menu black_fon">
		<li class="top_menu__item"><a href="<?= BASE_URL ?>main">Главная</a></li>
		<li class="top_menu__item"><a href="<?= BASE_URL ?>organization">Сотрудники</a></li>
		<li class="top_menu__item"><a href="<?= BASE_URL ?>contacts">Контакты охраны труда</a></li>
		<?php if ( !empty($_SESSION['Admin']) ) : ?>
			<li class="top_menu__item befor">
			<a href="#">Управление доступом</a>
			
			<ul class="submenu">
				<li class="subtop_menu__item"><a href="<?= BASE_URL ?>users">Список пользователей</a></li>
				<li class="subtop_menu__item"><a href="<?= BASE_URL ?>roles">Список ролей</a></li>
			</ul>
			</li>
		<? endif ?>
		<li class="top_menu__item"><a href="<?= BASE_URL ?>exit">Выход (<?= $_SESSION['User'] ?>) </a></li>
	</ul>
</nav>