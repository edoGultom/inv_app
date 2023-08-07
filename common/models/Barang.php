<?php

namespace common\models;

use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "barang".
 *
 * @property int $id
 * @property int|null $id_kategori
 * @property string|null $nama_barang
 * @property int|null $stok
 * @property string|null $keterangan
 */
class Barang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kategori', 'stok'], 'default', 'value' => null],
            [['id_kategori', 'stok'], 'integer'],
            [['nama_barang', 'keterangan'], 'string'],
        ];
    }
   

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kategori' => 'Id Kategori',
            'nama_barang' => 'Nama Barang',
            'stok' => 'Stok',
            'keterangan' => 'Keterangan',
        ];
    }
    public function getRefKategori()
    {
        return $this->hasOne(RefKategoriBarang::className(), ['id' => 'id_kategori']);
    }
    public function getIsUsulan()
    {
        return $this->hasOne(PengusulanBarang::className(), ['id_barang' => 'id'])->exists();
    }
    public function getDataKategori()
    {
        return ArrayHelper::map(RefKategoriBarang::find()->all(), 'id', 'kategori');
    }
}
