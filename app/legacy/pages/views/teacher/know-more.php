{% block main %}

<!-- Content -->
<section class="main-wrap pb-20">

    <!-- Title -->
    <div class="title-box mar-t-4 fa-center">
        <h1 class="page-title">Saperne di più</h1>
        <a href="<?= route('teacher.dashboard') ?>" class="button button--secondary back mar-t-1">Indietro</a>
        <p class="stitle txt-1rem mar-t-1">Qui potrai accedere ad agili schede di approfondimento, arricchite da un <strong>Glossario ipertestuale</strong>.</p>
    </div>

    <div class="areas mar-t-6">

        <?php foreach ($areas as $area) { ?>

            <div class="area">
                <h2 class="area_title txt-sbold brb2 br-c<?= $area->id ?> pad-b-1 fa-center txt-25px mb-4"><?= $area->name ?></h2>

                <div class="sections">

                    <?php if ($area->id == 4) { ?>

                        <a href="<?= route('read', ['area-id' => $area->id]) ?>" class="section fa-center section-color section-color--area-<?= $area->id ?>">
                            <?= embed_icon($area->icon) ?>
                            <p class="section__title"><?= $area->name ?></p>
                        </a>

                        <?php } else {
                        foreach ($area->getAplhabeticalDoableSections() as $legacySection) {
                            if ($legacySection->isMainSection) { ?>

                                <a href="<?= route('read', ['id' => $legacySection->id]) ?>" id="section<?= $legacySection->id ?>" class="section fa-center section-color section-color--area-<?= $area->id ?>">
                                    <?= embed_icon($legacySection->icon) ?>
                                    <p class="section__title"><?= $legacySection->name ?></p>
                                </a>

                    <?php }
                        }
                    } ?>

                </div>

            </div>

        <?php } ?>

    </div>

</section>

{% end main %}