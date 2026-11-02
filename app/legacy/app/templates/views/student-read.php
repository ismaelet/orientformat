{% extends main %}

{% block main %}

<div id="body" class="main-wrap py-20 pad-b-7">

    <!-- Main content -->
    <section id="content">

        <h1 class="title"><?= __('student-read.'.$page.'-title') ?></h1>

        <p class="text"><?= __('student-read.'.$page.'-text') ?></p>

        <h2 class="section-title"><?= __('Interpret the results') ?></h2>

        <p class="text"><?= __('student-read.'.$page.'-results') ?></p>

        <div class="page-footer grid center-content max-width--480 place-center mar-t-4" data-spacing="400">
            <a href="<?= $returnLink ?>" class="button button--secondary button--full-width"><?= __('Back') ?></a>

            <div id="print" class="button button--full-width" onClick="window.print();">
                <?= embed_icon('print') ?>
                <?= __('Print this page') ?>
            </div>
        </div>

    </section>

</div>

<!-- Scroll back to top -->
<a href="#content" id="scroll" class="round bgr-c1-h top">
    <div class="icon cen">
        <?= embed_icon('navigation/arrow-simple-top') ?>
    </div>
</a>

{% end main %}