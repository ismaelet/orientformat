{% extends main %}

{% block main %}

<div id="body" class="main-wrap pad-t-5">

	<!-- Main content -->
	<section id="content">

		{% place content %}

		<div class="center-content">
			<div id="print" class="button push-center button--auto-width mar-t-4" onClick="window.print();">
				<?= embed_icon('print') ?>
				Stampa questa pagina
			</div>
		</div>

	</section>

	<!-- Glossary -->
	<section id="glossary" class="pad-b-5">

		<h1 class="txt-bold">Glossario minimo</h1>

		<div id="recap" class="mar-t-3 mar-b-5">

			<?php foreach ($glossary as $letter) { ?>

				<div class="letter mar-b-1 br-b-1 br-c brb-dashed pad-b-1">

					<p class="txt-25px txt-bold"><?= $letter[0] ?></p>

					<?php foreach ($letter[1] as $entry) { ?>
						<a href="#g-<?= $entry[1] ?>">
							<p class="entry txt-1rem txt-c1-h mar-b-05 padl1 inlb"><?= $entry[0] ?></p><br>
						</a>
					<?php } ?>

				</div>

			<?php } ?>

		</div>

		<div id="entries" class="mar-t-2">

			<?php foreach ($entries as $key => $entry) { ?>

				<div id="g-<?= $entry['tag'] ?>" class="entry mar-b-2">

					<div class="title-box inlb mar-b-1">
						<h1 class="entry__title"><?= $entry['title'] ?></h1>
					</div>

					<p class="txt-09rem"><?= $entry['text'] ?></p>

				</div>

			<?php } ?>

		</div>

	</section>

</div>

<!-- Scroll back to top -->
<a href="#content" id="scroll" class="round bgr-c1-h top">
	<div class="icon cen bgr-wht" <?= icon_svg('navigation/arrow1-top') ?>></div>
</a>

{% end main %}