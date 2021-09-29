<?php
	$Array_structures_subunit_employee = $paramTemplate;
	$Code_organization = $id_organisation;
	/*
	echo '<pre>';
	print_r($Array_structures_subunit_employee);
	echo '</pre>';
	*/
?>


<table class="bordered">
	<thead>
		<tr>
			<th>№</th>
			<th>Табельный номер</th>
			<th>ФИО</th>
			<th>Должность</th>
		</tr>
	</thead>
	<tbody>

		<?php if (!empty($Array_structures_subunit_employee)) : ?>
			<?php foreach ($Array_structures_subunit_employee as $Index_array_subunit => $Array_subunit) : ?>
				<?php foreach ($Array_subunit as $Subunit_name => $Structures_subunit_array_employee) : ?>

					<?php $start_sumbol = strripos($Subunit_name, '[') ?>
					<?php $end_sumbol = strripos($Subunit_name, ']') ?>

					<?php $Part_code_subunit = mb_strcut($Subunit_name, $start_sumbol + 1, $end_sumbol = -2) ?>
					<?php $Part_name_sumunit = mb_strcut($Subunit_name, 0, $start_sumbol) ?>
					<tr>
						<td colspan='4'>
							<h3>
								<a href='<?= $Part_code_subunit ?>'><?= $Part_name_sumunit ?></a>
								<h3>
						</td>
					</tr>

					<?php foreach ($Structures_subunit_array_employee as $Index_employee => $Structures_employee) : ?>
						<tr>
							<td><?= $Index_employee += 1 ?></td>
							<td><?= $Structures_employee->PersonnelNumber ?></td>
							<td><a href='<?= $Part_code_subunit ?>/<?= $Structures_employee->EmployeeCod ?>'><?= $Structures_employee->Employee ?></td>
							<td><?= $Structures_employee->Position ?></td>
						</tr>
					<? endforeach ?>
				<? endforeach ?>
			<? endforeach ?>
		<? endif ?>
	</tbody>
</table>