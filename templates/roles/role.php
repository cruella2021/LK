<button class="actionRole createRole"> <span> Создать роль</span></button>
<table class="bordered">
	<thead>
		<tr>
			<th>Действие</th>	
			<th>№</th>
			<th>Роль</th>
			<th>Права администратора</th>
		</tr>
	</thead>

	<tbody class="table-role">
		<?php foreach ($Assoc_array_list_role as $Index_array => $Info_role) : ?>
			<tr>
				<td><button class="actionRole delRole"
					data-id_role=<?= $Info_role['id_role'] ?>
					>Удалить</button>
				</td>	
				<td><?= ++$Index_array ?> </td>
				<td><?= $Info_role['name_role'] ?></td>

				<td><?php if ($Info_role['is_admin'] == '1') : ?>
						<?= 'Истина' ?>
					<? endif ?>
				</td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>