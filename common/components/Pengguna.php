<?php

namespace common\components;

use yii\helpers\ArrayHelper;

use Yii;
use yii\base\Component;
use common\models\RefUnit;
use common\models\Rhk;
use yii\httpclient\Client;
use \yii\web\Response;

class Pengguna extends Component
{
    public function getUnit()
    {
        $cepat_kode = Yii::$app->user->identity->cepat_kode_unit;
        return RefUnit::find()->where(['cepat_kode' => $cepat_kode])->one();
    }
}
