{% block content %}is_teacher()

<div class="main-wrap pad-t-4 pad-b-7">

	<div class="title__wrapper center-content">
		<?= title() ?>

		<div class="center-content">
			<a href="<?= is_teacher() ? client_url('/teacher/simulation') : route('activities.grades.show', 3) ?>" class="button button--secondary">Indietro</a>
		</div>
	</div>


	<section class="interests mar-t-4">

		<?php foreach ($interests as $interestId => $interest) { ?>

			<a class="interest grid-flow center-content stack-content js-load load--fade-in" data-direction="bottom" data-delay="<?= $interestId % 2 ?>" id="area<?= $interestId ?>" href="<?= client_url('/interest?id=' . $interestId . '&watch=1' . ($legacyTestResultId == 151 ? '&highschool=1' : '')) ?>">
				<img src="<?= client_path($legacyTestResultId != 151 ? '/pages/assets/interests/highschool/' . $interestId . '.jpg' : '/pages/assets/interests/universities/' . $interestId) ?>" alt="" class="interest_img img-fill">
				<div class="interest_overflow"></div>
				<div class="interest_content">
					<h3 class="interest_title"><?= $interest['name'] ?></h3>
					<div class="interest_link button button--secondary">Scopri quest'area</div>
				</div>
			</a>

		<?php } ?>

	</section>
</div>

{% end content %}