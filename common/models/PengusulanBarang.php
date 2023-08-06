<?php

namespace common\models;

use common\components\UserBehavior;
use Yii;

/**
 * This is the model class for table "pengusulan_barang".
 *
 * @property int $id
 * @property int|null $id_barang
 * @property int|null $id_user
 * @property string|null $cepat_kode_unit
 * @property string|null $nama_barang
 * @property int|null $jumlah
 * @property string|null $tanggal
 * @property string|null $keterangan
 * @property int|null $status
 */
class PengusulanBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengusulan_barang';
    }

    /**
     * {@inheritdoc}
     */
    const KIRIM_USULAN = 1;
    const TERIMA_USULAN = 2;
    const BERI_TAWARAN = 3;
    const TERIMA_TAWARAN = 4;
    const TOLAK_USULAN = 99;

    public function rules()
    {
        return [
            [['id_barang', 'id_user', 'jumlah', 'status'], 'default', 'value' => null],
            [['id_barang', 'id_user', 'jumlah', 'status'], 'integer'],
            [['nama_barang', 'keterangan'], 'string'],
            [['tanggal'], 'safe'],
            [['cepat_kode_unit'], 'string', 'max' => 25],
        ];
    }
    public function behaviors()
    {
        return [
            UserBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_barang' => 'Id Barang',
            'id_user' => 'Id User',
            'cepat_kode_unit' => 'Cepat Kode Unit',
            'nama_barang' => 'Nama Barang',
            'jumlah' => 'Jumlah',
            'tanggal' => 'Tanggal',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
        ];
    }
    public function setTahap($tahap, $keterangan = NULL)
    {
        $this->status = $tahap;
        $this->keterangan = $keterangan;
        if ($this->save()) {
            return true;
        }
        return false;
    }
    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['id' => 'id_barang']);
    }
    public function getTahap()
    {
        $model = $this->hasOne(Refstatus::className(), ['id' => 'status'])->one();
        if ($model) {
            if ($this->status == 1) {
                return '<span class="badge bg-primary-light tx-primary ">' . $model->keterangan . '</span>';
            } else if ($this->status == 2) {
                return '<span class="badge bg-success-light tx-success">' . $model->keterangan . '</span>';
            } else if ($this->status == 3) {
                return '<span class="badge bg-warning-light tx-orange">' . $model->keterangan . '</span>';
            } else if ($this->status == 4) {
                return '<span class="badge bg-indigo-light tx-indigo">' . $model->keterangan . '</span>';
            } else {
                $status =  '<span class="badge bg-pink-light tx-pink">' . $model->keterangan . '</span>';
                $alasan = '<p>Keterangan : ' . $this->keterangan . '</p>';
                return $status . $alasan;
            }
        }
        return false;
    }
}
