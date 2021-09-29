<?php
	$Structure_employee =  $paramTemplate;
?>

<div class="employee-info">
	<div class="employee-image">
		<img id="Photo_employee" src="<?=BASE_URL?>images/employee/default" alt="Image not found" class="employee-size">
	</div>
	<div class="employee-data">
		<table class="bordered">
			<thead>
				<tr>
					<th colspan='2'>
						<h2><?= $Structure_employee->Employee ?></h2>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Организация:</td>
					<td><?= $Structure_employee->Organization ?></td>
				</tr>
				<tr>
					<td>Подразделение: </td>
					<td><?= $Structure_employee->Subdivision ?></td>
				</tr>
				<tr>
					<td>Должность: </td>
					<td><?= $Structure_employee->Position ?></td>
				</tr>
				<tr>
					<td>Табельный номер:</td>
					<td><?= $Structure_employee->PersonnelNumber ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php if ($Structure_employee != null and !empty($Structure_employee->Briefing)) : ?>
	<h2>Текущие инструктажи</h2>
	<table class="bordered">
		<thead>
			<tr>
				<th>Организация</th>
				<th>Инструктаж</th>
				<th>Дата начало</th>
				<th>Дата окончания</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($Structure_employee->Briefing as $Structure_briefing) : ?>
				<tr>
					<td><?= $Structure_briefing->Organization ?></td>
					<td><?= $Structure_briefing->Briefing ?></td>
					<td><?= $Structure_briefing->DateStart ?></td>
					<td><?= $Structure_briefing->DateEnd ?></td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
<? endif ?>

<?php if ($Structure_employee != null and !empty($Structure_employee->Certificate)) : ?>
	<h2>Сертификаты сотрудника</h2>
	<table class="bordered table-cert">
		<thead>
			<tr>
				<th>Сертификат</th>
				<th>Инструктаж</th>
				<th>Дата начало</th>
				<th>Дата окончания</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($Structure_employee->Certificate as $Structure_certificate) : ?>
				<tr>
					<td><span class="Certificate" id="<?= $Structure_certificate->Certificate_code ?>"><?= $Structure_certificate->Certificate_name ?></span></td>
					<td><?= $Structure_certificate->Briefing ?></td>
					<td><?= $Structure_certificate->Certificate_DateStart ?></td>
					<td><?= $Structure_certificate->Certificate_DateEnd ?></td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
<? endif ?>
<script src="<?= BASE_URL ?>js/asinc_load.js"></script>
