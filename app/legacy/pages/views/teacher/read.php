{% block main %}

<!-- Slider -->
<section id="slider">

    <div id="bgr-img" class="bgr" <?= background_image('/pages/assets/teacher/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pb-20">

    <!-- Title -->
    <div class="title-box mar-t-4 fa-center">
        <h1 class="title txt-25rem txt-sbold">Saperne di più</h1>
        <p class="stitle txt-1rem mar-t-1">Qui potrai accedere ad agili schede di approfondimento, arricchite da un Glossario ipertestuale.</p>
        <a href="<?= route('teacher.dashboard') ?>" class="button button--secondary back">Torna alla gestione</a>
    </div>

    <div id="areas" class="mar-t-3">

        <?php foreach ($areas as $key => $area) { ?>

            <div class="area mar-b-3">

                <p class="font-bold brb2 br-c<?= $key + 1 ?> pad-b-1 fa-center txt-25px mb-4"><?= $area['name'] ?></p>

                <div class="txt-0rem fa-center">

                    <?php if (isset($area['area'])) { ?>

                        <a href="<?= route('read', ['area-id' => $area['area']]) ?>" id="area<?= $area['area'] ?>" class="section inlb al-top ele4 ele3-768w ele2-480w pad-2 fa-center">
                            <div class="">
                                <div class="img cont inlb" <?= background_image('/pages/assets/area/area'.$area['area'].'.svg') ?>></div>
                                <p class="title txt-11rem txt-sbold mar-t-1 txt-line"><?= $area['name'] ?></p>
                            </div>
                        </a>

                    <?php } ?>

                    <?php if (isset($area['sections'])) {
                        while ($legacySection = $area['sections']->fetch_assoc()) { ?>

                        <a href="<?= route('read', ['id' => $legacySection['id']]) ?>" id="section<?= $legacySection['id'] ?>" class="section inlb al-top ele4 ele3-768w ele2-480w pad-2 fa-center">
                            <div class="">
                                <div class="img cont inlb" <?= background_image('/pages/assets/area/section'.$legacySection['id'].'.svg') ?>></div>
                                <p class="title txt-11rem txt-sbold mar-t-1 txt-line"><?= $legacySection['name'] ?></p>
                            </div>
                        </a>

                    <?php }
                        } ?>

                </div>

            </div>

        <?php } ?>

    </div>

</section>

{% end main %}