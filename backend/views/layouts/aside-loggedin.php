<div class="aside-loggedin">
    <div class="d-flex align-items-center justify-content-start">
        <a href="" class="avatar"><img src="/img/dummy-profile.png" class="rounded-circle" alt=""></a>
        <!-- <div class="aside-alert-link">
            <a href="" class="new" data-bs-toggle="tooltip" title="You have 4 new notifications"
            ><i class="fas fa-bell"></i></a>
        </div> -->
    </div>
    <div class="aside-loggedin-user">
        <h6 class="tx-semibold mg-b-0"><?= Yii::$app->user->identity->username ?? '-' ?></h6>
        <p class="tx-color-03 tx-12 mg-b-0"><?= Yii::$app->user->identity->email ?? '-' ?></p>
        <p class="tx-color-03 tx-12 mg-b-0"><?= Yii::$app->pengguna->unit->nama_unit ?? '-' ?></p>
    </div>
</div>