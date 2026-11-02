{% block main %}

<!-- Slider -->
<section id="slider">

    <div id="bgr-img" class="bgr" <?= background_image('/pages/assets/teacher/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pb-20">

    <!-- Title -->
    <div class="title-box mar-t-4 fa-center">
        <h1 class="title txt-25rem txt-sbold">Progresso per attività</h1>
        <p class="stitle txt-1rem mar-t-1">Qui puoi monitorare il porgresso della classe diviso per attività</p>
        <a href="<?= route('teacher.dashboard') ?>" class="button button--secondary back">Torna alla gestione</a>
    </div>

    <div id="areas" class="mar-t-3">

        <?php foreach ($areas as $area) { ?>

            <div class="area mar-b-3">

                <p class="font-bold txt-25px mb-4"><?= $area['name'] ?></p>

                <div class="grid4 grid3-1024w grid2-768w grid1-480w gap2 al-top">

                    <?php while ($legacySection = array_shift($area['sections'])) { ?>

                        <a href="<?= route('section', ['section' => $legacySection['id']]) ?>" id="section<?= $legacySection['id'] ?>" class="section panel pad-2 fa-center">
                            <div class="img cont inlb" <?= background_image('/pages/assets/area/section'.$legacySection['id'].'.svg') ?>></div>
                            <p class="title txt-11rem txt-sbold mar-t-1"><?= $legacySection['name'] ?></p>
                        </a>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

    </div>

</section>

{% end main %}