{% extends main %}

{% block main %}

<!-- Slider -->
<section id="slider">

    <div id="bgr-img" class="bgr" <?= background_image('/pages/assets/management/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pb-20">

    <!-- Title -->
    <div class="title-box mar-t-4 text-center">
        <h1 class="title txt-25rem txt-sbold"><?= $edit ? 'Modifica' : $title ?></h1>
        <p class="stitle txt-1rem mar-t-1"><?= $edit ? $stitle_edit . ' <strong>' . $row[$name] . '</strong>' : $stitle_add ?></p>
        <?php
            $listRoute = $edit ? 'filament.admin.resources.'.basename(dirname($view->name)).'.index' : null;
            $backRoute = $edit && \Illuminate\Support\Facades\Route::has($listRoute)
                ? $listRoute
                : 'filament.admin.pages.dashboard';
        ?>
        <a href="<?= route($backRoute) ?>" class="sbtn back"><?= $edit ? 'Torna alla lista' : 'Torna alla gestione' ?></a>
    </div>

    <!-- Form -->
    <form method="POST" action="#form" id="form" class="mar-t-4">

        <?= gen_form($inputs, $row, $error) ?>

        <?php if ($done) { ?>
            <p class="inp ok mar-t-1">Elemento aggiunto con successo</p>
        <?php } ?>

        <div class="text-center mar-t-1">
            <button type="submit" name="<?= $edit ? 'edit' : 'add' ?>" class="button"><?= $edit ? 'Modifica' : 'Aggiungi' ?></button>
        </div>

    </form>

</section>

{% end main %}