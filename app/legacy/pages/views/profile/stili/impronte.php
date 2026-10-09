{% block content %}

<!-- Review view -->
<?php if ($legacyTest->completed) { ?>

    <div id="results-sec" class="grid main-wrap pt-20 pb-20" data-spacing="700">

        <?= title(__('tests.33-title'), __('tests.33-description')) ?>

        <div class="grid" data-columns="25rem" data-spacing="700">

            <div id="method1" class="method" data-tilt>

                <h3 class="subsection-title txt-15rem font-bold br-b-1 br-5 pad-b-1 mar-b-2"><?= __('tests.33-title-1') ?></h3>

                <p class="desc txt-1rem txt-2 mb-4">
                    <?= __('tests.33-info-1-1') ?>
                </p>
                <p class="desc txt-1rem txt-2">
                    <?= __('tests.33-info-1-2') ?>
                </p>

            </div>

            <div id="method2" class="method" data-tilt>

                <h3 class="subsection-title txt-15rem font-bold br-b-1 br-5 pad-b-1 mar-b-2"><?= __('tests.33-title-2') ?></h3>

                <p class="desc txt-1rem txt-2 mb-4">
                    <?= __('tests.33-info-2-1') ?>
                </p>
                <p class="desc txt-1rem txt-2">
                    <?= __('tests.33-info-2-2') ?>
                </p>

            </div>
        </div>

        <!-- Submit -->
        <?= submit() ?>

    </div>

    <!-- Initial view -->
<?php } else { ?>

    <div id="image-sec" class="main-wrap grid" data-spacing="800">
        <div class="title__wrapper">
            <?= title() ?>
        </div>
        <img id="img" class="" src="<?= client_path('img.jpg') ?>">
        <button type="submit" name="review" class="button button--full-width"><?= __('tests.33-cta') ?></button>
    </div>

<?php } ?>

{% end content %}