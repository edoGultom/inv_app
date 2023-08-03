<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception*/

use yii\helpers\Html;

$this->title = $name;
$statusCode = Yii::$app->response->statusCode;
$img = '';
if ($statusCode == 404) {
    $img = ' <img src="/img/404.svg" class="img-fluid" alt="">';
} elseif ($statusCode == 503) {
    $img = ' <img src="/img/503.svg" class="img-fluid" alt="">';
}
?>
<div class="content content-fixed content-auth-alt">
    <div class="container ht-100p tx-center">
        <div class="ht-100p d-flex flex-column align-items-center justify-content-center">
            <div class="wd-70p wd-sm-250 wd-lg-300 mg-b-15">
                <?= $img ?></div>
            <h1 class="tx-color-01 tx-24 tx-sm-32 tx-lg-36 mg-xl-b-5"><?= $statusCode ?>
            </h1>
            <h5 class="tx-16 tx-sm-18 tx-lg-20 tx-normal mg-b-20">Oopps. <?= nl2br(Html::encode($message)) ?>.
            </h5>

        </div>
    </div><!-- container -->
</div><!-- content -->