{% block content %}

<div class="main-wrap pad-t-4 pb-20 pos-rel">

    <?= title() ?>

    <div id="content" class="mar-t-5 <?= $legacyTest->completed ? 'completed' : '' ?>">

        <!-- Example -->
        <div id="example" class="image-box fa-center">

            <img class="image push-center" src="<?= client_path('0.png') ?>">

            <div class="fa-center mar-t-5">
                <div class="button js-start"><?= __('Start') ?></div>
            </div>

        </div>

        <!-- Slider -->
        <div id="slider" class=" mar-b-4">

            <?php for ($i = 1; $i < 7; $i++) { ?>

                <div id="image<?= $i ?>" class="image-box fa-center">
                    <p class="number txt-3rem font-bold"><?= $i ?>.</p>
                    <img class="image push-center block" src="<?= client_path($i.'.png') ?>">
                </div>

            <?php } ?>

        </div>

        <!-- Solutions -->
        <div id="solutions">

            <input type="hidden" name="field[]" class="filler-inp" value="0">

            <?php if ($legacyTest->completed) { ?>

                <p id="result-text" class="mar-b-4 fa-center txt-12rem font-bold <?= $legacyTest->percentage == 100 ? 'right' : 'wrong' ?>"><?= $legacyTest->percentage == 100 ? __('tests.54-right') : __('tests.54-wrong') ?></p>

            <?php } ?>

            <div class="grid6 mar-b-5">

                <?php for ($i = 1; $i < 7; $i++) { ?>

                    <div class="fa-center">
                        <p class="solution inlb clickable <?php if ($legacyTest->completed && $legacyTest->rawResults[0] == $i) {
                            echo $legacyTest->percentage == 100 ? 'right' : 'wrong';
                        } ?>" data-val="<?= $i ?>">

                            <?= $i ?>

                        </p>
                    </div>

                <?php } ?>

            </div>

            <div class="grid" data-spacing="400">
                <?= submit(true) ?>
                <?= renderRedoButton() ?>
            </div>

        </div>
    </div>
</div>

{% end content %}