<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAssetSignIn;
use yii\bootstrap5\Html;

AppAssetSignIn::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> -->

    <link rel="shortcut icon" href="/img/logo.ico">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="content content-fixed content-auth">
        <div class="container">
            <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
                <div class="media-body align-items-center d-none d-lg-flex flex-column">
                    <div class="d-flex flex-column">
                        <span class="aside-logo tx-32">
                            SIPBANG<span class="tx-24"> BAPEG PROVSU</span>

                        </span>
                        <p class="tx-14">Sistem Informasi Pendataan Barang</p>
                    </div>
                    <div class="mx-wd-500">
                        <img src="/img/sign_in.svg" class="img-fluid" alt="">
                    </div>
                </div><!-- media-body -->
                <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                    <?= $content ?>
                </div><!-- sign-wrapper -->
            </div><!-- media -->
        </div><!-- container -->
    </div><!-- content -->

    <footer class="footer">
        <div>
            <span>&copy; 2023 </span>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
