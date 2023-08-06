<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "detail_transaksi_keluar".
 *
 * @property int $id_transaksi_keluar
 * @property int $id_barang
 * @property int|null $jumlah
 */
class DetailTransaksiKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detail_transaksi_keluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transaksi_keluar', 'id_barang'], 'required'],
            [['id_transaksi_keluar', 'id_barang', 'jumlah'], 'default', 'value' => null],
            [['id_transaksi_keluar', 'id_barang', 'jumlah'], 'integer'],
            [['id_transaksi_keluar', 'id_barang'], 'unique', 'targetAttribute' => ['id_transaksi_keluar', 'id_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_transaksi_keluar' => 'Id Transaksi Keluar',
            'id_barang' => 'Id Barang',
            'jumlah' => 'Jumlah',
        ];
    }
}
