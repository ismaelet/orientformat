{% block main %}

<div class="page__wrapper grid-flow">
	<div class="page__content grid-flow" data-spacing="800">
		<h1 class="">Orientamento<br><span class="highlight">Formativo</span></h1>
		<p class="page__subtitle"><?= __('home.description') ?></p>

		<a href="<?= route('activities.grades.index') ?>" class="page__button button"><?= __('Start') ?></a>
	</div>

	<div class="page__images grid-flow center-content stack-content">
		<div class="page__background fill-all" <?= background_image(($student->isMiddleSchoolStudent() ? 'middleschool' : 'highschool') . '-background.webp') ?>></div>
		<img class="page__image load--fade-in js-load" data-direction='right' data-delay="3" src="<?= client_path(($student->isMiddleSchoolStudent() ? 'middleschool' : 'highschool') . '-image.webp') ?>" alt="">
	</div>
</div>

{% end main %}