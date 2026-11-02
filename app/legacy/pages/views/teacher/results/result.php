{% block main %}

<!-- Slider -->
<section id="slider">

    <div id="bgr-img" class="bgr" <?= background_image('/pages/assets/teacher/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pb-20">

    <!-- Title -->
    <div class="title-box mar-t-4 fa-center">
        <h1 class="title txt-25rem fw-light">Risultati<br><span class="txt-sbold"><?= $student['last_name'].' '.$student['first_name'] ?></span></h1>
        <a href="<?= route('class.students.results.index', ['class' => schoolClassId()]) ?>" class="button button--secondary back">Torna agli studenti</a>
    </div>

    <div id="areas" class="mar-t-3">

        <?php $i = 0;
    foreach ($areas as $key => $area) { ?>

            <div id="area<?= $key ?>" class="area mar-b-3">

                <p class="title font-bold fa-center txt-2rem mar-b-2"><?= $area['name'] ?></p>

                <div class="grid gap2">

                    <?php while ($legacySection = $area['sections']->fetch_assoc()) {
                        $i++; ?>

                        <div>
                            <div id="section<?= $legacySection['id'] ?>" class="section panel grid">

                                <div class="icon-box bgr-f6 pad-2">
                                    <div class="icon" <?= icon_svg('section'.$legacySection['id']) ?>></div>
                                </div>

                                <div class="result py-4 px-8">

                                    <p class="title txt-13rem txt-sbold">
                                        <?= $legacySection['name'] ?>
                                    </p>

                                    <p class="txt-1rem mt-2">
                                        <?= $results[$i] ?: 'Non completato' ?>
                                    </p>

                                    <?php if ($results[$i] && isset($infos[$legacySection['id']])) { ?>

                                        <p class="info br-t-1 br-e pt-4 txt-09rem mar-t-1"><?= $infos[$legacySection['id']] ?></p>

                                    <?php } ?>

                                </div>

                            </div>
                        </div>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

    </div>

    <!-- Print -->
    <div class="fa-center">
        <div class="print pbtn">
            <span class="text-icon bgr-wht" <?= icon_svg('print') ?>></span>
            <span class="btn-text">Stampa</span>
        </div>
    </div>

</section>

{% end main %}