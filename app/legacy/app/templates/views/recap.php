{% extends main %}

{% block main %}

<div class="page-header grid center-content stack-content contrasting-background">
    <img class="object-cover opacity-30 w-full h-full" src="<?= $coverImage ?>" alt="" />
    <div class="page-header__overlay gradient-overlay fill-all background-fill"></div>

    <div class="page-header__content grid center-content main-wrap" data-spacing="700">
        <h1 class="page-header__title title"><?= __('sections.' . $section->slug) ?></h1>

        <?php if ($area->id <> 4) { ?>

            <a class="button" href="<?= route('analysis.student.section', $section) ?>">
                <?= embed_icon('read') ?>
                <?= __('Know More') ?>
            </a>

        <?php } ?>

    </div>
</div>

<div id="content" class="py-20 pb-20">

    <div class="main-wrap">

        <!-- Subtitle and description -->
        <div class="grid center-content" data-spacing="400">
            <h2 class="subsection-title"><?= __('Section summary') ?></h2>
            <p class="subsection-subtitle"><?= __("Here you can check your progress in this section, restart an activity, or revisit it.") ?></p>
            <a class="button button--secondary button--auto-width mar-t-1" href="<?= $backUrl ?>"><?= __('Choose another section') ?></a>
        </div>

        <!-- Tests -->
        <div class="tests mar-t-5 grid" data-columns="25rem" data-spacing="700">

            <?php foreach ($tests as $key => $test) {
            ?>

                <div class="pos-rel load--fade-in js-load" data-direction="bottom" data-delay="<?= $key % 3 ?>">
                    <form id="test<?= $test->id ?>" class="test bgr-wht grid" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="testId" value="<?= $test->id ?>">

                        <div class="test-img">
                            <?= embed_icon($test->recap_image) ?>
                        </div>

                        <div class="test-data">

                            <div class="test-texts">

                                <h3 class="test-title txt-upp txt-12rem txt-bold"><?= $test->name ?></h3>

                                <?php if (!$test->static) { ?>

                                    <p class="test-stitle txt-upp mt-2 <?= !$test->completed ? 'active' : ''; ?>"><?= $test->result_description ?></p>

                                <?php } ?>

                                <p class="mar-t-1"><?= $test->summary ?></p>
                            </div>

                            <div class="test-btn-box">
                                <?php if (($test->template != 'survey' && $test->type != 3) || !$test->completed) { ?>

                                    <p class="test-btn fc-tertiary">
                                        <a href="<?= $test->url() ?>"><?= __('View') ?></a>
                                    </p>

                                <?php } ?>

                                <?php if ($test->template == 'survey' && $test->completed) { ?>

                                    <p class="test-btn fc-confirmation" onclick="this.nextElementSibling.click()"><?= __('Download answers') ?></p>
                                    <button type="submit" class="hidden" name="download"></button>

                                <?php } ?>

                                <?php if ($test->completed && !$test->static) { ?>

                                    <p class="test-btn fc-warning" onclick="this.nextElementSibling.click()"><?= __('Restart') ?></p>

                                    <button type="submit" name="reset" class="hidden" onclick="return confirm('<?= __('Are you sure you want to restart the activity?') ?>')"
                                        formaction="<?= route('test.reset', $test->id) ?>"></button>

                                <?php } ?>

                            </div>
                        </div>
                    </form>
                </div>

            <?php } ?>

        </div>
    </div>
</div>

{% end main %}