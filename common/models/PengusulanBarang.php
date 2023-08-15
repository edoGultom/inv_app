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
    const TERIMA_BERSYARAT_VERIFIKATOR = 3;
    const TERIMA_BERSYARAT_ASN = 4;
    const TOLAK_USULAN = 99;

    public function rules()
    {
        return [
            [['id_barang', 'id_user', 'jumlah', 'status'], 'default', 'value' => null],
            [['id_barang', 'id_user', 'id_verifikator', 'jumlah', 'status'], 'integer'],
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
            'id_verifikator' => 'Id Verifikator',
            'cepat_kode_unit' => 'Cepat Kode Unit',
            'nama_barang' => 'Nama Barang',
            'jumlah' => 'Jumlah',
            'tanggal' => 'Tanggal',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
    public function setTahap($tahap, $keterangan = NULL, $id_verifikator = NULL)
    {
        $this->status = $tahap;
        $this->keterangan = $keterangan;
        $this->id_verifikator = $id_verifikator;
        if ($this->save(false)) {
            return true;
        }
        return false;
    }
    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['id' => 'id_barang']);
    }
    public function getCheckStock()
    {
        $stok = $this->barang->stok ?? 0;
        return  $stok - $this->jumlah;
    }
    public function getTahap()
    {
        $model = $this->hasOne(Refstatus::className(), ['id' => 'status'])->one();
        if ($model) {
            if ($this->status == 1) {
                return '<span class="badge bg-primary-light tx-primary ">' . $model->keterangan . '</span>';
            } else if ($this->status == 2) {
                return '<span class="badge bg-success-light tx-success">' . $model->keterangan . '</span>';
            } else {
                $status =  '<span class="badge bg-pink-light tx-pink">' . $model->keterangan . '</span>';
                $alasan = '<p class="text-muted">Keterangan : ' . $this->keterangan . '</p>';
                return $status . $alasan;
            }
        }
        return false;
    }
    public function getIsVerify()
    {
        if ($this->status == self::TERIMA_BERSYARAT_VERIFIKATOR) {
            return true;
        }
        return false;
    }
    public function setNewStok($out)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $barang = Barang::findOne(['id' => $this->id_barang]);
            if (!$barang) {
                return false;
            }
            $barang->stok -= $out;
            if ($barang->save()) {
                $transaction->commit();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function saveTransaksiKeluar()
    {

        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $model = new TransaksiKeluar();
            $model->id_barang = $this->id_barang;
            $model->id_pengusulan = $this->id;
            $model->tanggal = date('Y-m-d');
            $model->keterangan = $this->keterangan;

            if ($model->save() && $this->setNewStok($this->jumlah) && $model->saveDetail($this->jumlah)) {
                $transaction->commit();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
