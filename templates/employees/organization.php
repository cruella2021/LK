
<table class="bordered">
	<thead>
		<tr>
			<th>Организация</th>
			<th>ИНН</th>
			<th>КПП</th>
			<th>Сотрудники</th>
		</tr>
	</thead>
	<tbody>
		<?php if (!empty($paramTemplate)) : ?>
			<?php foreach ($paramTemplate as $Index_array => $Structure_organization) : ?>
				<tr>
					<td><a href='organization/<?= $Structure_organization->Code ?>'> <?= $Structure_organization->Name ?></a></td>
					<td><?= $Structure_organization->INN ?> </td>
					<td><?= $Structure_organization->KPP ?> </td>
					<td><?= $Structure_organization->Sum ?> </td>
				</tr>
			<? endforeach ?>
		<? endif ?>
	</tbody>
</table>