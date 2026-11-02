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

        <h1 class="title txt-25rem txt-sbold">Risultati complessivi</h1>

        <p class="stitle txt-1rem mar-t-2">
            Cliccando su <span class="font-bold">Risultati</span> puoi controllare i risultati di ciascuno studente una volta che avrà completato le attività proposte.<br><br>
            Se vuoi esaminare più nel dettaglio i risultati ottenuti dagli alunni, torna alla pagina principale e apri l'area <span class="font-bold">Progesso per attività</span><br><br>
            Quando desideri puoi indicare il consiglio orientativo per ogni studente.
        </p>

        <a href="<?= route('teacher.dashboard') ?>" class="button button--secondary back">Torna alla gestione</a><br>

    </div>

    <?php if ($students->num_rows) { ?>

        <!-- List -->
        <div id="list" class="panel mar-t-3">
            <div class="list">

                <div class="head">
                    <p class="field field-l">Studente</p>
                    <p class="field field-l">Consiglio orientativo</p>
                    <p class="field field-m">Questionario completato</p>
                    <p class="field field-btn"></p>
                </div>

                <?php while ($student = $students->fetch_assoc()) {

                    $advices_str = false;

                    $advices = LegacyDB::find('advices FROM advices WHERE userID = ? AND advices<>""', $student['id']);

                    if ($advices) {

                        $advices_str = [];

                        $advices = explode(',', $advices);

                        foreach ($advices as $advice) {
                            $advices_str[] = $choices[$advice];
                        }

                        $advices_str = implode('<br>', $advices_str);
                    }

                    ?>

                    <!-- Rows -->
                    <form method="POST" action="#row<?= $student['id'] ?>" id="row<?= $student['id'] ?>" class="row">

                        <p class="field"><?= $student['name'] ?></p>

                        <p class="field"><?= $advices_str ?: '-' ?></p>

                        <p class="field"><?= LegacyDB::exists('survey_end WHERE userID = ?', [$student['id']]) ? 'SI' : '<span class="txt-red">NO</span>' ?></p>

                        <div class="field btn-box">
                            <div class="btn blu inlb lbox-open" data-tar="#advice<?= $student['id'] ?>">Scegli consiglio</div>
                            <a href="results/result?id=<?= $student['id'] ?>" class="btn gre inlb marl5px">Risultati</a>
                        </div>

                        <input type="hidden" name="id" value="<?= $student['id'] ?>">

                    </form>

                    <!-- Lightboxes -->
                    <form method="POST" id="advice<?= $student['id'] ?>" class="lbox">

                        <input type="hidden" name="id" value="<?= $student['id'] ?>">

                        <div class="form">

                            <p class="pad-b-1 br-b-1 br-2 txt-2 txt-13rem">Consiglio orientativo per <span class="font-bold"><?= $student['name'] ?></span></p>
                            <p class="mar-t-2 mb-4">È possibile selezionare qui sotto uno o più consigli orientativi. Si può indicare un'area generica (ad esempio "Liceo") oppure un indirizzo più specifico:</p>

                            <?php for ($i = 0; $i < 3; $i++) { ?>

                                <select name="advice[]" class="sel">

                                    <option value="0">- nessuno -</option>

                                    <?php foreach ($choices as $key => $choice) { ?>

                                        <option value="<?= $key ?>" <?= isset($advices[$i]) && $advices[$i] == $key ? 'selected' : '' ?>>

                                            <?= $choice ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            <?php } ?>

                            <button type="submit" name="add-advice" class="button wid-100 mar-t-1">Salva</button>
                            <div class="button button--secondary lbox-close wid-100">Esci</div>

                        </div>

                    </form>

                <?php } ?>

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