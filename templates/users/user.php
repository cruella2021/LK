
<button class="actionUser createUser"> <span> Создать порльзователя</span></button>

<table class="bordered">
	<thead>
		<tr>
			<th>Действие</th>
			<th>№</th>
			<th>Логин</th>
			<th>Описание</th>
			<th>Роль пользователя</th>
			<th>Код сотрудника</th>
		</tr>
	</thead>

	<tbody id="table_body_user" class="table-users">
		<?php foreach ($Assoc_array_list_user as $Index_array => $Info_user) : ?>
			<tr>
				<td>
					<button class="actionUser delUser"
					data-id_user=<?= $Info_user['id_user'] ?>
					>Удалить</button>
					
					<button class="actionUser changeUser"
					data-id_user=<?= $Info_user['id_user'] ?>
					data-name_login=<?= $Info_user['name_user'] ?>
					data-descriptio=<?= $Info_user['description_user'] ?> 
					data-id_role=<?= $Info_user['id_role'] ?>
					data-id_1c=<?= $Info_user['id_1C'] ?>
					>Изменить</button>

				</td>
				<td><?= ++$Index_array ?> </td>
				<td>
					<?= $Info_user['name_user'] ?>
				</td>
				<td><?= $Info_user['description_user'] ?> </td>
				<td><span><?= $Info_user['name_role'] ?></span></td>
				<td><span><?= $Info_user['id_1C'] ?></span></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
