{% block form-body %}

<?php switch ($pageType) {
	case 'new-middleschool':
	case 'new-highschool':
		generate_form($formInputs, false, $error);
		break;

	case 'collaborate': ?>
		<p>Scegli la classe a cui vuoi partecipare alla gestione:</p>

		<div class="form-field">
			<p class="form-lbl">Istituto:</p>
			<select name="schoolId" class="sel js-school" required>
				<option value="" disabled selected>- Seleziona un istituto -</option>
				<?php while ($school = $schools->fetch_assoc()) { ?>
					<option value="<?= $school['id'] ?>"><?= $school['name'] ?></option>
				<?php } ?>
			</select>
		</div>

		<div class="form-field js-grade-container">
			<!-- Ajax generated content -->
		</div>
	<?php
		break;

	case 'requested': ?>
		<p>Abbiamo inviato la richiesta di collaborazione a <strong><?= $schoolClass->referent->fullName ?></strong>. Per favore, attendi che la richiesta sia accettata per poter cominciare a contribuire alla gestione della classe.</p>
	<?php
		break;

	default: ?>
		<p>Vuoi aggiungere una nuova classe o vuoi collaborare alla gestione di una classe già creata da un altro docente?</p>
<?php
		break;
} ?>

{% end form-body %}

{% block form-footer %}

<?php switch ($pageType) {
	case 'new-middleschool':
	case 'new-highschool': ?>
		<button type="submit" name="add" class="button">Aggiungi</button>
		<a href="<?= client_url('/teacher') ?>" class="button button--secondary">Indietro</a>
	<?php
		break;

	case 'collaborate': ?>
		<button type="submit" name="collaborate" class="button js-collaborate" disabled>Aggiungi</button>
		<a href="<?= client_url('/teacher') ?>" class="button button--secondary">Indietro</a>
	<?php
		break;

	case 'requested': ?>
		<a href="<?= client_url('/teacher') ?>" class="button button--secondary">Indietro</a>
	<?php
		break;

	default: ?>
		<a href="?type=new-middleschool" class="button">Aggiungi una classe della scuola secondaria di primo grado</a>
		<a href="?type=new-highschool" class="button">Aggiungi una classe della scuola secondaria di secondo grado</a>
		<a href="?type=collaborate" class="button button--secondary">Aggiungi una classe già esistente</a>
<?php
		break;
} ?>

<?php if ($pageType == 'new-highschool') { ?>

	<script defer>
		document.addEventListener('DOMContentLoaded', function() {
			const schoolClassSelector = '[name="school_class_type"]';
			const schoolClassNameInput = document.querySelector('[name="letter"]');
			const gradeInput = document.querySelector('[name="grade"]');
			const visibleGradeInput = document.querySelector('[name="visible_grade"]');

			schoolClassNameInput.addEventListener('keyup', function() {
				select_grade();
			})

			document.querySelectorAll(schoolClassSelector).forEach((element) => {
				element.addEventListener('input', function() {
					select_grade();
				})
			})

			function select_grade() {
				const isProfessional = document.querySelector(`${schoolClassSelector}:checked`).value == 'P';
				const validGrades = isProfessional ? [1, 2, 3, 4] : [1, 2, 3, 4, 5];

				let relativeGrade = parseInt(schoolClassNameInput.value.replace(/[a-zA-Z]/g, ''));

				relativeGrade = validGrades.includes(relativeGrade) ? relativeGrade : 1;

				const fullGradeName = isProfessional ? `${relativeGrade + 3}-P` : relativeGrade + 3;

				gradeInput.value = fullGradeName;
				visibleGradeInput.value = relativeGrade;
			}
		})
	</script>

<?php } ?>

{% end form-footer %}