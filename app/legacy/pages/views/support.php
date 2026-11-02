{% block main %}

<div class="main-wrap">

	<?php if (! $categoryId && ! $topicId) { ?>

		<section class="category-selector">
			<h1 class="category-selector_title txt-sbold">Come possiamo aiutarti?</h1>
			<p class="txt-12rem mt-2">Seleziona un argomento dalla lista qui sotto</p>
			<div class="categories">

				<?php foreach ($categories as $category) { ?>

					<a class="category" href="?category=<?= $category['id'] ?>">
						<div class="category_icon icon-box">
							<?= embed_icon('category-'.$category['slug']) ?>
						</div>
						<h3 class="category_name"><?= $category['name'] ?></h3>
					</a>

				<?php } ?>

			</div>
		</section>

	<?php } elseif ($categoryId) { ?>

		<section class="selected-category">
			<div class="selected-category_head">
				<div class="selected-category_icon icon-box">
					<?= embed_icon('category-'.$categoryData['slug']) ?>
				</div>
				<h1 class="category-selector_title txt-sbold"><?= $categoryData['name'] ?></h1>
				<h3 class="selected-category_subtitle txt-med"><a href="?">
						< Indietro</a>
				</h3>
			</div>

			<div class="topics">

				<?php foreach ($topics as $topic) { ?>

					<div class="topic <?= $topicId == $topic['id'] ? 'active' : '' ?> js-topic" id="topic<?= $topic['id'] ?>" data-id="<?= $topic['id'] ?>">
						<h3 class="topic_title js-open-topic"><?= $topic['name'] ?></h3>
						<p class="topic_text js-topic-text"><?= _fill_text($topic['text'], $topic['id']) ?></p>
					</div>

				<?php } ?>

			</div>
		</section>

	<?php } ?>

</div>

<div class="modal" id="img-modal">
	<div class="modal_close"></div>
	<img src="" alt="" class="modal-img js-close-modal">
</div>

{% end main %}