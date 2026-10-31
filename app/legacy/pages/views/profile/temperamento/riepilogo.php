{% block content %}

<div class="title__wrapper main-wrap">
    <?= title() ?>
    <?= submit() ?>
</div>

<div id="img-box" class="mar-t-2 mar-b-5 stack-items grid">
    <div id="img" class="bgr-fit" <?= background_image('bgr.jpg') ?>></div>
    <div id="gradient" class="bgr-fit"></div>
    <div id="shape" class="bgr-fit" <?= background_image('shape.png') ?>></div>

    <?php for ($i = 1; $i < 6; $i++) { ?>

        <div id="section<?= $i ?>" class="section bgr-fit" <?= background_image('section' . $i . '.png') ?>></div>

    <?php } ?>

    <div class="areas">

        <?php for ($i = 1; $i < 6; $i++) { ?>

            <div id="area<?= $i ?>" class="area responsive" data-id="<?= $i ?>"></div>

        <?php } ?>

    </div>

    <div class="results">

        <?php foreach ($results as $i => $result) { ?>

            <div id="result<?= $i ?>" class="result">
                <div class="title-box fa-center">
                    <p class="title inlb"><?= $result['name'] ?> <?= $result['percentage'] !== null ? '<span class="percentage">(' . $result['percentage'] . '%)</span>' : '' ?></p><br>

                    <?php if (!isSupervisor()) { ?>

                        <p class="reset hide responsive clickable" data-id="<?= $i ?>" onclick="this.nextElementSibling.click()"><?= __('Restart') ?></p>
                        <button type="submit" name="reset-test" class="hidden" value="<?= $result['test']->id ?>"></button>

                    <?php } ?>

                </div>

                <div class="scores">

                    <?php for ($j = 1; $j <= 5; $j++) { ?>

                        <div id="score<?= $i ?><?= $j ?>" class="score score<?= $j ?> <?= $result['tier'] == $j ? 'active' : '' ?>"></div>

                    <?php } ?>

                </div>
            </div>

        <?php } ?>

    </div>
</div>

{% end content %}