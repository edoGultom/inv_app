<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pengembalian_barang".
 *
 * @property int $id
 * @property int|null $id_peminjaman_barang
 * @property int|null $jumlah
 * @property string|null $tanggal_pinjam
 * @property string|null $tanggal_kembali
 * @property int|null $terlambat
 * @property int|null $jumlah_denda
 */
class PengembalianBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengembalian_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_peminjaman_barang', 'jumlah', 'terlambat', 'jumlah_denda'], 'integer'],
            [['tanggal_pinjam', 'tanggal_kembali'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_peminjaman_barang' => 'Id Peminjaman Barang',
            'jumlah' => 'Jumlah',
            'tanggal_pinjam' => 'Tanggal Pinjam',
            'tanggal_kembali' => 'Tanggal Kembali',
            'terlambat' => 'Terlambat',
            'jumlah_denda' => 'Jumlah Denda',
        ];
    }
}
