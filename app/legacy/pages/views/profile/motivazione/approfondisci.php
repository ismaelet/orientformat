{% block content %}

<div class="main-wrap mar-b-5">

	<div class="title__wrapper">
		<?= title() ?>
		<?= submit() ?>
	</div>

	<?php if ($sibling->completed) { ?>


		<div id="grid-box" class="mar-t-5">

			<?php foreach ($titles as $key => $title) { ?>

				<div id="title<?= $key ?>" class="area__title-box js-load load--fade-in" data-direction="<?php switch ($key) {
				    case 1:
				    case 2:
				    case 12:
				        echo 'bottom';
				        break;
				    case 3:
				    case 5:
				    case 11:
				        echo 'right';
				        break;
				    case 4:
				    case 6:
				    case 10:
				        echo 'left';
				        break;
				    default:
				        echo 'top';
				} ?>" data-delay="1">
					<p class="area__title fa-center txt-12rem font-bold"><?= $title[0] ?></p>
				</div>

			<?php } ?>

			<div id="grid" class="grid">

				<?php foreach ($boxes as $key => $box) { ?>

					<div id="box<?= $key ?>" class="box group<?= $box['group'] ?> js-load load--fade-in clickable" data-direction="top" data-delay="<?= ($key * 3) % 7 ?>">
						<div class="result cen score<?= $box['result'] ?>"></div>

						<div class="question cen">
							<h1 class="txt-1rem fa-center font-bold mar-b-05"><?= __('Question') ?>:</h1>
							<p class="fa-center txt-ita"><?= $box['question'] ?></p>
						</div>
					</div>

				<?php } ?>

				<div id="center"></div>

			</div>
		</div>
</div>

<?php } else {
    echo no_results();
} ?>

{% end content %}