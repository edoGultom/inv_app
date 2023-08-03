<?php

namespace common\components;

use common\models\AktivitasHarian;
use common\models\AtasanLangsung;
use yii\helpers\ArrayHelper;

use Yii;
use yii\base\Component;
use common\models\DataUtama;
use common\models\AuthAssignment;
use common\models\DataUtamaNonPns;
use common\models\KamusKinerja;
use common\models\RefSumberAktivitas;
use common\models\Rhk;
use yii\httpclient\Client;
use \yii\web\Response;

class Pengguna extends Component
{
    public function getDataUtama($nip = null)
    {
        if (empty($nip)) {

            $nip = Yii::$app->user->identity->nip;
        }
        if ($nip == 1 || $nip == 2) {
            return DataUtamaNonPns::find()->where(['nip_baru' => $nip])->one();
        }
        return  DataUtama::find()->where(['nip_baru' => $nip])->one();
    }

    public function getHakAkses()
    {
        $id = Yii::$app->user->id;
        $hakAkses = ArrayHelper::map(AuthAssignment::find()->where(['user_id' => $id])->all(), 'item_name', 'item_name');
        return $hakAkses;
    }
    public function getNipPenilai()
    {
        $nipBawahan = Yii::$app->user->identity->nip;
        $model = AtasanLangsung::find()->where(['nip_bawahan' => $nipBawahan])->one();
        if (!$model) return false;
        return  $model->nip_atasan;
    }
    public function getDataUtamaPenilai($nip = null)
    {
        if (empty($nip)) {
            $nip = Yii::$app->user->identity->nip;
        }

        $model = AtasanLangsung::find()->where(['nip_bawahan' => $nip])->one();
        if (!$model) return false;
        return  $model->dataUtamaAtasan ?? false;
    }
    public function getRhk($id_rhk = null)
    {
        if (empty($id_rhk)) {
            return false;
        }

        $model = Rhk::find()->where(['id' => $id_rhk])->one();
        if (!$model) return false;
        return  $model;
    }
    public function getKamusKinerja($id_kamus = null)
    {
        if (empty($id_kamus)) {
            return false;
        }

        $model = KamusKinerja::findOne(['id' => $id_kamus]);
        if (!$model) return false;
        return  $model;
    }
    public function getSumberAktivitas($id_sumber = null)
    {
        if (empty($id_sumber)) {
            return false;
        }

        $model = RefSumberAktivitas::findOne(['id' => $id_sumber]);
        if (!$model) return false;
        return  $model;
    }

    public function getAktivitas($id = null)
    {
        if (empty($id)) {
            return false;
        }

        $model = AktivitasHarian::findOne(['id' => $id]);
        if (!$model) return false;
        return  $model;
    }
    public function getIsdisabledElement($tahap)
    {
        if ($tahap > 1 && $tahap != 101) {
            return 'disabled';
        }
        return;
    }
}
