{% block content %}

<div class="bgr bgr-wht"></div>

<div class="main-wrap pt-20 pos-rel grid" data-spacing="400">

    <?= title() ?>
    <?= no_results() ?>
    <?= submit() ?>

</div>

<?php if ($sibling->completed) { ?>

    <div id="graphic" class="mar-t-4 pos-rel">
        <div id="graph-box">
            <div class="section main-wrap grid8 pos-rel">

                <?php foreach ($results as $key => $result) { ?>

                    <div id="column-positive<?= $key + 1 ?>" class="column column<?= $key + 1 ?> pos-rel" data-id="<?= $key + 1 ?>">
                        <div class="bar positive gradient-overlay" style="height: <?= $result['positive-height'] ?>%;">
                            <p class="score font-bold txt-15rem txt-wht fa-center py-40px wid-100"><?= $result['positive-result'] ?></p>
                        </div>
                        <p class="result__label txt-vertical txt-13rem font-bold txt-2"><?= $result['label'] ?></p>
                    </div>

                <?php } ?>

            </div>

            <div class="negative-panel pb-20">
                <div class="section main-wrap grid8">

                    <?php foreach ($results as $key => $result) { ?>

                        <div id="column-negative<?= $key + 1 ?>" class="column column<?= $key + 1 ?> " data-id="<?= $key + 1 ?>">
                            <div class="bar negative gradient-overlay" style="height: <?= $result['negative-height'] ?>%;">
                                <p class="score font-bold txt-15rem txt-wht fa-center py-40px wid-100"><?= $result['negative-result'] ?></p>
                            </div>
                        </div>

                    <?php } ?>

                </div>
            </div>

            <?php foreach ($descriptions as $key => $description) { ?>

                <p id="desc<?= $key + 1 ?>" class="desc cen">
                    <?= $description ?>
                </p>

            <?php } ?>

        </div>
    </div>

<?php } ?>

{% end content %}