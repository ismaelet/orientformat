{% block main %}

<!-- Slider -->
<section id="slider">

    <div id="bgr-img" class="bgr" <?php

use App\Legacy\LegacyDB;

?><?= background_image('/pages/assets/teacher/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pb-20">

    <!-- Title -->
    <div class="title-box mar-t-4 fa-center">
        <h1 class="title txt-25rem txt-sbold">Progresso per area</h1>
        <p class="stitle txt-1rem mar-t-1">Qui puoi controllare quali macro-aree sono state completate, per avere una panoramica generale dell'andamento della classe.<br>Per avere di risultati più specifici è possibile tornare indietro e usare il pannello <strong>Progresso per attività</strong>.</p>
        <a href="<?= route('teacher.dashboard') ?>" class="button button--secondary back">Torna alla gestione</a>
    </div>

    <?php if ($students->num_rows) { ?>

        <!-- List -->
        <div id="list" class="panel mar-t-3">
            <div class="list">

                <div class="head">
                    <p class="field field-l">Studente</p>
                    <p class="field field-m">Profilo</p>
                    <p class="field field-m">Competenze</p>
                    <p class="field field-m">Saperi</p>
                </div>

                <?php while ($student = $students->fetch_assoc()) { ?>

                    <form method="POST" class="row">

                        <p class="field"><?= $student['last_name'].' '.$student['first_name'] ?></p>
                        <p class="field"><?= LegacyDB::exists('progress_areas WHERE progress=100 AND areaID=1 AND userID = ?', $student['id']) ? '<span class="txt-gre font-bold">Completato</span>' : '<span class="txt-red">Non completato</span>' ?></p>
                        <p class="field"><?= LegacyDB::exists('progress_areas WHERE progress=100 AND areaID=2 AND userID = ?', $student['id']) ? '<span class="txt-gre font-bold">Completato</span>' : '<span class="txt-red">Non completato</span>' ?></p>
                        <p class="field"><?= LegacyDB::exists('progress_areas WHERE progress=100 AND areaID=3 AND userID = ?', $student['id']) ? '<span class="txt-gre font-bold">Completato</span>' : '<span class="txt-red">Non completato</span>' ?></p>

                    </form>

                <?php } ?>

            </div>
        </div>

        <!-- Print -->
        <div class="fa-center">
            <div class="printbuttonmar-t-3">
                <span class="text-icon bgr-wht" <?= icon_svg('print') ?>></span>
                <span class="btn-text">Stampa</span>
            </div>
        </div>

    <?php } else { ?>

        <!-- Empty -->
        <div class="empty">
            <p>Non ci sono studenti registrati in questa classe.</p>
        </div>

    <?php } ?>

</section>

{% end main %}