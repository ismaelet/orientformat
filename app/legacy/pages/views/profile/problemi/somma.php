{% block content %}

<div class="main-wrap" autocomplete="off">

    <div id="body" class="grid va-items-cen pb-20">

        <!-- Graphic -->
        <?php if ($legacyTest->completed || !$supervisorView) { ?>

            <div id="page-graph-box" class="txt-0 cell">

                <div id="page-graph" class="fill-all">

                    <?php

                    $count = 13;

                    for ($i = 0; $i < $count; $i++) {

                        $angle = deg2rad(360 / ($count - 1) * ($i - 1));

                        if ($legacyTest->completed) $right = $i ? eval_num($legacyTest->rawResults, $i) : $legacyTest->percentage == 100;

                        $val = $legacyTest->completed ? ($legacyTest->rawResults[$i] ?? '') : ''; ?>

                        <?php if ($i) { ?>

                            <div id="page-graph-line<?= $i; ?>" class="page-graph-line js-load line-g<?= $i % (($count - 1) / 2); ?> <?php if ($legacyTest->completed) echo $right ? 'right' : 'wrong'; ?>" style="--i:<?= $i; ?>"></div>

                        <?php } ?>

                        <div id="page-graph-box<?= $i; ?>" class="page-graph-box <?= $i ? 'circle js-load' : 'origin'; ?> <?php if ($legacyTest->completed) echo $right ? 'right' : 'wrong'; ?>" data-id="<?= $i; ?>" style="--w:<?= cos($angle); ?>; --h:<?= sin($angle); ?>">

                            <input type="number" class="inp fa-center txt-wht inp-num filler-inp" name="field[]" onKeyPress="if(this.value.length==3) return false;" autocomplete="new-password" data-group="<?= $i ? $i % (($count - 1) / 2) : -1; ?>" min="0" value="<?= $val; ?>" <?= $legacyTest->completed ? 'disabled' : ''; ?> required>

                        </div>

                    <?php } ?>
                </div>
            </div>
        <?php } else if ($supervisorView) { ?>

            <?= no_results() ?>

        <?php } ?>

        <div class="grid pad-v-3" data-spacing="700">

            <!-- Title -->
            <?= title() ?>

            <?php if ($legacyTest->completed && !$supervisorView) { ?>

                <div class="grid center-content" data-spacing="400">
                    <p class="txt-12rem">Hai risolto il test al <span class="font-bold fc-primary"><?= $legacyTest->percentage ?>%</span></p>

                    <?php if ($legacyTest->percentage != 100) {
                        echo renderRedoButton(true);
                    } ?>

                </div>

            <?php } ?>

            <div>
                <?= submit(true) ?>
                <?= skip() ?>
            </div>

        </div>
    </div>
</div>

{% end content %}