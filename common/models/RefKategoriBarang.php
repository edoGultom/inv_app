<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_kategori_barang".
 *
 * @property int $id
 * @property string|null $kategori
 */
class RefKategoriBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_kategori_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori' => 'Kategori',
        ];
    }
    public function getJlhTipeKategori()
    {
        return Barang::find()->where([
            'id_kategori' => $this->id
        ])->count();
    }
    public function getLabel()
    {
        if($this->id==1){
            return '<span class="badge bg-indigo-light tx-indigo">'.$this->kategori.'</span>';
        }
        else{
            return '<span class="badge bg-success-light tx-success">'.$this->kategori.'</span>';
        }
    }
}
