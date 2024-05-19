{% extends blank %}

{% block body %}

<div class="page-container">
	<?php include_once(server_root() . '/app/templates/views/header.php'); ?>

	<main>
		{% place main %}
	</main>
</div>

<?php include_once(server_root() . '/app/templates/views/footer.php'); ?>

{% end body %}