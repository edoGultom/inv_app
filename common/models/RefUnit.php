<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_unit".
 *
 * @property int $id
 * @property string|null $nama_unit
 * @property string|null $cepat_kode
 */
class RefUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_unit'], 'string'],
            [['cepat_kode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_unit' => 'Nama Unit',
            'cepat_kode' => 'Cepat Kode',
        ];
    }
}
