<?php

use \Legacy\SchoolSystem\SchoolClass;

$schoolId = $_GET['schoolId'];

$schoolClasses = \System\Classes\DBOld::select(SchoolClass::INDEX . ' FROM ' . SchoolClass::TABLE . ' WHERE ' . SchoolClass::SCHOOL_INDEX . ' = ? ORDER BY startingYear DESC, grade ASC, letter ASC', [$schoolId]);

?>

<p class="form-lbl">Classe:</p>
<select name="schoolClassId" class="sel js-grade" required>

	<?php while ($schoolClassRow = $schoolClasses->fetch_assoc()) {
		$schoolClass = new SchoolClass($schoolClassRow[SchoolClass::INDEX]);
	?>

		<option value="<?= $schoolClass->id ?>">
			<?= $schoolClass->name . ' (' . $schoolClass->yearRangeString . ')' ?>
			- Ref. <?= $schoolClass->referent->fullName ?>
		</option>

	<?php } ?>

</select>