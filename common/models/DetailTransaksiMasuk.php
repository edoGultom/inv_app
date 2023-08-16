<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "detail_transaksi_masuk".
 *
 * @property int $id_transaksi_masuk
 * @property int $id_barang
 * @property int|null $jumlah
 */
class DetailTransaksiMasuk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detail_transaksi_masuk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transaksi_masuk', 'id_barang'], 'required'],
            [['id_transaksi_masuk', 'id_barang', 'jumlah'], 'default', 'value' => null],
            [['id_transaksi_masuk', 'id_barang', 'jumlah'], 'integer'],
            [['id_transaksi_masuk', 'id_barang'], 'unique', 'targetAttribute' => ['id_transaksi_masuk', 'id_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_transaksi_masuk' => 'Id Transaksi Masuk',
            'id_barang' => 'Id Barang',
            'jumlah' => 'Jumlah',
        ];
    }
    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['id' => 'id_barang']);
    }
    public function getTransaksiMasuk()
    {
        return $this->hasOne(TransaksiMasuk::className(), ['id' => 'id_transaksi_masuk']);
    }
    public function getUserPegawai()
    {
        $model =  $this->hasOne(TransaksiMasuk::className(), ['id' => 'id_transaksi_masuk'])->one();
        if ($model) {
            return User::findOne(['id' => $model->id]);
        }
    }
}
