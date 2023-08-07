<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="/img/logo.ico">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">

    <?php $this->beginBody() ?>

    <aside class="aside aside-fixed">
        <!-- headers -->
        <?= $this->render('aside-header') ?>
        <!-- close headers -->

        <div class="aside-body">
            <!-- loggedin -->
            <?= $this->render('aside-loggedin') ?>
            <!-- close loggedin -->

            <!-- menus -->
            <?= $this->render('menus') ?>
            <!-- close menus -->

        </div>
    </aside>
    <!-- <div class="aside-header">
    <a href="../../index.html" class="aside-logo">
        <div class=" d-flex flex-row align-items-center gap-3 text-dark">
            <img src="/img/logo.png" alt="" width="31" height="38" />
            <div class="logo-kinerja">
                <span class="text-danger fw-bold">E-KINERJA</span>
                <span class="fw-bold">PEMERINTAHAN</span>
                <span class="fw-bold">KOTA MEDAN</span>
            </div>
        </div>
    </a>
    <a href="" class="aside-menu-link">
        <i data-feather="menu"></i>
        <i data-feather="x"></i>
    </a>
</div> -->
    <div class="content ht-100v pd-0">
        <div class="content-header">
            <div class="content-search"></div>


            <!-- <nav class="nav">
                <a href="" class="nav-link"><i data-feather="help-circle"></i></a>
                <a href="" class="nav-link"><i data-feather="grid"></i></a>
                <a href="" class="nav-link"><i data-feather="align-left"></i></a>
            </nav> -->
        </div><!-- content-header -->

        <div class="content-body">
            <div class="container pd-x-0">
            <?= $content ?>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>


</html>
<?php $this->endPage();