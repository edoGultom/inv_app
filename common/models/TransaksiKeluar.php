<?php

namespace common\models;

use common\components\UserBehavior;

use Yii;

/**
 * This is the model class for table "transaksi_keluar".
 *
 * @property int $id
 * @property int|null $id_pengusulan
 * @property int|null $id_barang
 * @property int|null $id_user
 * @property string|null $tanggal
 * @property string|null $keterangan
 */
class TransaksiKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaksi_keluar';
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
    public function rules()
    {
        return [
            [['id_pengusulan', 'id_barang', 'id_user'], 'default', 'value' => null],
            [['id_pengusulan', 'id_peminjaman', 'id_barang', 'id_user'], 'integer'],
            [['tanggal'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pengusulan' => 'Id Usulan',
            'id_peminjaman' => 'Id Peminjaman',
            'id_barang' => 'Id Barang',
            'id_user' => 'Id User',
            'tanggal' => 'Tanggal',
            'keterangan' => 'Keterangan',
        ];
    }

    public function saveDetail($jumlah)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $model = new DetailTransaksikeluar();
            $model->id_transaksi_keluar = $this->id;
            $model->id_barang = $this->id_barang;
            $model->jumlah = $jumlah;
            if ($model->save()) {
                $transaction->commit();
                return true;
            } else
                return false;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function getVerifikator()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getPengusul()
    {
        if (!empty($this->id_pengusulan)) {
            $model =  $this->hasOne(PengusulanBarang::className(), ['id' => 'id_pengusulan'])->one();
            return $model->user->nama ?? '-';
        }
        if (!empty($this->id_peminjaman)) {
            $model =  $this->hasOne(PeminjamanBarang::className(), ['id' => 'id_peminjaman'])->one();
            return $model->user->nama ?? '-';
        }
    }
    public function getUnitPengusul()
    {
        if (!empty($this->id_pengusulan)) {
            $model =  $this->hasOne(PengusulanBarang::className(), ['id' => 'id_pengusulan'])->one();
            return $model->user->unit->nama_unit ?? '-';
        }
        if (!empty($this->id_peminjaman)) {
            $model =  $this->hasOne(PeminjamanBarang::className(), ['id' => 'id_peminjaman'])->one();
            return $model->user->unit->nama_unit ?? '-';
        }
    }
}
