{% block main %}

<div class="grades flex main-wrap <?= $class->isMiddleSchool() ? 'grades--middleschool' : 'grades--highschool' ?>">

	<?php foreach ($grades as $key => $grade) { ?>

		<a class="grade <?= $grade->id == $class->grade ? 'grade--highlighted' : '' ?>" href="<?= route('activities.grades.show', $grade->id) ?>">
			<div class="js-load load--fade-in" data-direction="bottom" data-delay="<?= $key ?>">
				<h3 class="grade__number ff-serif"><?= $grade->romanNumeral() ?></h3>

				<div class="grade__content">
					<div class="grade__body grid center-content gap-4">
						<h3 class="grade__name colored-title"><?= __('misc.grade-description', ['numeral' => __($grade->ordinal())]) ?></h3>
						<p class="grade__text">
							<?= __('misc.grade-cta', ['numeral' => __($grade->ordinal())]) ?>
						</p>
					</div>

					<div class="grade__footer grid contrasting-background" style="--_percentage: <?= $student->percentageSectionsCompletedInGrade($grade) ?>">
						<p class="grade__progress"><?= $student->sectionsCompletedInGrade($grade) ?> / <?= $grade->completable_sections->count() ?></p>
					</div>
				</div>
			</div>
		</a>

	<?php } ?>

</div>

{% end main %}