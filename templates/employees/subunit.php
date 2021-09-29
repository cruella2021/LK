<?php
$Code_organization = $id_organisation;
$Array_structures_subunit = $paramTemplate;
?>
<table class="bordered">
	<thead>
		<tr>
			<th>№</th>
			<th>Подразделение</th>
			<th>Количество</th>
		</tr>
	</thead>
	<tbody>
		<?php if (!empty($Array_structures_subunit)) : ?>

			<?php foreach ($Array_structures_subunit as $Index_array => $Structure_subunit) : ?>
				<tr>
					<td><?= $Index_array += 1 ?> </td>
					<td><a href='<?= $Code_organization ?>/<?= $Structure_subunit->Code ?> '><?= $Structure_subunit->Name ?></a></td>
					<td><?= $Structure_subunit->Sum ?></td>
				</tr>
			<? endforeach ?>
		<? endif ?>
	</tbody>
</table>
</div>