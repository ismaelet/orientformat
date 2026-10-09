{% block content %}

<div class="main-wrap pad-t-4 pb-20">

    <?= title() ?>

    <div id="graph-box">
        <div id="graph" class="mar-v-4">

            <div id="graph-line1" class="graph-line">
                <div id="box<?= $i + 1 ?>" class="box left">
                    <p class="concept"><?= $concepts[$i];
                                        $i++; ?></p>
                </div>
            </div>

            <div id="graph-line2" class="graph-line">
                <div id="box<?= $i + 1 ?>" class="box left">
                    <p class="concept"><?= $concepts[$i];
                                        $i++; ?></p>
                </div>
            </div>

            <div id="graph-line3" class="graph-line">
                <div id="box<?= $i + 1 ?>" class="box left">
                    <p class="concept"><?= $concepts[$i];
                                        $i++; ?></p>
                </div>
            </div>

            <div id="graph-line4" class="graph-line grid2">

                <div class="graph-cell">
                    <div id="box<?= $i + 1 ?>" class="box push-center left">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

                <div class="graph-cell">
                    <div id="box<?= $i + 1 ?>" class="box push-center right">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

            </div>

            <div id="graph-line5" class="graph-line big grid2">

                <div class="graph-cell">
                    <div id="box<?= $i + 1 ?>" class="box flt-r big left">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

                <div class="graph-cell grid2 va-items-cen">

                    <div id="box<?= $i + 1 ?>" class="box big right">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>

                    <div class="ha-rig grid">
                        <div id="box<?= $i + 1 ?>" class="box inlb right">
                            <p class="concept"><?= $concepts[$i];
                                                $i++; ?></p>
                        </div>
                    </div>
                </div>

            </div>

            <div id="graph-line6" class="graph-line grid2">

                <div class="graph-cell">
                    <div id="box<?= $i + 1 ?>" class="box push-center left">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

                <div class="graph-cell">
                    <div id="box<?= $i + 1 ?>" class="box push-center right">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

            </div>

            <div id="graph-line7" class="graph-line grid2">

                <div class="graph-cell">
                    <div id="box<?= $i + 1 ?>" class="box left">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

                <div class="graph-cell ha-rig">
                    <div id="box<?= $i + 1 ?>" class="box right inlb">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

            </div>

            <div id="graph-line8" class="graph-line grid2">

                <div class="graph-cell">
                    <div id="box<?= $i + 1 ?>" class="box left">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

                <div class="graph-cell ha-rig">
                    <div id="box<?= $i + 1 ?>" class="box right inlb">
                        <p class="concept"><?= $concepts[$i];
                                            $i++; ?></p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <p id="mob-warning" class="fa-center txt-12rem font-bold mar-t-2">Questo grafico non può essere visualizzato su dispositivi mobile</p>

    <?= submit() ?>

</div>

{% end content %}