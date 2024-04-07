{% extends main %}

{% block main %}

<div id="body" class="main-wrap pad-t-5 pad-b-7">

	<!-- Main content -->
	<section id="content">

		{% place content %}

		<div class="page-footer grid-flow center-content max-width--480 place-center mar-t-4" data-spacing="400">
			<a href="<?= $returnLink ?>" class="button button--secondary button--full-width">Indietro</a>

			<div id="print" class="button button--full-width" onClick="window.print();">
				<?= embed_icon('print') ?>
				Stampa questa pagina
			</div>
		</div>

	</section>

</div>

<!-- Scroll back to top -->
<a href="#content" id="scroll" class="round bgr-c1-h top">
	<div class="icon cen bgr-wht" <?= icon_svg('navigation/arrow1-top') ?>></div>
</a>

{% end main %}