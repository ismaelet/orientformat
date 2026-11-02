{% block content %}

<div class="header grid stack-content center-content contrasting-background">
    <div class="header__background gradient-overlay background-fill fill-all"></div>

    <div id="title-box" class="fa-center pt-20 pos-rel grid center-content max-width--1024 full-width" data-spacing="700">
        <?= title() ?>

        <div class="max-width--300 full-width">
            <?= submit() ?>
        </div>
    </div>
</div>

<div id="content" class="">
    <section id="tests-sec" class="bgr-wht">
        <div id="content-bgr" class="bgr"></div>
        <div class="main-wrap pb-20">
            <div id="tests" class="al-top">

                <?php foreach ($legacyTests as $key => $dependentTest) {
                    $height = $dependentTest->result && $dependentTest->result->completed ? 1 + ($dependentTest->result->percentage / $maxHeight * 23) : 0;
                    ?>

                    <div id="sec-box<?= $dependentTest->id ?>" class="sec-box grid-ele al-top" data-test="<?= $dependentTest->slug ?>">
                        <input type="hidden" name="testId" value="<?= $dependentTest->id ?>">
                        <div class="test-res js-load" style="height: <?= $height ?>rem;"></div>
                        <div class="ele-cont fa-center">
                            <div class="test-ico inlb" <?= background_image('/pages/assets/profile/autostima/riepilogo/test-'.$dependentTest->slug.'.png') ?>></div>
                            <div class="test-data txt-lef js-load load--fade-in" data-direction="top">
                                <div class="test-line"></div>
                                <div class="test-dot"></div>

                                <h3 class="test-title txt-15rem txt-upp"><?= $dependentTest->title ?></h3>

                                <h3 class="score mar-t-10px <?= $dependentTest->completed ? 'completed txt-2rem' : 'uncompleted txt-11rem' ?>"><?= $dependentTest->completed ? $dependentTest->percentage.'%' : __('to complete') ?></h3>

                                <p class="test-desc">
                                    <?= $dependentTest->completed ? __('You have completed this self-assessment. Click below to repeat it:') : __('You have not completed this self-assessment yet. Click below to start it:') ?>
                                </p>

                                <?php if ($dependentTest->completed && ! isSupervisor()) { ?>

                                    <button type="submit" name="reset-test" class="test-btn txt-c3 mar-t-1" value="<?= $dependentTest->id ?>" onclick="return confirm('<?= __('Are you sure you want to repeat the assessment?') ?>')"><?= __('Restart') ?></button>

                                <?php } elseif (! isSupervisor()) { ?>

                                    <a href="<?= $dependentTest->clientUrl ?>" class="test-btn txt-c4 mar-t-1 font-bold"><?= __('Start') ?></a>

                                <?php } ?>

                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </section>
</div>

{% end content %}