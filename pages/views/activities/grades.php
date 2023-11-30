<?php

use app\Models\Activities\Grade;
use SchoolSystem\Grade as SchoolSystemGrade;

?>

{% block main %}

<div class="grades flex-group main-wrap <?= $schoolClass->isMiddleSchool ? 'grades--middleschool' : 'grades--highschool' ?>">

	<?php for ($i = $schoolClass->minimumGrade; $i <= $schoolClass->currentGrade; $i++) {
		$year = new SchoolSystemGrade($i);
		$grade = new Grade($i);
	?>

		<a class="grade <?= $year->id == $schoolClass->currentGrade ? 'grade--highlighted' : '' ?>" href="?grade=<?= $year->id ?>">
			<div class="js-load load--fade-in" data-direction="bottom" data-delay="<?= $i ?>">
				<h3 class="grade__number ff-serif"><?= $year->romanNumeral ?></h3>

				<div class="grade__content">
					<div class="grade__body grid-flow center-content" data-spacing="700">
						<h3 class="grade__name colored-title">Attività del<br><?= strtolower($year->adjective) ?> anno</h3>
						<p class="grade__text">Clicca qui ver visualizzare tutte le attività previste per il <?= $year->adjective ?> anno</p>
					</div>

					<div class="grade__footer grid-flow contrasting-background" style="--_percentage: <?= $grade->completedPercentage() ?>">
						<p class="grade__progress"><?= $grade->completedPercentage() ?> %</p>
					</div>
				</div>
			</div>
		</a>

	<?php } ?>

</div>

{% end main %}